{strip}
{* действия (список ссылок на действия объекта) *}
{if count($actions)}
    <div class="actions">
        {foreach from=$actions item=act name=actions}
            <nobr>
            <a href="{include file="actions/action_link.tpl"}" title="{$act.title}{if $item.$name_field} «{$item.$name_field}»{/if}">
                <img hspace="3" align="absmiddle" vspace="3" src="/Themes/Admin/i/icons/{if isset($act.icon)}{$act.icon}{else}{$act.action}{/if}.png">
                <span>{$act.name}</span>
            </a>
            </nobr>
            {if !$smarty.foreach.actions.last}
                {$separator}
            {/if}
        {/foreach}
    </div>
{/if}
{/strip}