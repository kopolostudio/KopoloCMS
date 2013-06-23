{strip}
{if $images}
    <link href="/Themes/default/css/jquery.fancybox-1.3.1.css" rel="stylesheet" type="text/css" />
    <script src="/Themes/default/js/jquery.fancybox-1.3.1.js" type="text/javascript" language="javascript"></script>
    <script type="text/javascript">
    {literal}
        $(document).ready( function(){
            $(".photo-gallery a[rel=fb]").fancybox({
                'titleShow'    : true,
                'transitionIn' : 'none',
                'transitionOut': 'none',
                'titlePosition': 'over'
            });
        });
    {/literal}
    </script>

    <div class="photo-gallery">
        {foreach from=$images item=pic}
            <div class="image">
                <a href="{resize file=$pic.img_picture width=1200 height=1200 path_only=1}" rel="fb"{if $pic.img_name} title="{$pic.img_name|strip_tags|replace:'"':"'"}"{/if}>
                    {resize file=$pic.img_picture width=100 height=100 crop=1}
                </a>
            </div>
        {/foreach}
    </div>
{/if}
{/strip}