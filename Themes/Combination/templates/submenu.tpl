{* субменю сайта *}
{strip}
    {assign var='current_page_id' value=$page.pg_id}
    {assign var='current_page_parent_id' value=$page.pg_parent}
    {if count($menu.$current_page_id.children) || isset($menu.$current_page_parent_id.children.$current_page_id)}
        <li>
            {if count($menu.$current_page_id.children)}
                {assign var='parent_pg' value=$menu.$current_page_id}
            {else}
                {assign var='parent_pg' value=$menu.$current_page_parent_id}
            {/if}
            
            <h2>{$parent_pg.pg_name}</h2>
            <ul class="submenu">
                {foreach $parent_pg.children as $pg}
                    <li {if $pg.pg_id == $page.pg_id}class="active"{/if}>
                        <a href="{$lang_link}/{if $menu.$current_page_id.pg_nick != 'first'}{$parent_pg.pg_nick}/{$pg.pg_nick}/{/if}">
                            {$pg.pg_name}
                        </a>
                    </li>
                {/foreach}
            </ul>
        </li>
    {/if}
{/strip}