$(document).ready(function(){
      
$('.MultiFile').MultiFile({ 
    accept:'xls', max:1, STRING: { 
        remove:'удалить',
        file:'$file', 
        selected:'Выбраны: $file', 
        denied:'Неверный тип файла: $ext!', 
        duplicate:'Этот файл уже выбран:\n$file!' 
    } 
});

$("#loading").ajaxStart(function(){
    $(this).show();
})

$('#uploadForm').ajaxForm({
    beforeSubmit: function(a,f,o) {
        o.dataType = "html";
        $('#uploadOutput').html('Отправка данных...');
    },
    success: function(data) {
        var $out = $('#uploadOutput');
        $out.html('<br /><br />');
        if (typeof data == 'object' && data.nodeType)
            data = elementToString(data.documentElement, true);
        else if (typeof data == 'object')
            data = objToString(data);
            
        var text;
        if (isNaN(data) == true) {
            text = '<span class="error">Ошибка!</span> ' + data + '<br />';
            $out.append('<div>'+ text +'</div>');
            return;
        } 
        text = 'Найдено позиций для обработки: ' + data + '.<br />';
        $out.append('<span>'+ text +'</span>');
        
        var $progress = $('#uploadProgress');
        var percent = 0;
        $progress.html(percent+'%');
        
        var total_count_rows = data*1;
        var one_stage_count_rows = 100;
        var count_stages = Math.ceil(total_count_rows/one_stage_count_rows);
        var url = '/admin/import/?ajax';
        var stage = 1;
        
        nextStage (url, one_stage_count_rows, count_stages, stage);
    }
});
});

function nextStage (url, one_stage_count_rows, count_stages, stage) {
    var $out = $('#uploadOutput');
    var $progress = $('#uploadProgress');
    
    $.ajax(
        { 
            url: url, 
            data: {count_rows: one_stage_count_rows, start_row: ""+(stage*one_stage_count_rows-one_stage_count_rows+1)+"",stage: ""+stage+"",count_stages: ""+count_stages+"",parce:"1"},
            success: function(response, status, xhr) {
                var msg;
                if (status == "error") {
                    msg = "Попробуйте снова, во время загрузки произошла ошибка: ";
                    $out.append('<p>' + msg + xhr.status + ' ' + xhr.statusText + '</p>');
                } else {
                    msg = response;
                    percent = Math.ceil(stage/count_stages*100);
                    $progress.html(percent+'%');
                    stage++;
                    if (stage <= count_stages) {
                        nextStage (url, one_stage_count_rows, count_stages, stage);
                    } else {
                        $("#loading").hide ();
                        msg += '<p>Загрузка завершена.</p>';
                    }
                }
                $out.append('<p>'+ msg +'</p>');
            }
        }
    );
}