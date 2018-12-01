<form class="article" enctype="multipart/form-data" method="post" action="admin/article/update/{$article->id}">

    <div class="form-group row">
        <label class="col-sm-1 col-form-label">Название</label>
        <div class="col-sm-11">
            <input type="text" class="form-control" name="name" placeholder="Название" value="{$article->name|escape}">
        </div>
    </div>

    <div class="row">
        {if $authors}
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-form-label">Автор</label>
                    <select class="form-control" name="author_id">
                        <option value="0">Выберите автора</option>
                        {foreach $authors as $a}
                            <option value="{$a->id}" {if $a->id == $article->author_id}selected{/if}>{$a->last_name|escape} {$a->first_name|escape}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
        {/if}
        {if $categories}
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-form-label">Категория статьи</label>
                    <select class="form-control" name="category_id">
                        <option value="0">Выберите категорию</option>
                        {foreach $categories as $c}
                            <option value="{$c->id}" {if $c->id == $article->category_id}selected{/if}>{$c->name|escape}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
        {/if}
    </div>

    <div class="row">
        <div class="col-sm-8">
            <div class="form-group">
                <label class="col-form-label">Описание</label>
                <textarea name="text" class="fn_editor">{$article->text}</textarea>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="article_image" class="col-form-label">Изображение</label>
                <input type="file" class="form-control" name="image" id="article_image">
            </div>
            {if $article->image}
                <div class="fn_article_image article_image form-control">
                    <img src="images/articles/360x360/{$article->image|escape}" />
                    <button type="button" class="delete_image" title="Удалить изображение"
                            onclick="$('.fn_delete_image').attr('disabled', false); $('.fn_article_image').hide();">
                    </button>
                    <input name="delete_image" class="fn_delete_image" value="1" type="hidden" disabled />
                </div>
            {/if}
        </div>
    </div>

    <div class="action_button">
        <button class="btn btn-primary" type="submit">Сохранить</button>
    </div>
</form>

{include 'tinymce_init.tpl'}