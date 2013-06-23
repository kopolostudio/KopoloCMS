{strip}
    {if count($unregistered_modules)}
        <div class="new_modules">
            <h2>Незарегистрированные модули</h2>
            <form action="" method="post">
                <input type="hidden" name="add_modules" value="1"/>
                {foreach from=$unregistered_modules item=module}
                    <div class="element">
                        <input type="checkbox" name="modules[{$module}]" id="{$module}"/>
                        <label for="{$module}">{$module}</label>
                    </div>
                {/foreach}
                <button type="submit">Добавить</button>
            </form>
        </div>
    {else}
        <p>Нет модулей для регистрации.</p>
    {/if}
{/strip}