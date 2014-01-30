<?php

$available_nets = array();
$networks = dir('../track/postback');

while ($file = $networks->read()) {
    if ($file != '.' && $file != '..') {
        $file = str_replace('.php', '', $file);
        array_push($available_nets, $file);
    }
}
?>
<link href="lib/select2/select2.css" rel="stylesheet"/>

<script src="lib/mustache/mustache.js"></script>
<script src="lib/select2/select2.js"></script>
<script src="lib/clipboard/ZeroClipboard.min.js"></script>

<script type="text/javascript">
$(document).ready(function()
{

        // init ZeroClipboard
        var clip = new ZeroClipboard( document.getElementById("copy-button"), {
          moviePath: "lib/clipboard/ZeroClipboard.swf"
        } );

        clip.on( 'complete', function(client, args) {
            $('#clipboard_copy_icon').animate({opacity: 0.4}, "fast").animate({opacity: 1}, "fast");
        });
        
        $('.net-btn').click(function(){
            $('#search-row').hide();
            $('#master-row').hide();
            $.post(
                    'index.php?ajax_act=postback_info',
                    {
                        net: $(this).attr('net')
                    },
                    function(data) {
                        if (data.status == 'OK') {
                            $('#net-name').text($('.net-btn').attr('net'));
                            $('#net-link').val(data.link);
                            $('#instruction').text(data.instruction);
                            $('#result-row').show();
                        }
                    },
                    'json'
            );
        });
});
</script>


<div class="row">
    <div class="col-md-12">
        <h3>Настройка Postback</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <b>Для Вашего удобства мы подготовили Postback ссылки для популярных СРА сетей, выберите необходимую и просто скопируйте полученную ссылку в нее: </b>
    </div>
</div>

<div class="row" id="net-row">
    <div class="col-md-12">
        <div class="btn-group">
            <?php foreach ($available_nets as $net) :?>
                <button class="btn btn-default net-btn" net="<?=$net?>"><?=$net;?></button>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<br>
<div class="row" id="search-row">
    <div class="col-md-12">
        <b>Как, не нашли подходящего? Поищите на <a href="http://www.cpatracker.ru/postback.html" target="_blank">нашем сайте</a>, возможно мы уже выпустили плагин для нее;)</b>
    </div>
</div>
<br>
<div class="row" id="master-row">
    <div class="col-md-12">
        <b>Если Вы все еще не нашли свою Postback ссылку, то воспользуйтесь нашим мастером генерации ссылок, который сосздаст ссылку именно под Ваши данные.</b><br>
        <button class="btn btn-success">Запуситить мастер</button>
    </div>
</div>

<div class="row" id="result-row" style="display:none;">
    <div class="col-md-12">
        Postback ссылка для сети <span id="net-name"></span>:<br>
        <div class="input-group">
            <span class="input-group-btn">
                <button id="copy-button" class="btn btn-default" data-clipboard-target='net-link' title="Скопировать в буфер" type="button"><i class='fa fa-copy' id='clipboard_copy_icon'></i></button>
            </span>
            <input type="text" style="width:100%;" class="form-control" id="net-link" value="" disabled><br>
        </div>
        <em id="instruction"></em>
    </div>
</div>