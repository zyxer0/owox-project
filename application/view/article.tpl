<div class="row">
    <div class="col-sm-12">
        <h1>{$article->name|escape}</h1>
    </div>
    <div class="col-sm-7 image">
        {if $article->image}
            <img src="images/articles/800x600/{$article->image|escape}">
        {else}
            <img src="static/images/noimage.small.jpg">
        {/if}
    </div>
    <div class="col-sm-5">
        <p>
            Просмотров: {$article->views_count|escape}
        </p>
        {if $category}
        <p>
            Категория: {$category->name|escape}
        </p>
        {/if}
        {if $author}
        <p>
            Автор: {$author->last_name|escape} {$author->first_name|escape}
        </p>
        {/if}
        <p>
            Создано: {$article->created}
        </p>
    </div>
</div>

{if $article->text}
<div class="row">
    <div class="col-sm-12">
        <div class="text">
            {$article->text}
        </div>
    </div>
</div>
{/if}

{if $topArticles}
<div class="row">
    <div class="col-md-12">
        <h3>Топ статей категории "{$category->name|escape}"</h3>
    </div>
    <div class="articles_list">
        {foreach $topArticles as $a}
            {include 'tiny_article.tpl'}
        {/foreach}
    </div>
</div>
{/if}