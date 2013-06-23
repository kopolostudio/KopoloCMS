{strip}
<div class="delete">
{if $item}
    <p>
        {assign var=name_field value=$object->name_field}
        {assign var=id_field value=$object->id_field}
        Вы уверены, что хотите удалить позицию: {if !empty($itemname)}<span class="itemname">{$itemname}</span>{/if} {if !empty($item.$name_field)}&laquo;{$item.$name_field}&raquo;{else}ID{$item.$id_field}{/if}?
    </p>
    
    {if count($related_data)}
    <div class="related_data">
        Также будут удалены связанные данные:
        {include file="actions/delete/related_data.tpl"}
    </div>
    {/if}
    
    <div class="buttons">
        <form action="{$full_uri}&delete=1" method="POST" class="form">
            <button type="submit">Да, удалить</button>
        </form>
        
        <form action="{$uri}?module={$module}" method="POST" class="form">
            <button type="submit">Нет, отмена</button>
        </form>
    </div>
{else}
    <p>Произошла ошибка, позиция не может быть удалена.</p>
{/if}
</div>
{/strip}