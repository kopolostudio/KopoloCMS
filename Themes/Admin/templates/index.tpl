{strip}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>{include file="head.tpl"}</head>
<body>
{include file="messages.tpl"}
{if isset($auth) && !isset($auth.user)}
    {include file="users/auth.tpl"}
{else}
    <div class="header">
        <div>
            <div class="left">
                {$components.site}
                <div class="cms_text">управление сайтом</div>
            </div>
        </div>
        {include file="user_panel.tpl"}
        {$components.top_menu}
    </div>
    <div class="clear"></div>
    <div class="content">
        {include file="content.tpl"}
    </div>
    <div class="footer">
        <div class="cms left">
            <a href="http://kopolocms.ru/"><img width="219" height="36" src="/Themes/Admin/i/logo.jpg" class="logo_img" /></a>
            <div class="version">версия {$smarty.const.KOPOLO_VERSION}</div>
        </div>
        <div class="item">
            <a href="/admin/module/RecycleBin/">
                <img width="48" height="48" src="/Files/admin/icons/trash/trash_48.png" />
                <div>Корзина</div>
            </a>
        </div>
        <div class="item">
            <a href="/admin/help/">
                <img width="48" height="48" src="/Files/admin/icons/help/help_48.png" />
                <div>Помощь</div>
            </a>
        </div>
    </div>
    <div class="clear"></div>

{/if}
</body>
</html>
{/strip}