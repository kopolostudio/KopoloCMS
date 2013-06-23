{strip}
{* Архив новостей, для контроллера Controller_News_Archive *}
{if $item}
    {include file="news/item.tpl"}
{else}
    {if $items}
    <div class="announces">
        {foreach name="news" from=$items item="item"}
            <div class="announce">
                <div class="date">{human_date timestamp=$item.ns_date}</div>
                <h3><a href="/news/{$item.ns_id}/">{$item.ns_name}</a></h3>
                <p>{$item.ns_announce}</p>
            </div>
        {/foreach}
        {if $pager->links}
        <div class="pagination">
            <span>Страницы:</span>
            {$pager->links}
        </div>
        {/if}
    {else}
        <p>Новостей нет.</p>
    {/if}
    </div>
{/if}
{/strip}