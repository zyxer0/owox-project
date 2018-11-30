<form class="article" enctype="multipart/form-data">

    <div class="form-group row">
        <label class="col-sm-1 col-form-label">Название</label>
        <div class="col-sm-11">
            <input type="password" class="form-control" placeholder="Название">
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
                            <option value="{$a->id}">{$a->last_name|escape} {$a->first_name|escape}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
        {/if}
        {if $categories}
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-form-label">Название</label>
                    <select class="form-control" name="category_id">
                        <option value="0">Выберите категорию</option>
                        {foreach $categories as $c}

                            <option value="{$c->id}">{$c->name|escape}</option>
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
                <textarea name="text" class="fn_editor"></textarea>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="col-form-label">Изображение</label>
            </div>
        </div>
    </div>

    <div class="action_button">
        <button class="btn btn-primary" type="submit">Сохранить</button>
    </div>
</form>

{include 'tinymce_init.tpl'}