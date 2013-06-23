{strip}
{* Шаблон новости, для контроллера Controller_News_Archive *}

<div class="news">
    {if !empty($item.ns_picture)}
    <div class="picture">{resize file=$item.ns_picture width=200 height=200}</div>
    {/if}
    {if !empty($item.ns_announce)}
    <div class="announce">{$item.ns_announce}</div>
    {/if}
    <div class="info">{$item.ns_info}</div>
    <div class="date">{human_date timestamp=$item.ns_date}</div>
    {if !empty($item.ns_author)}
    <div class="author">{$item.ns_author}</div>
    {/if}
    {if !empty($item.ns_source)}
    <div class="source">{$item.ns_source}</div>
    {/if}
</div>

{/strip}