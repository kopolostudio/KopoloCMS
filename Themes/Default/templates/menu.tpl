{strip}
    {* меню сайта (двухуровневое) *}
    {if count($menu)}
    <ul>
        {foreach name="menu" from=$menu item="pg"}
            <li class="{if $pg.pg_id == $page.pg_id}active{/if}{if $pg@first} first{elseif $pg@last} last{/if}{if count($pg.children)} parent{/if}">
                <a href="{$lang_link}/{if $pg.pg_nick != 'first'}{$pg.pg_nick}/{/if}">
                    <span>{$pg.pg_name}</span>
                </a>
                {if count($pg.children)}
                    <ul class="submenu">
                        {foreach $pg.children as $subpg}
                            <li class="{if $subpg.pg_id == $page.pg_id}active{/if}{if $subpg@first} first{elseif $subpg@last} last{/if}">
                                <a href="{$lang_link}/{if $pg.pg_nick != 'first'}{$pg.pg_nick}/{/if}{$subpg.pg_nick}/">
                                    <span>{$subpg.pg_name}</span>
                                </a>
                            </li>
                        {/foreach}
                    </ul>
                {/if}
            </li>
        {/foreach}
    </ul>
    {/if}
{/strip}