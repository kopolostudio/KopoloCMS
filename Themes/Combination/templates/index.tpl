{strip}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        {include file="head.tpl"}
    </head>
    <body>
        <div id="wrapper">
            <div id="header-wrapper">
                <div id="header">
                    <div id="logo">
                        {if !empty($params.company_name)}<h1><a href="/">{$params.company_name}</a></h1>{/if}
                        {if !empty($params.slogan)}<p>{$params.slogan}</p>{/if}
                    </div>
                    {$components.menu}
                </div>
            </div>
            <!-- end #header -->
            <div id="page">
                <div id="page-bgtop">
                    <div id="page-bgbtm">
                        <div id="content">
                            <div class="post">
                                {if !empty($page.pg_header)}
                                    <h2 class="title">{$page.pg_header}</h2>
                                {/if}
                                {include file="messages.tpl"}
                                <div class="entry">
                                    {$page.pg_info}
                                    {$components.content}
                                    <div style="clear: both;">&nbsp;</div>
                                </div>
                            </div>
                            {if count($textblocks.content)}
                                {include file="textblocks/content.tpl"}
                            {/if}
                            <div style="clear: both;">&nbsp;</div>
                        </div>
                        <!-- end #content -->
                        <div id="sidebar">
                            <ul>
                                <li>
                                    <div id="search" >
                                        <form method="post" action="/search/">
                                            <div>
                                                <input type="text" name="search" id="search-text" value="" />
                                                <input type="submit" id="search-submit" value="Найти" />
                                            </div>
                                        </form>
                                    </div>
                                    <div style="clear: both;">&nbsp;</div>
                                </li>
                                {include file="submenu.tpl"}
                                
                                {if count($textblocks.sidebar)}
                                    {include file="textblocks/sidebar.tpl"}
                                {/if}
                                
                                {if $components.last_news}
                                <li>
                                {$components.last_news}
                                </li>
                                {/if}
                            </ul>
                        </div>
                        <!-- end #sidebar -->
                        <div style="clear: both;">&nbsp;</div>
                    </div>
                </div>
            </div>
            <!-- end #page -->
            <div id="footer">
                <p>&copy; {if !empty($params.company_name)}{$params.company_name}{else}{$smarty.server.SERVER_NAME}{/if} 2011{if $smarty.now|date_format:"%Y" > 2011}&ndash;{$smarty.now|date_format:"%Y"}{/if} {if !empty($params.contacts)}| {$params.contacts} {/if}| Сайт работает на <a href="http://kopolocms.ru">KopoloCMS</a> | Дизайн от <a href="http://www.freecsstemplates.org/">CSS Templates</a>.
                </p>
            </div>
        </div>
    </body>
</html>
{/strip}