{strip}
{if count($list) && count($definitions)}
    {literal}
    <style>
        td.editable .reqnote, td.editable .required, td.editable label {
            display:none;
        }
        
        td.editable .form input, td.editable .form select {
            width:auto;
            height:auto;
            padding:5px 10px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('table td.editable a').each(function(i){
            $(this).click(function(){
                    var url = $(this).attr('href');
                    var td = $(this).parent();
                    
                    $(td).html('<img src="/Themes/Admin/i/ajax-loader.gif"/>');
                    //$(td).load(url);
                    
                    $.ajax({
                      url: url+'&ajax',
                      success: function(data) {
                        $(td).html(data);
                        $(td).find('form').attr('action', url);
                      }
                    });
                    
                    return false;
                });
            });
        });
    </script>
    {/literal}


    <table>
        <tr>
        <th>№</th>
        {if count($object->for_each_actions)}
            <th>Действия</th>
        {/if}
        {foreach from=$definitions key=field_name item=def name=definitions}
            <th>
                {if !empty($def.title)}{$def.title}{else}{$field_name}{/if}
                {*}
                {if $def.actions.list.sortable == true}
                    &nbsp;
                    <a href="{$full_uri}&sort_by={$field_name}&sort_type=desc" title="Сортировать по убыванию">
                        <img align="absmiddle" src="/Themes/Admin/i/icons/down.png">
                    </a>
                    <a href="{$full_uri}&sort_by={$field_name}&sort_type=asc" title="Сортировать по возрастанию">
                        <img align="absmiddle" src="/Themes/Admin/i/icons/up.png">
                    </a>
                {/if}
                {*}
            </th>
        {/foreach}
        </tr>
    {foreach from=$list name=list item=item}
        <tr{if $smarty.foreach.list.iteration is even} class="even"{/if}>
        
            {assign var="pos_field" value="`$object->__prefix`position"}
            <td class="position editable">
                {if $object->position_field}
                    {assign var="id_field" value=$object->id_field}
                    <a href="/admin/module/{$object->module_uri}/?action=editfield&{$id_field}={$item.$id_field}&field={$pos_field}" title="Изменить позицию">
                        {$smarty.foreach.list.iteration}
                    </a>
                {else}
                    {$smarty.foreach.list.iteration}
                {/if}
            </td>
        {if count($object->for_each_actions)} 
            <td class="table-actions">
                {include file="actions/actions.tpl" actions=$object->for_each_actions item=$item separator="<br />" addid=true name_field=$object->name_field}
            </td>
        {/if}
        {foreach from=$definitions key=field_name item=def}
            <td{if $def.actions.list.editable == true} class="editable"{/if}>
                {if $def.actions.list.editable == true}
                    {assign var="id_field" value=$object->id_field}
                    <a href="/admin/module/{$object->module_uri}/?action=editfield&{$id_field}={$item.$id_field}&field={$field_name}" title="Изменить">
                {/if}
                
                {assign var="value" value=$item.$field_name}
                {if $def.form.type == 'select' && $def.quickfield != 'position'}
                    {$def.form.options.$value}
                {elseif $def.form.type == 'picture'}
                    <center>{resize file=$value width=160 height=120}</center>
                {elseif $def.form.type == 'checkbox'}
                    <img hspace="3" align="absmiddle" vspace="3" src="/Themes/Admin/i/icons/{if $value==1}yes{elseif $value==0}no{/if}.png">
                    {$def.form.options.$value}
                {elseif $def.form.type == 'date'}
                    {$value|date_format:"%d.%m.%Y"}
                {elseif $def.form.type == 'datetime'}
                    {$value|date_format:"%d.%m.%Y %H:%I"}
                {else}
                    {$value}
                {/if}
                
                {if $def.actions.list.editable == true}
                    </a>
                {/if}
            </td>
        {/foreach}
        </tr>
    {/foreach}
    </table>
    
    {if $pager->links}
    <div class="pager">
        Страницы: {$pager->links}
    </div>
    {/if}
{/if}
{/strip}