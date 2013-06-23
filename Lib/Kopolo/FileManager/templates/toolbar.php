<?php
/* Панель инструментов */

if ($config['options']['file']['add']==true) {
?>
<script type="text/javascript">
    function addFileClickEvent() {
      $('.content .file').click(function() {
        $('.content .file').removeClass('selected');
        $(this).addClass('selected');
      });
      
      $('.content .file').dblclick(function() {
            var funcNum = getUrlParam('CKEditorFuncNum');
            var fileUrl = '<?php echo $config['dir']; ?>' + $(this).find('.name a').attr('rel');
            if (funcNum!='') { /*CKEDITOR*/
                window.opener.CKEDITOR.tools.callFunction(funcNum, fileUrl);
            } else { /*other sources*/
                var input = window.opener.jQuery.find('#kfm_server_file');
                $(input).attr('value', fileUrl);
            }
            window.parent.close();
      });
    }
    
    function getUrlParam(paramName) {
      var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
      var match = window.location.search.match(reParam) ;
     
      return (match && match.length > 1) ? match[1] : '' ;
    }
    
    function openSelectedFolder() {
        $('.tree a.selected').parents('ul').show();
        $('.tree a.selected').parentsUntil('.level-0').find('a.expand').addClass("open_folder");
        $('.tree a.selected').siblings('ul').show();
    }
    
    $(document).ready(function(){
        addFileClickEvent();
    
        $('.tree ul li ul').hide();
        openSelectedFolder();
        
        /* Expand folders */
        $('.tree ul li a.expand').click(function() {
            $(this).parent().find('a.expand').toggleClass("open_folder");
            $(this).parent().children('ul').toggle();
            return false;
        });
        
        /* Load folders files */
        $('.tree ul a.folder').click(function() {
          
            $('.tree a.folder').removeClass('selected');
            var url = '<?php echo $config['url']; ?>index.php?action=files_list&dir='+$(this).attr('rel');
            $('.content').load(url, function(){
                addFileClickEvent();
            });
            $(this).addClass('selected');
            openSelectedFolder();
            return false;
        });
        
        
        var uploader = new qq.FileUploader({
            element: document.getElementById('file-uploader'),
            action: '<?php echo $config['url']; ?>index.php?action=upload_file',
            debug: true,
            
            onComplete: function(id, fileName, responseJSON){
                $('.content').load('index.php?action=files_list', function(){
                    $('.content .file .name a[title$="'+fileName+'"]').parent().parent().addClass('selected');
                    addFileClickEvent();
                });
            },
            
            template: '<div class="qq-uploader">' + 
                    '<div class="qq-upload-drop-area"><span><?php echo $msg['upload_file_drop']; ?></span></div>' +
                    '<div class="qq-upload-button"><?php echo $msg['options_upload_file']; ?></div>' +
                    '<ul class="qq-upload-list"></ul>' + 
                 '</div>',
            
            fileTemplate: '<li>' +
                    '<span class="qq-upload-file"></span>' +
                    '<span class="qq-upload-spinner"></span>' +
                    '<span class="qq-upload-size"></span>' +
                    '<a class="qq-upload-cancel" href="#"><?php echo $msg['upload_file_cancel']; ?></a>' +
                    '<span class="qq-upload-failed-text"><?php echo $msg['upload_file_failed']; ?></span>' +
                '</li>'
        });
    });

</script>

<div id="file-uploader"></div>

<?php
}
?>