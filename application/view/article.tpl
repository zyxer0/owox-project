<h1>{$article->name|escape}</h1>
<div class="image">
    {if $article->image}
        <img src="images/articles/800x600/{$article->image|escape}">
    {else}
        <img src="static/images/noimage.small.jpg">
    {/if}
</div>

{if $article->text}
<div class="text">
    {$article->text}
</div>
{/if}