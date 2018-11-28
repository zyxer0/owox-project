<div class="col-md-3 article_item">
    <div class="img-thumbnail image">
        <a href="article/{$a->id|escape}">
            {if $a->image}
                <img src="images/articles/180x180/{$a->image|escape}">
            {else}
                <img src="static/images/noimage.small.jpg">
            {/if}
        </a>
    </div>
    <div class="article_name">
        <a class="" href="article/{$a->id|escape}">{$a->name|escape}</a>
    </div>
</div>