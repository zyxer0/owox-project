<div class="row">
    <div class="col-md-3">
        <div class="sidebar">
            {if $authors}
            <div class="list-group">
                <a href="#" class="list-group-item active">
                    Авторы
                </a>
                <div class="seo-tags-area">
                    {foreach $authors as $a}
                        <a href="#" class="list-group-item">{$a->last_name|escape} {$a->first_name|escape}</a>
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
    </div>
</div>