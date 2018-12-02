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