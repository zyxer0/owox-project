{if $pagination}
    {foreach $pagination as $p}
        <{if $p.isLink}a href="{$p.url|escape}"{else}span{/if} class="{if $p.isActive}active{/if}">
            {$p.anchor}
        </{if $p.isLink}a{else}span{/if}>
    {/foreach}
{/if}