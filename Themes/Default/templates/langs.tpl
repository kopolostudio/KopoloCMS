{strip}
    {* список языковых версий сайта *}
    {if count($langs)}
        <ul class="lang">
        {foreach $langs as $lg}
            <li>
                <img src="{$lg.lang_picture}" alt="{$lg.lang_name|strip_tags|replace:'"':"'"}" width="16" height="11" />
                {if $lg.lang_nick == $lang}
                    {$lg.lang_name}
                {else}
                    {if $lg@first}
                        <a href="{$uri}">{$lg.lang_name}</a>
                    {else}
                        <a href="/{$lg.lang_nick}{$uri}">{$lg.lang_name}</a>
                    {/if}
                {/if}
            </li>
        {/foreach}
        </ul>
    {/if}
{/strip}
