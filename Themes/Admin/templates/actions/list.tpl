{strip}
{*if $is_tree}
    <div class="modes">Режим отображения списка:&nbsp;
        {if $mode == 'table'}
            таблица
        {else}
            <a href="{$uri}?module={$module}&action={$action}&mode=table">таблица</a>
        {/if}
        &nbsp;
        {if $mode == 'hierarchy'}
            иерархия
        {else}
            <a href="{$uri}?module={$module}&action={$action}&mode=hierarchy">иерархия</a>
        {/if}
    </div>
{/if*}
<div class="clear"></div>
<div class="list">
{if count($list) && count($definitions)}
    {include file="actions/list/`$mode`.tpl"}
{else}
    <p>Список пуст.</p>
{/if}
</div>
{/strip}