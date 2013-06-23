{strip}
    {* меню сайта (одноуровневое) *}
    {if count($menu)}
    <div id="menu">
        <ul>
            {foreach name="menu" from=$menu item="pg"}
                <li {if $pg.pg_id == $page.pg_id}class="current_page_item"{/if}>
                    <a href="{$lang_link}/{if $pg.pg_nick != 'first'}{$pg.pg_nick}/{/if}">
                        {$pg.pg_name}
                    </a>
                </li>
            {/foreach}
        </ul>
    </div>
    {/if}
{/strip}