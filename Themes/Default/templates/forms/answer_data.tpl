{* шаблон строит таблицу с вопросами формы и ответами пользователя (Module_Forms->getHTML) *}
{strip}
{if count($values) && count($fields)}
<table celpadding="5" border="0">
    {foreach $fields as $field}
        {assign var=field_id value=$field.fd_id}
        {if !empty($values.fields.$field_id) && $field.fd_type != 'captcha'}
            <tr>
                <td>{$field.fd_name}</td>
                <td>
                    {if $field.fd_type == 'checkbox'}
                        {if $values.fields.$field_id==1}
                            да
                        {else}
                            нет
                        {/if}
                    {elseif $field.fd_type == 'file'}
                        <a href="{$values.fields.$field_id}">{$values.fields.$field_id}</a>
                    {else}
                        {$values.fields.$field_id}
                    {/if}
                </td>
            </tr>
        {/if}
    {/foreach}
</table>
{/if}
{/strip}