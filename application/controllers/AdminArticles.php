<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Router;
use App\DB\ActiveRecord\Article;
use App\Http\UploadedFile;
use App\Models\Authors;
use App\Models\Categories;

class AdminArticles extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->setCompileDir($this->config->get('rootDir') . 'compiled/admin');
        $this->view->setTemplateDir($this->config->get('rootDir') . 'application/view/admin');
    }

    /**
     * Просмотр списка стетей
     * method GET
     */
    public function showArticlesList($params = [])
    {
        $articles = $this->articlesModel->getArticlesList();
        $this->view->assign('title', 'Admin articles');
        $this->view->assign('description', 'Admin articles');
        $this->view->assign('keywords', 'Admin articles');
        $this->view->assign('articles', $articles['items']);
        $this->view->assign('pagination', $articles['pagination']);
        $this->response->setContent($this->view->render('articles.tpl'));
    }

    /**
     * Просмотр стетьи
     * method GET
     */
    public function showArticle($params = [])
    {
        if (!$article = $this->articlesModel->getArticleByID((int)$params['id'])) {
            Router::page404();
            exit;
        }

        $authorsInstance = new Authors();
        $authors = $authorsInstance->getAllAuthors();

        $categoriesInstance = new Categories();
        $categories = $categoriesInstance->getAllCategories();

        $this->view->assign('title', 'Update '. $article->name);
        $this->view->assign('article', $article);
        $this->view->assign('authors', $authors);
        $this->view->assign('categories', $categories);
        $this->response->setContent($this->view->render('update_article.tpl'));
    }

    /**
     * Обновление статьи
     * method POST
     */
    public function updateArticle($params = [])
    {
        $categoriesInstance = new Categories();
        if (!$article = $this->articlesModel->getArticleByID((int)$params['id'])) {
            Router::page404();
            exit;
        }
        $image = null;

        // Если изменилась категория, нужно отнять её у текущей, и добавить к новой
        $newCategoryId = $this->request->request->get('category_id', 0);
        if ($article->category_id > 0 && $article->category_id != $newCategoryId) {
            $category = $categoriesInstance->getCategoryBuId($article->category_id);
            $category->articles_count--;
            $category->update();
            unset($category);
        }

        if ($article->category_id != $newCategoryId && $newCategoryId > 0) {
            $category = $categoriesInstance->getCategoryBuId($newCategoryId);
            $category->articles_count++;
            $category->update();
        }

        $article->author_id     = $this->request->request->get('author_id');
        $article->category_id   = $this->request->request->get('category_id');
        $article->name          = $this->request->request->get('name');
        $article->text          = $this->request->request->get('text');

        //Обнулим просмотры
        $article->views_count = 0;

        $imagesPath = $this->config->get('rootDir') . $this->config->get('articlesImagesPath');
        // Удаление изображения если нажали удалить или загружают новое
        if (($this->request->request->get('delete_image', 0) == 1
            || ($image = $this->request->files->get('image')))
            && $article->image) {
            $currentImage = new UploadedFile($imagesPath, $article->image);
            $currentImage->remove();
            $article->image = '';
        }

        //Загрузка изображения
        if ($image) {
            $article->image = $image->getUniqueName($imagesPath);
            $image->move($imagesPath, $article->image);
        }

        $article->update();
        $this->response->headers->set('Location', '/admin/article/edit/' . $article->id);
    }

    /**
     * Создание пустой формы добавления статьи
     * method GET
     */
    public function prepareAddArticle($params = [])
    {
        // TODO Service Locator
        $authorsInstance = new Authors();
        $authors = $authorsInstance->getAllAuthors();

        $categoriesInstance = new Categories();
        $categories = $categoriesInstance->getAllCategories();

        $this->view->assign('title', 'New article');
        $this->view->assign('authors', $authors);
        $this->view->assign('categories', $categories);
        $this->response->setContent($this->view->render('add_article.tpl'));
    }

    /**
     * Добавления статьи
     * method POST
     */
    public function addArticle($params = [])
    {
        $categoriesInstance = new Categories();
        $article = new Article($this->request->request->all());
        //Обнулим просмотры
        $article->views_count = 0;

        //Загрузка изображения
        if ($image = $this->request->files->get('image')) {
            $imagesPath = $this->config->get('rootDir').$this->config->get('articlesImagesPath');
            $article->image = $image->getUniqueName($imagesPath);
            $image->move($imagesPath, $article->image);
        }

        if ($article->category_id > 0) {
            $category = $categoriesInstance->getCategoryBuId($article->category_id);
            $category->articles_count++;
            $category->update();
        }

        $article->save();

        $this->response->headers->set('Location', '/admin/article/edit/' . $article->id);
    }

    /**
     * Удаление статьи
     * method POST
     */
    public function removeArticle($params = [])
    {
        $categoriesInstance = new Categories();
        $ids = $this->request->request->get('id');
        foreach ($ids as $id) {
            $article = $this->articlesModel->getArticleByID($id);
            if ($article->category_id > 0) {
                $category = $categoriesInstance->getCategoryBuId($article->category_id);
                $category->articles_count--;
                $category->update();
            }
            $article->delete();
        }

        $this->response->headers->set('Location', '/admin/articles');
    }
}
