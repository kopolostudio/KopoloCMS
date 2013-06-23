{strip}
    {* сообщения для пользователя об успешности/неуспешности выполнения действий *}
    {if count($messages)}
        <div class="messages-box">
        {foreach from=$messages key=type item=array}
            {if count($array)}
                <div class="messages {$type}">
                {foreach from=$array item=message}
                    <span>{$message}</span>
                {/foreach}
                </div>
            {/if}
        {/foreach}
        </div>
    {/if}
{/strip}