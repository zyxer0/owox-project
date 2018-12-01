{include 'pagination.tpl'}
<div class="row">
    <div class="col-md-9">
        <form method="post" enctype="multipart/form-data" action="admin/article/remove">
            <a href="admin/article/add" class="btn btn-success">Добавить статью</a>
            <table class="articles_list">
                <rt>
                    <th class="check"></th>
                    <th class="image"></th>
                    <th class="name">
                        Название
                    </th>
                    <th class="action"></th>
                </rt>
                {foreach $articles as $a}
                    <tr class="article_row">
                        <td class="check">
                            <input name="id[]" value="{$a->id}" type="checkbox">
                        </td>
                        <td class="image">
                            <a href="/admin/article/edit/{$a->id}">
                                {if $a->image}
                                    <img src="images/articles/50x50/{$a->image|escape}">
                                {else}
                                    <img src="static/images/noimage.small.jpg">
                                {/if}
                            </a>
                        </td>
                        <td class="name">
                            <a href="/admin/article/edit/{$a->id}">{$a->name|escape}</a>
                        </td>
                        <td class="action">
                            <a href="/article/{$a->id}" target="_blank" title="Открыть на сайте">&rarr;</a>
                        </td>
                    </tr>
                {/foreach}
            </table>

            <div class="action_button">
                <input type="submit" class="btn btn-warning" name="delete" value="Удалить выбранные" />
            </div>

        </form>
    </div>
</div>
{include 'pagination.tpl'}
