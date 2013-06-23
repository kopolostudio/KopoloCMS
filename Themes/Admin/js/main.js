$(document).ready(function(){
  /* change site ID */
  $('#site select').change(function() {
    $('#site form').submit();
  });
  
  /* close user message */
  $('.messages-box .messages .close').click(function() {
    $(this).parent().remove();
  });
  
  /* open file manager */
  $('.picture_upload #filemanger').click(function() {
    window.open("/Lib/Kopolo/FileManager/", null, "resizable=eys, toolbar=no, scrollbars=eys, width=600, height=400");
  });
});