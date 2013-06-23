{strip}

{if !isset($smarty.get.ajax)}{* костыль. необходимо вынести навигацию и заголовок в отдельный компонент *}
    {include file="actions/navigation.tpl"}


<div class="level level{$ancestor@total+1}">
    {if isset($action_data.title)}
        <span class="title">{$action_data.title}</span>
    {else}
        <span class="title capitalize">
            {$action_name}
        </span>
    {/if}
    <div class="comment">{$object->module_info}</div>
</div>

{/if}

{if isset($action)}
    {include file="actions/`$action`.tpl"}
{/if}

{/strip}