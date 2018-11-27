<?php

ini_set('max_execution_time', 0);

require '../vendor/autoload.php';

$db = App\DB\MySQLFactory::createDatabase();
$queryBuilder = App\DB\MySQLFactory::createQueryBuilder();

createTableArticles();
createTableAuthors();
createTableArticlesCategories();
generationAuthors();
generationTopics();
generationArticles();

function generationArticles()
{
    global $db, $queryBuilder;
    $faker = Faker\Factory::create("ru_RU");
    $query = $queryBuilder->select([
        'a.id',
        'a.name',
        'a.articles_count',
    ])
        ->from('categories_articles', 'a')
        ->getSQL();

    $db->makeQuery($query);
    $categories = [];
    while ($category = $db->resultActiveRecord(App\DB\ActiveRecord\Category::class)) {
        $categories[$category->id] = $category;
    }

    for ($i = 1; $i <= 500000; $i++) {
        $catId = $categories[rand(1, 36)]->id;
        $categories[$catId]->articles_count++;

        if (rand(0, 666) == 159) {
            $image = $faker->image(dirname(__DIR__) . '/images', 640, 480, 'cats', false);
        } else {
            $image = '';
        }

        $article = new App\DB\ActiveRecord\Article([
            'category_id'   => $catId,
            'author_id'     => rand(1, 5000),
            'name'          => $faker->realText(rand(10, 200), rand(1, 4)),
            'text'          => $faker->realText(rand(100, 1000), rand(1, 4)),
            'created'       => $faker->dateTimeBetween()->format('Y-m-d H:i:s'),
            'views_count'   => rand(1, 10000),
            'image'=>$image
        ]);
        $article->save();
        unset($article);
    }
    foreach ($categories as $category) {
        $category->update();
    }
}

function generationTopics()
{
    $names = ["Природа", "Животные","Зоопарки", "Цветы", "Растения", "Любовь", 'Романтика', "Мужчины","Женщины", "Дети", "Молодежь", "Быт", 'Расставание', "Дипрессия","Социум", "Города", "Путешествия", "Отношения", 'Спорт', "Игры","Соревнования", "Победы", "Разочарования", "Беременность", 'Больницы', "Болезни","Аптеки", "Дружба", "Вражда", "Эмоции", 'Наказание', "Тюрьма", "Мебель", "Богатство", "Деньги", "Знаменитости"];
    foreach ($names as $name) {
        $category = new App\DB\ActiveRecord\Category([
            'name'=>$name
        ]);
        $category->save();
    }
}

function generationAuthors()
{
    $faker = Faker\Factory::create("ru_RU");
    for ($i=1; $i <= 5000; $i++) {
        $author = new App\DB\ActiveRecord\Author([
            'first_name'=>$faker->firstName,
            'last_name'=>$faker->lastName,
        ]);
        $author->save();
        unset($author);
    }
}

function createTableArticles()
{
    global $db;
    $db->makeQuery("DROP TABLE IF EXISTS `articles`;");
    $query = "CREATE TABLE `articles` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `category_id` int(11) NOT NULL,
          `author_id` int(11) NOT NULL,
          `name` varchar(255) NOT NULL,
          `url` varchar(255) NOT NULL,
          `text` text NOT NULL,
          `image` varchar(255) NOT NULL,
          `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `views_count` int(11) NOT NULL DEFAULT '0',
          PRIMARY KEY (`id`),
          KEY `category_id` (`category_id`),
          KEY `url` (`url`),
          KEY `author_id` (`author_id`),
          KEY `created` (`created`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    $db->makeQuery($query);
}

function createTableAuthors()
{
    global $db;
    $db->makeQuery("DROP TABLE IF EXISTS `authors`;");
    $query = "CREATE TABLE `authors` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `first_name` varchar(255) NOT NULL,
          `last_name` varchar(255) NOT NULL,
          PRIMARY KEY (`id`),
          KEY `last_name` (`last_name`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    $db->makeQuery($query);
}

function createTableArticlesCategories()
{
    global $db;
    $db->makeQuery("DROP TABLE IF EXISTS `categories_articles`;");
    $query = "CREATE TABLE `categories_articles` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `name` varchar(255) NOT NULL,
          `articles_count` int(11) NOT NULL,
          PRIMARY KEY (`id`),
          KEY `articles_count` (`articles_count`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    $db->makeQuery($query);
}

