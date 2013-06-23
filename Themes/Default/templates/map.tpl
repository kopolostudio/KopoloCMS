{strip}
    {if count($map)}
        {if !isset($parent)}
            {assign var="parent" value=""}
        {/if}
        <ul>
        {foreach name="map" from=$map item="pg"}
                <li>
                    <a href="/{if $pg.pg_nick != 'first'}{$parent}{$pg.pg_nick}/{/if}">
                        {$pg.pg_name}
                    </a>
                    {if count($pg.children)}
                        {include file="map_links.tpl" map=$pg.children parent="`$parent``$pg.pg_nick`/"}
                    {/if}
                </li>
        {/foreach}
        </ul>
    {/if}
{/strip}