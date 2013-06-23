{* Навигационная цепочка для действий *}

{if !$params.navi_type}
	{include file="actions/navigation/hierarchy.tpl"}
{else}
	{include file="actions/navigation/`$params.navi_type`.tpl"}
{/if}