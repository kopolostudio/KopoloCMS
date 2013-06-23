{strip}

    {if !empty($page.pg_header)}
        <h1>{$page.pg_header}</h1>
    {/if}
    
    <div class="info">
        {$page.pg_info}
        {$components.content}
    </div>

{/strip}