<div class="row">
    <div class="col-md-3">
        <div class="sidebar">
            {if $authors}
            <div class="list-group">
                <a class="list-group-item active">
                    Авторы
                </a>
                <div class="seo-tags-area">
                    {foreach $authors as $a}
                        <a class="list-group-item">{$a->last_name|escape} {$a->first_name|escape}</a>
                    {/foreach}
                </div>
            </div>
            {/if}
            {if $articlesDates}
            <div class="list-group">
                <a class="list-group-item active">
                    Даты публикаций
                </a>
                <div class="seo-tags-area">
                    {foreach $articlesDates as $d}
                        <a class="list-group-item">{$d|escape}</a>
                    {/foreach}
                </div>
            </div>
            {/if}
            {if $categories}
            <div class="list-group">
                <a class="list-group-item active">
                    Темы статей
                </a>
                <div class="seo-tags-area">
                    {foreach $categories as $c}
                        <a class="list-group-item">{$c->name|escape} ({$c->articles_count|escape})</a>
                    {/foreach}
                </div>
            </div>
            {/if}
        </div>
    </div>
    <div class="col-md-9">
        <div class="row">
            <div class="articles_list">
            {foreach $articles as $a}
                {include 'tiny_article.tpl'}
            {/foreach}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {include 'pagination.tpl'}
            </div>
        </div>
    </div>
</div>