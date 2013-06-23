{* шаблон рекурсивно выводит список связанных с элементом данных (модулей и позиций) *}
{strip}
<ul>
    {foreach from=$related_data key=modulename item=module}
    <li>
        <strong>{$modulename}</strong> ({$module.count})
        
        <ul>
        {foreach from=$module.items item=item}
            <li>
                {$item.name}
                {if count($item.related_data)}
                    {include file="actions/delete/related_data.tpl" related_data=$item.related_data}
                {/if}
            </li>
        {/foreach}
        </ul>
    </li>
    {/foreach}
</ul>
{/strip}