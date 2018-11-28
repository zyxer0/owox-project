<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="articles_list">
            {foreach $articles as $a}
                {include 'tiny_article.tpl'}
            {/foreach}
            </div>
        </div>
    </div>
</div>
{include 'pagination.tpl'}