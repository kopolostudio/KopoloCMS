{* шаблон для отображения списка сайтов *}

{strip}
    <span id="site">
    {if count($sites) == 1}
        <span class="site">{$sites.0.st_name}</span>
    {elseif count($sites) > 1}
        <form action="" method="POST">
            <select name="site">
                {foreach from=$sites item=site}
                <option value="{$site.st_id}"{if $site.st_id == $current_site_id} selected="selected"{/if}>{$site.st_name}</option>
                {/foreach}
            </select>
        </form>
    {/if}
    </span>
{/strip}