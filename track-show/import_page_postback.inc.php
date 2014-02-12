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
    var links;
$(document).ready(function()
{

        // init ZeroClipboard
        var clip = new ZeroClipboard( document.getElementById("copy-button"), {
          moviePath: "lib/clipboard/ZeroClipboard.swf"
        } );

//        clip.on( 'complete', function(client, args) {
//            $('#clipboard_copy_icon').animate({opacity: 0.4}, "fast").animate({opacity: 1}, "fast");
//        });
        
        $('.net-btn').click(function(){
            var btn = this;
            $('#search-row').hide();
            $('#master-row').hide();
            $.post(
                    'index.php?ajax_act=postback_info',
                    {
                        net: $(this).attr('net'),
                        csrfkey: '<?=CSRF_KEY?>'
                    },
                    function(data) {
                        if (data.status == 'OK') {
                            
                            links = data.links;
                            
                            $('#net-name').text($(btn).attr('net'));
                            var template = $('#linkTemplate').html();
                            var template_data = data;

                            var html = Mustache.to_html(template, template_data);
                            
                            $('#links').html(html);
                            
                            $('button[id^="copy-button"]').each(function(i)
                            {
                                var cur_id = $(this).attr('id');
                                var clip = new ZeroClipboard(this, {
                                    moviePath: "lib/clipboard/ZeroClipboard.swf"
                                });

                                clip.on('mouseout', function(client, args) {
                                    $('.btn-rule-copy').removeClass('zeroclipboard-is-hover');
                                });
                            });
                            
                            $('#result-row').show();
                        }
                    },
                    'json'
            );
        });
        
        
        $('#is_lead').change(function(){
            show_urls($('#is_lead').is(':checked'), $('#is_sale').is(':checked'));
        });
        $('#is_sale').change(function(){
            show_urls($('#is_lead').is(':checked'), $('#is_sale').is(':checked'));
        });
        
});


function show_urls(is_lead,is_sale) {
    $.each(links, function (i, item) {
        var url = item.url;
        if (is_lead) {
             url = url + '&is_lead=1';
        }
        
        if (is_sale) {
            url = url + '&is_sale=1';
        }
        $('#net-link-'+item.id).val(url);
    })
}


</script>


<script id="linkTemplate"  type="text/template">
    
    {{#links}}
        <div>
        <em id="instruction">{{{description}}}</em>
        <div class="input-group">
            <span class="input-group-btn">
                <button id="copy-button" class="btn btn-default clpbrd-copy" id="{{id}}" data-clipboard-target='net-link-{{id}}' title="Скопировать в буфер" type="button"><i class='fa fa-copy' id='clipboard_copy_icon'></i></button>
            </span>
            <input type="text" style="width:100%;" class="form-control" id="net-link-{{id}}" value="{{url}}" readonly><br>
        </div>
        </div>
    {{/links}}

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
        Postback ссылка для сети <b><span id="net-name"></span></b>:<br><br>
        <div>
        <label class="checkbox-inline">
            <input type="checkbox" id="is_lead" value="1"> Лид
        </label>
        <label class="checkbox-inline">
            <input type="checkbox" id="is_sale" value="1"> Продажа
        </label>
        </div>
        <div id="links">
        
        </div>
    </div>
</div>