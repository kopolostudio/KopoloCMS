{* Текстовые блоки в боковой колонке сайта, для контроллера Controller_TextBlocks *}
{strip}
    {foreach $textblocks.sidebar as $item}
        <div class="block">
            <h2>{$item.tb_name}</h2>
            {$item.tb_info}
        </div>
    {/foreach}
{/strip}