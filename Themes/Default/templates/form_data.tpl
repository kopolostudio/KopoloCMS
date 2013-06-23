{strip}
<table celpadding="5" border="0">
    {foreach from=$elements item="label" key="name"}
        {if $name != 'pass1' && $values.$name != false}
            <tr><td><b>{$label}</b></td><td>{$values.$name}</td></tr>
        {/if}
    {/foreach}
</table>
{/strip}