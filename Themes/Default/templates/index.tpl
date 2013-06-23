{strip}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        {include file="head.tpl"}
    </head>
    <body>
        <div class="wrapper">
            <div class="header">
                <div class="logo">
                    {if !empty($params.logo)}<div class="picture">{resize file=$params.logo height=50 width=220}</div>{/if}
                    <a href="/">{$params.company_name}</a>
                    {if !empty($params.slogan)}<div class="slogan">{$params.slogan}</div>{/if}
                </div>
                
                <div class="search">
                    <form action="/search/" method="post">
                        <input type="text" name="search" value="" />
                        <button type="submit">Найти</button>
                    </form>
                </div>
                <div class="menu">
                    {$components.menu}
                </div>
            </div>
            <div class="page">
                <div class="content">
                    {if !empty($page.pg_header)}
                        <h1>{$page.pg_header}</h1>
                    {/if}
                    {include file="messages.tpl"}
                    {$page.pg_info}
                    {$components.content}
                    {if count($textblocks.content)}
                        {include file="textblocks/content.tpl"}
                    {/if}
                </div>
                <div class="right">
                    {if count($textblocks.sidebar)}
                        {include file="textblocks/sidebar.tpl"}
                    {/if}
                    {$components.last_news}
                </div>
            </div>
            <div class="footer">
                <div class="copyright">
                    &copy; {if !empty($params.company_name)}{$params.company_name}{else}{$smarty.server.SERVER_NAME}{/if} 2011{if $smarty.now|date_format:"%Y" > 2011}&ndash;{$smarty.now|date_format:"%Y"}{/if}
                </div>
                <div class="contacts">
                    {$params.contacts}
                </div>
                <div class="cms">
                    Сайт работает на <a href="http://kopolocms.ru">KopoloCMS</a>
                </div>
            </div>
        </div>
    </body>
</html>
{/strip}