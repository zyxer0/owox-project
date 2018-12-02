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