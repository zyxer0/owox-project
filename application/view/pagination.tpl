{if $pagination}
    <ul class="pagination">
        {foreach $pagination as $p}
            <li class="{if $p.isActive}active{/if}">
                <{if $p.isLink}a href="{$p.url|escape}"{else}span{/if} class="">
                    {$p.anchor}
                    </{if $p.isLink}a{else}span{/if}>
            </li>
        {/foreach}
    </ul>
{/if}