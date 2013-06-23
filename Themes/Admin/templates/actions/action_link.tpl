{strip}
{* формирование ссылки для действия исходя из переданных параметров *}
{if !empty($act)}
    {if isset($act.link)}
        {* передача прямой ссылки *}
        {$act.link}
    {else}
        {assign var="parent_field" value=$act.parent}
        {assign var="rel_field" value=$act.field}
        {assign var="id_field" value=$object->id_field}
        {assign var="module_uri" value=$object->module_uri}
        {if isset($act.module) && isset($act.module_nick) && $act.module != $object->__class}
            {assign var="module_uri" value="`$module_uri`/`$act.module_nick`"}
        {/if}
        
        {if isset($act.nesting) && $act.nesting>0 && !empty($rel_field)}
            {assign var="nesting" value=$act.nesting}
            
            {* псевдоуровень (костыль) *}
            {if $item.$rel_field==0}
                {assign var="level" value=1}
            {else}
                {assign var="level" value=2}
            {/if}
        {/if}
        {if !isset($act.nesting) || $level < $nesting}
            /admin/module/{$module_uri}/
            ?action={$act.action}
            {if isset($item.$parent_field) && !empty($rel_field)}
                &{$rel_field}={$item.$parent_field}
            {/if}
            {if $addid == true && !isset($rel_field) && !empty($item.$id_field)}
                &{$id_field}={$item.$id_field}
            {/if}
            {if $object->rel_params_string}
                &{$object->rel_params_string}
            {/if}
            
            {if isset($act.params)}
                {foreach from=$act.params key=param item=value}
                    &{$param}={$value}
                {/foreach}
            {/if}
        {/if}
    {/if}
{/if}
{/strip}