{* выбор темы оформления сайта *}
{strip}
    {if count($themes)}
        <div class="themes">
        {foreach $themes as $theme}
            <div class="theme">
                <div class="title">{$theme.name}{if $theme.name == $current_theme} <span>(выбрана)</span>{/if}</div>
                
                <div class="preview">
                {if isset($theme.preview)}
                    <a href="{$theme.preview}" rel="fb" title="{$theme.name}">
                        {resize file=$theme.preview width=200 height=180}
                    </a>
                {else}
                    <br /><br /><br /><br />Нет изображения.
                {/if}
                </div>
                
                <form action="" method="post" class="form">
                    <input type="hidden" name="theme" value="{$theme.name}" />
                    <button>Установить</button>
                </form>
            </div>
        {/foreach}
            <div class="clear"></div>
        </div>
    {/if}
{/strip}