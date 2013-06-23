{strip}
    {if count($modules)}
    <div class="modules_menu">
        {assign var='current_group' value=$modules.0.md_group}
        <div class="title">{$groups.$current_group}</div>
        
        {foreach $modules as $item}
            {if $item.md_group != $current_group}
                {assign var='current_group' value=$item.md_group}
                <div class="title">{$groups.$current_group}</div>
                
                {* костыль для вставки ссылок на обчные страницы (с компонентами) *}
                {if $current_group == 2}
                    <div class="module">
                        <a href="/admin/select-theme/" title="Изменение темы оформления">
                            <img src="/Files/admin/icons/themes/themes_48.png" alt="Изменение темы оформления" />
                            <span>Изменение темы</span>
                        </a>
                    </div>
                {/if}
                {if $current_group == 4}
                    <div class="module">
                        <a href="/admin/register_module/" title="Регистрация нового модуля">
                            <img src="/Files/admin/icons/gear/gear_48.png" alt="Регистрация модуля" />
                            <span>Регистрация модуля</span>
                        </a>
                    </div>
                {/if}
                
            {/if}
            <div class="module">
                <a href="/admin/module/{$item.md_nick}/" title="{$item.md_comment}">
                    <img src="/Files/admin/icons/{$item.md_icon_group}/{$item.md_icon_group}_48.png" alt="{$item.md_name}" />
                    <span>{$item.md_name}</span>
                </a>
            </div>
        {/foreach}
    </div>
    {/if}
{/strip}