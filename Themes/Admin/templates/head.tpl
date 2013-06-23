{strip}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{$page.pg_title|strip_tags|replace:'"':"'"}</title>
    <meta name="Description" content="{$page.pg_description|strip_tags|replace:'"':"'"}" />
    <meta name="Keywords" content="{$page.pg_keywords|strip_tags|replace:'"':"'"}" />
    <link rel="shortcut icon" href="/Themes/Admin/i/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="/Themes/Admin/css/styles.css" />
    <script src="/Themes/Default/js/jquery.js" type="text/javascript" language="javascript"></script>
    <script src="/Themes/Admin/js/main.js" type="text/javascript" language="javascript"></script>
    <script src="/Themes/Default/js/ckeditor/ckeditor.js" type="text/javascript" language="javascript"></script>
    
    <script src="/Themes/Admin/js/upload/jquery.blockUI.js" type="text/javascript" language="javascript"></script>
    <script src="/Themes/Admin/js/upload/jquery.form.js" type="text/javascript" language="javascript"></script>
    <script src="/Themes/Admin/js/upload/jquery.MultiFile.js" type="text/javascript" language="javascript"></script>
    <script src="/Themes/Admin/js/upload/init.js" type="text/javascript" language="javascript"></script>
    
    <link href="/Themes/Default/css/jquery.fancybox-1.3.1.css" rel="stylesheet" type="text/css" />
    <script src="/Themes/Default/js/jquery.fancybox-1.3.1.js" type="text/javascript" language="javascript"></script>
    <script type="text/javascript">
    {literal}
        $(document).ready( function(){
            $(".content a[rel=fb]").fancybox({
                'titleShow'    : true,
                'transitionIn' : 'none',
                'transitionOut': 'none',
                'titlePosition': 'over'
            });
        });
    {/literal}
    </script>
{/strip}