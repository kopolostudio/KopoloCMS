{* Навигационная цепочка для действий *}
{strip}
{literal}
<style>
    .ancestors .level {
        float:left;
        margin:0px !important;
        position:relative;
        padding-bottom:10px;
    }
    .ancestors .level .actions {
        display:none;
        position:absolute;
        background:#FFF;
        border:1px solid #F1F1F1;
        padding:5px;
    }
    
    .ancestors .level span.item_name {
        padding-left:5px;
        font-size:11px;
        text-transform:lowercase;
    }
    
    .ancestors .separator {
        float:left;
        padding:3px 10px;
        font-size:11px;
    }
</style>
<script>
    $(document).ready(function(){
        $('div.level').each(function(i){
        var actions = $(this).find('div.actions');
        $(this).mouseenter(function(){
                actions.fadeIn(300);
            }).mouseleave(function(){
                actions.fadeOut(300);
            });
        });
    });
</script>
{/literal}

{if count($ancestors)} 
    <div class="ancestors">
        <div class="level">
            <a href="/admin/">Главное меню</a>
        </div>
        {foreach $ancestors as $ancestor}
        <div class="separator">></div>
        <div class="level">
            {assign var="name_field" value=$ancestor->name_field}
            {assign var="id_field" value=$ancestor->id_field}
            {if !empty($ancestor->$id_field)}
                <a href="{include file="actions/action_link.tpl" act=$ancestor->for_each_actions.0 object=$ancestor item=$ancestor->toArray() addid=true}" class="name" title="{$ancestor->for_each_actions.0.title} «{$ancestor->$name_field}»">
                    {$ancestor->$name_field}
                </a>
                {if strlen($ancestor->item_name)}<span class="item_name">({$ancestor->item_name})</span>{/if}
                {include file="actions/actions.tpl" actions=$ancestor->for_each_actions object=$ancestor item=$ancestor->toArray() addid=true}
            {else}
                <a href="{include file="actions/action_link.tpl" act=$ancestor->actions.0 object=$ancestor item=$ancestor->toArray()}" class="name" title="{$ancestor->for_each_actions.0.title}">
                    {$ancestor->module_name}
                </a>
                {include file="actions/actions.tpl" actions=$ancestor->actions object=$ancestor item=$ancestor->toArray()}
            {/if}
        </div>
        {/foreach}
        <div class="clear"></div>
    </div>
{else}
    {* текущий модуль - общая информация *}
    <div class="level level1">
        <span class="title">{$object->module_name}</span>
        {include file="actions/actions.tpl" actions=$object->actions object=$object}
    </div>
{/if}
{/strip}