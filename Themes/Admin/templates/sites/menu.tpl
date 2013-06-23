{strip}
{* верхнее меню админпанели (контроллер Controller_Sites_Menu) *}
{if count($menu)}
<center>
<table class="menu">
    <tr valign="middle">
        <td>
            {foreach $menu as $item}
            <a class="select" href="{$item.mn_link}" title="">
                <img hspace="3" align="absmiddle" vspace="3" src="{$item.mn_picture}">
                <div>{$item.mn_name}</div>
            </a>
            {/foreach}
            <div class="clear" />
         </td>
    </tr>
</table>
</center>
{/if}
{/strip}