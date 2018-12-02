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