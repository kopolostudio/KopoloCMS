{strip}
{* Список последних новостей, для контроллера Controller_News_Last *}
{if $items}
    <div class="block news">
        <h2><a href="/news/">Новости</a></h2>
        <ul class="info-list">
            {foreach name="news" from=$items item="item"}
                <li>
                    <div class="date">{human_date timestamp=$item.ns_date}</div>
                    <a href="/news/{$item.ns_id}/">{$item.ns_name}</a>
                </li>
            {/foreach}
        </ul>
    </div>
{/if}
{/strip}