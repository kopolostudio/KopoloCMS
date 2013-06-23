{strip}
{if $pager->numPages() > 1}
    {assign var="selector" value="&nbsp;"}
    {assign var="num_pages" value=$pager->numPages()}
    {assign var="pager_delta" value=$pager->_delta}
    {if strlen($smarty.server.QUERY_STRING)}
        {assign var="query" value="?`$smarty.server.QUERY_STRING`"}
    {/if}

    {if $pager->getPreviousPageID() && $pager->getPreviousPageID() - $pager_delta > 0 && $num_pages > $pager_delta*2+1}
        {$pager->_firstPagePre}&nbsp;<a href="{$url}page{$pager->_firstPageText}/{$query}" title="{$pager->_firstLinkTitle}">{$pager->_firstPageText}</a>&nbsp;{$pager->_firstPagePost}
        {if $num_pages - $pager->getCurrentPageID() <= $pager_delta}
            {assign var="jump_id" value=$num_pages-$pager_delta*2-1}
        {else}
            {assign var="prev_id" value=$pager->getPreviousPageID()}
            {assign var="jump_id" value=$prev_id-$pager_delta}
        {/if}
        &nbsp;&nbsp;<a href="{$url}page{$jump_id}/{$query}" title="{$pager->_altPage}{$jump_id}">&lt;&lt;</a>&nbsp;
    {/if}
        
    {foreach name="pages" from=$pager->range key="pg" item="sel"}
        {if !$sel}<a href="{$url}page{$pg}/{$query}" title="{$pager->_altPage}{$pg}">{else}<span>{/if}{$pg}{if !$sel}</a>{else}</span>{/if} 
        {if $pager->numPages() != $pg}{$selector}{/if}
    {/foreach}

    {if $pager->getNextPageID() && $pager->getNextPageID() + $pager_delta <= $num_pages && $num_pages > $pager_delta*2+1}
        {if $pager->getCurrentPageID() <= $pager_delta}
            {assign var="jump_id" value=$pager_delta*2+2}
        {else}
            {assign var="next_id" value=$pager->getNextPageID()}
            {assign var="jump_id" value=$pager_delta+$next_id}
        {/if}
        &nbsp;<a href="{$url}page{$jump_id}/{$query}" title="{$pager->_altPage}{$jump_id}">&gt;&gt;</a>

        &nbsp;&nbsp;{$pager->_lastPagePre}&nbsp;<a href="{$url}page{$pager->_lastPageText}/{$query}" title="{$pager->_lastLinkTitle}">{$pager->_lastPageText}</a>&nbsp;{$pager->_lastPagePost}
    {/if}

    {$selector}<a href="{$url}all/{$query}">все</a>
{/if}
{/strip}