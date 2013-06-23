{strip}
{*шаблон вывода результатов поиска для контроллера Search*}

<div class="search_results">
    <h4>Вы искали &laquo;{$search_text}&raquo;</h4>

    {if $count_items > 0}
        <p>Найдено страниц: {$count_items}</p>
        {foreach from=$items name=search item=si}
        <div class="item_result">
            <p>
                <a href="{$si.si_uri}">{$si.si_name}</a><br />
                {$si.si_info}
            </p>
        </div>
        {/foreach}
        {if $pager->links}
        <div class="pager">
            Страницы: {$pager->links}
        </div>
        {/if}
    {else}
        <p>Поиск не дал результатов, попробуйте по-другому сформулировать свой запрос.</p>
    {/if}
</div>
{/strip}