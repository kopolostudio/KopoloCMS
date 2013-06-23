{* Навигационная цепочка для действий *}
{strip}
{if count($ancestors)} 
    {foreach $ancestors as $ancestor}
    <div class="level level{$ancestor@iteration}">
        {assign var="name_field" value=$ancestor->name_field}
        {assign var="id_field" value=$ancestor->id_field}
        {if !empty($ancestor->$id_field)}
            <span class="title">
                {$ancestor->$name_field}
                {if strlen($ancestor->item_name)}<span class="small">({$ancestor->item_name})</span>{/if}
            </span>
            {include file="actions/actions.tpl" actions=$ancestor->for_each_actions object=$ancestor item=$ancestor->toArray() addid=true}
        {else}
            <span class="title">{$ancestor->module_name}</span>
            {include file="actions/actions.tpl" actions=$ancestor->actions object=$ancestor item=$ancestor->toArray()}
        {/if}
    </div>
    {/foreach}
{else}
    {* текущий модуль - общая информация *}
    <div class="level level1">
        <span class="title">{$object->module_name}</span>
        {include file="actions/actions.tpl" actions=$object->actions object=$object}
    </div>
{/if}
{/strip}