{strip}
<div class="item">
{if $item && count($definitions)}
    <table>
    {foreach from=$definitions key=field_name item=def}
        {assign var="value" value=$item.$field_name}
        
        {if !empty($value)}
            <tr>
                <td class="name">
                    {if !empty($def.title)}{$def.title}{else}{$field_name}{/if}
                </td>
                <td class="value">
                    {if $def.quickfield == 'position'}
                        {$value}
                    {elseif $def.form.type == 'select'}
                        {$def.form.options.$value}
                    {elseif $def.form.type == 'picture'}
                        <center>{resize file=$value width=160 height=120}</center>
                    {elseif $def.form.type == 'checkbox'}
                        {$def.form.options.$value}
                    {elseif $def.form.type == 'date'}
                        {$value|date_format:"%d.%m.%Y"}
                    {elseif $def.form.type == 'datetime'}
                        {$value|date_format:"%d.%m.%Y %H:%I"}
                    {else}
                        {$value}
                    {/if}
                </td>
            </tr>
        {/if}
    {/foreach}
    </table>
{else}
    <p>Произошла ошибка, позиция не может отображена.</p>
{/if}
</div>
{/strip}