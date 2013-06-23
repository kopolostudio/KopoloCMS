{* Текстовые блоки в основной колонке сайта, для контроллера Controller_TextBlocks *}
{strip}
    {foreach $textblocks.content as $item}
        <div class="post">
            <h2>{$item.tb_name}</h2>
            <div class="entry">
            {$item.tb_info}
            </div>
        </div>
    {/foreach}
{/strip}