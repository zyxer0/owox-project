<div class="row">
    <div class="col-md-9">
        <div class="row">
            <div class="articles_list">
                {foreach $articles as $a}
                    {include 'tiny_article.tpl'}
                {/foreach}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {include 'pagination.tpl'}
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="sidebar">
            <div class="fn_authors_sidebar"></div>
            <div class="fn_dates_publishers_sidebar"></div>
            <div class="fn_categories_sidebar"></div>
        </div>
    </div>
</div>