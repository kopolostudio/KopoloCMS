{strip}

{if $current_version}
<p>Версия системы: {$current_version}</p>
{/if}

{*Успешная установка*}
{if $installed_successfully==true}
    <p>Ваша система успешно обновлена до версии: {$new_version}</p>
{/if}

{*Успешная загрузка*}
{if $download_successful}
    <p>Обновление успешно загруженно</p>
    <p><img src="/Themes/Admin/i/ajax-loader.gif" /> Установка продолжается, подождите пожалуйста</p>
    <p><br /></p>
    <script type="text/javascript">
        $(document).ready(function(){
            setTimeout(function(){
                $('#update-form').submit();
            },1000);
        });
    </script>
    <form method="post" target="" style="" id="update-form">
        Если длительное время ничего не происходит нажмите кнопку:
        <button type="submit">Установить</button>
        <input type="hidden" name="install-update-version" value="{$download_successful.version}" />
    </form>
{/if}

{if $download_unsuccessful}
    <p>При загрузке обновления возникли ошибки:</p>
    {foreach $download_unsuccessful.messages as $message}
        <div class="{$message.status}">
            {$message.text}
        </div>
    {/foreach}
    {if $download_unsuccessful.continuation_is_possible==true}
        <p>Дальнейшая установка системы возможна, но рекомендуется загрузить обновление заново</p>
    {else}
        <p>Дальнейшая установка системы невозможно, загрузите обновление заново</p>
    {/if}
    <div style="width: 600px;">
    <form method="post" target="" style="float: left;">
        <button type="submit">Загрузить заново</button>
        <input type="hidden" name="download-update-version" value="{$download_unsuccessful.version}" />
    </form>
    {if $download_unsuccessful.continuation_is_possible==true}
    <form method="post" target="" style="float: right;">
        <button type="submit">все равно установить</button>
        <input type="hidden" name="install-update-version" value="{$download_unsuccessful.version}" />
    </form>
    {/if}
    </div>

    <div class="clear"></div>
    
{/if}

{*Прерванное обновление*}
{if $interrupted_update}
    <p>При подготовке к обновлению возникли ошибки:</p>
    {foreach $interrupted_update.messages as $message}
        <div class="{$message.status}">
            {$message.text}
        </div>
    {/foreach}
    <p>Вы можете попытаться устранить ошибки, либо продолжить установку на свой страх и риск</p>
    <form method="post" target="" style="float: left;">
        <button type="submit">Продолжить установку, несмотря на ошибки</button>
        <input type="hidden" name="install-update-version" value="{$interrupted_update.version}" />
        <input type="hidden" name="install-skip-requirements" value="1" />
    </form>
{/if}

{*Список обновлений доступных для загрузки и установки*}
{if $updates_info && count($updates_info)}
    <p>Найдены обновления для загрузки и установки:</p>
    <div class="list">
    <table class="updates_table">
    <tr>
        <th>Версия</th>
        <th>Описание</th>
        <th></th>
    </tr>
    {foreach from=$updates_info name=updates_info item=info}
        <tr {if $smarty.foreach.updates_info.index is even}class="even"{/if}>
            <td>{$info.version}</td>
            <td>
            {if $info.ready_to_install}
                <p><b>Обновление загружено и готово к установке</b></p>
            {/if}
            {$info.description}
            </td>
            <td>
                
                    {if $info.ready_to_install}
                        {if $info.wronghash}
                            <p class="error">Обнаружено несоответствие контрольной суммы пакета</p>
                            <form method="post" target="" style="float: left;">
                                <button type="submit">Загрузить заново</button>
                                <input type="hidden" name="download-update-version" value="{$info.version}" />
                            </form>
                            <form method="post" target="" style="float: right;">
                                <button type="submit">все равно установить</button>
                                <input type="hidden" name="install-update-version" value="{$info.version}" />
                            </form>

                            <div class="clear"></div>
                        {else}
                            <form method="post" target="">
                                <button type="submit">Установить</button>
                                <input type="hidden" name="install-update-version" value="{$info.version}" />
                            </form>
                        {/if}
                    {else}
                    <form method="post" target="">
                        <button type="submit">Загрузить и установить</button>
                        <input type="hidden" name="download-update-version" value="{$info.version}" />
                    </form>
                    {/if}
                
            </td>
        </tr>
    {/foreach}
    </table>
    </div>
{elseif !$interrupted_update && !$download_successful && !$download_unsuccessful}
    <p>Не найдено доступных обновлений</p>
{/if}

{/strip}