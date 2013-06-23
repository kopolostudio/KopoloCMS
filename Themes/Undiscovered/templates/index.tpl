{strip}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        {include file="head.tpl"}
    </head>
    <body>
        <div id="header">
            <a href="/">
                {if !empty($params.logo)}
                    {resize file=$params.logo height=77}
                {else}
                    <img id="logo" src="/Themes/Undiscovered/i/logo.gif" alt="{$params.company_name|strip_tags|replace:'"':"'"}" />
                {/if}
            </a>
            {$components.menu}
            {if !empty($params.company_name)}<h1><a href="/">{$params.company_name}</a></h1>{/if}
            {if !empty($params.slogan)}<p id="subtitle">{$params.slogan}</p>{/if}
            <form id="search" method="post" action="/search/">
                <input type="text" class="text" name="search" />
                <input type="submit" class="submit" value="Поиск" />
            </form>
        </div>
        <div id="main"><div id="main2">
            <div id="sidebar">
                {include file="submenu.tpl"}
                
                {if count($textblocks.sidebar)}
                    {include file="textblocks/sidebar.tpl"}
                {/if}
                
                {$components.last_news}
            </div>
            <div id="content">
                <div class="post">
                    {if !empty($page.pg_header)}
                        <h2>{$page.pg_header}</h2>
                    {/if}
                    {include file="messages.tpl"}
                    <div class="entry">
                        {$page.pg_info}
                        {$components.content}
                    </div>
                </div>
                {if count($textblocks.content)}
                    {include file="textblocks/content.tpl"}
                {/if}
            </div>
            <div class="clearing">&nbsp;</div>
        </div></div>
        <div id="footer">
            <p>&copy; {if !empty($params.company_name)}{$params.company_name}{else}{$smarty.server.SERVER_NAME}{/if} 2011{if $smarty.now|date_format:"%Y" > 2011}&ndash;{$smarty.now|date_format:"%Y"}{/if} {if !empty($params.contacts)}| {$params.contacts}{/if}</p>
            <p class="dev">Сайт работает на <a href="http://kopolocms.ru">KopoloCMS</a>, дизайн от <a href="http://www.webtemplateocean.com/">WebTemplateOcean.com</a></p>
        </div>
    </body>
</html>
{/strip}