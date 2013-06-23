{strip}
<div class="delete">
    <p>
        {assign var=name_field value=$object->name_field}
        {assign var=id_field value=$object->id_field}
        Вы уверены, что хотите очистить корзину? {$count} {word_form count=$count one='позицию' four='позиции' many='позиций'} будут безвозвратно удалены.
    </p>
    
    <div class="buttons">
        <form action="{$full_uri}&clear=1" method="POST" class="form">
            <button type="submit">Да, очистить</button>
        </form>
        
        <form action="{$uri}?module={$module}" method="POST" class="form">
            <button type="submit">Нет, отмена</button>
        </form>
    </div>
</div>
{/strip}