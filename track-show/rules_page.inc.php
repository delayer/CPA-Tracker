<link href="lib/select2/select2.css" rel="stylesheet"/>
<link href="lib/select2/select2-bootstrap.css" rel="stylesheet"/>

<script src="lib/mustache/mustache.js"></script>
<script src="lib/select2/select2.js"></script>
<script src="lib/clipboard/ZeroClipboard.min.js"></script>

<script>
    $(document).ready(function() 
    {
        $('input[name=rule_name]').focus();

        $.ajax({
               type: "POST",
               url: "index.php",
               data: 'ajax_act=get_rules_json'
           }).done(function (msg) {
                var template = $('#rulesTemplate').html();
                var template_data=$.parseJSON(msg);
                
                var html = Mustache.to_html(template, template_data);
                $('#rules_container').html(html);

                // Init ZeroClipboard
                $('button[id^="copy-button"]').each(function(i)
                {
                    var cur_id=$(this).attr('id');
                    var clip = new ZeroClipboard( document.getElementById(cur_id), {
                        moviePath: "lib/clipboard/ZeroClipboard.swf"
                    } );

                    clip.on( 'mouseout', function ( client, args ) {
                        $('.btn-rule-copy').removeClass('zeroclipboard-is-hover');
                    } );
                });

                $(".table-rules th").on( "click", function() {
                    $(this).closest("table").children("tbody").toggle(); 
                    $(this).closest("table").toggleClass("rule-table-selected");
                });                        

                // Fill values for destination links
                var dictionary_links = [];
                dictionary_links.push(<?=$js_offers_data;?>);
                $('input.select-link').each(function() 
                {
                    $(this).select2({data:{results: dictionary_links}, width:'copy', containerCssClass:'form-control select2'});
                    $(this).select2("val", $(this).attr('data-selected-value'));
                });

                var dictionary_countries=[];
                dictionary_countries.push(<?=$js_countries_data;?>);
                $('input.select-country').each(function() 
                {
                    $(this).select2({data:{results: dictionary_countries}, width:'250px', containerCssClass:'form-control select2 noborder-select2'});
                    $(this).select2("val", $(this).attr('data-selected-value'));
                });
           });
    });

    function delete_rule(obj, rule_id)
    {
        $.ajax({
          type: 'POST',
          url: 'index.php',
          data: 'ajax_act=delete_rule&id='+rule_id
        }).done(function( msg ) 
        {
          $(obj).closest('.rule_form').hide();
        });

        return false;
    }

    function validate_add_rule()
    {
        if ($('input[name=rule_name]', $('#form_add_rule')).val()==''){
          $('input[name=rule_name]', $('#form_add_rule')).focus();
          return false;
        }
        return true;
    }

    function rule_add_country(obj)
    {
        var new_obj=$('#system_rule_select div.system_inner').clone(true);
        $('select.select_s2', new_obj).addClass('select2').select2(); 

        $('.rule_value', $(obj).parent().parent()).prepend(new_obj);
        $('.new-country-selector', $(obj).parent().parent()).removeClass('new-country-selector').addClass('country-selector').selectToAutocomplete();

        return false;
    }

    function update_rule(id)
    {
        $('.rule_update_ajax', '#rule_'+id).show();
        $.ajax({
            type: 'POST',
            url: 'index.php',
            data: $('#rule_'+id).serialize()
          }).done(function( msg ) 
          {
            $('.rule_update_ajax', '#rule_'+id).hide();
          });
    }
</script>

<style>

    .btn-rule-copy{
        border: none; 
        border-radius:0px; 
        padding:10px 0px; 
        margin:0px; 
        min-width:50px; 
        color:#999;
        background: none;
        float:left;
    }

    .btn-rule-settings{
        border: none; 
        border-radius:0px; 
        margin:0px; 
        text-align: left;
        display: inline-block;
        float:left;
    }
    
    .btn-rule-copy.zeroclipboard-is-hover {background-color:#428bca !important; color:white !important;}
    .btn-rule-copy.zeroclipboard-is-active { background-color:#2e618d !important;}

    .rule-name-title{
        padding:10px 10px 10px 5px;
        border-radius:0px; 
        display: inline-block;
        float:left;
        border:none;
        min-width: 120px;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;    
    }

    .rule-destination-title{
        padding:10px; 
        margin:0px;
        border-radius:0px; 
        display: inline-block;
        float:left;
        border:none;
        font-weight:normal;
        min-width: 200px;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;        
    }    

    .btn-rule-settings:hover i{
        color: gray;
    }

    table.table-rules{
        margin-bottom: 0px;
        border-bottom: none;
    }

    table.table-rules:last-child{
       /* border-bottom: 1px solid #ddd; */
    }
    table.table-rules th:hover{
        background: linen;
    }
    .table-rules tbody{
        margin-bottom:10px;
        /* [!] */
        display: none;
        border:1px solid lightgray;
    }
    
    .rule-table-selected{
        margin-bottom: 10px !important;
    }

    .rule-table-selected thead{
            border:1px solid lightgray;
            border-bottom: none;
    }

    .rule-table-selected th, .rule-table-selected .btn-rule-copy{
        background-color:linen; 
    }

    .table-rules thead th {
        padding:0px inherit !important; 
        cursor:pointer; 
        border:none !important;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;        
    }
    
    .table-rules thead th div.btn-group{
        display:inline-block; 
        float:left;
    }

    .btn-default {
        background-color:inherit;
    }
    
    .trash-button .btn {
        border:none;
        border-radius:0px; 
    }    
</style>

<script id="rulesTemplate" type="text/template">
    {{#rules}}
        <table class='table table-rules'>
            <thead>
                <tr>
                    <th>
                        <button type='button' id='copy-button-{{id}}' class='btn-rule-copy' role="button" data-clipboard-target='rule-link-{{id}}'><i class="fa fa-copy" title="Скопировать ссылку в буфер"></i></button>
                        <span class='rule-name-title'>{{name}}</span>
                        <span class='rule-destination-title'>
                            {{destination}}
                            {{#destination_multi}}
                                <span class='badge'>{{destination_multi}}</span>
                            {{/destination_multi}}
                        </span>
                        <input type="hidden" id='rule-link-{{id}}' value='{{url}}'>
                    </th>
                </tr>
            </thead>

            <tbody>
                {{#conditions}}
                    <tr>
                        <td>
                            <div class="form-inline" role="form">                            
                                <div class="btn-group trash-button">
                                    <button class='btn btn-default'><i class="fa fa-trash-o text-muted"></i></button>
                                </div>
                                <div class="form-group">
                                    <span class="label label-default">{{type}}</span>
                                </div>
                                <div class="form-group">
                                <input type="hidden" placeholder="Страна" class='select-country' data-selected-value='{{value}}'>
                                <!-- <button class='btn btn-default' style='border:none;'>{{value}} <i class="fa fa-caret-down text-muted"></i></button> -->
                                </div>
                                <div class='pull-right' style='width:200px;'><input type=hidden name='out_id[]' class='select-link' data-selected-value='{{destination_id}}'></div>
                            </div>
                        </td>
                    </tr>
                {{/conditions}}

                <tr><td>
                    <form class="form-inline" role="form">
                        <div class="btn-group trash-button" style='visibility:hidden'>
                            <button class='btn btn-default'><i class="fa fa-trash-o text-muted"></i></button>
                        </div>    
                        <div class="form-group">
                            <span class="label label-primary">Все посетители</span>
                        </div>
                        <div class="form-group">
                            <button class='btn btn-default' style='border:none; visibility:hidden'><i class="fa fa-caret-down text-muted"></i></button>
                        </div>
                        <div class='pull-right' style='width:200px;'><input type='hidden' name='default_out_id' class='select-link' data-selected-value='{{default_destination_id}}'></div>
                    </form>
                </td></tr>

                <tr><td>
                    <form class="form-inline" role="form">
                        <div class="form-group">
                            <div class="btn-group">
                                <button class='btn btn-default dropdown-toggle btn-rule-settings' data-toggle="dropdown"><i class="fa fa-bars text-muted"></i></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Переименовать правило</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Удалить правило</a></li>
                                </ul>
                            </div>                        
                              <div class="btn-group">
                                <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown">
                                  Добавить условие
                                  <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Страна</a></li>
                                    <li><a href="#">Язык браузера</a></li>
                                    <li><a href="#">Реферер</a></li>
                                    <li><a href="#">Город</a></li>
                                    <li><a href="#">Регион</a></li>
                                    <li><a href="#">Провайдер</a></li>
                                    <li><a href="#">IP адрес</a></li>
                                    <li><a href="#">Название браузера</a></li>
                                    <li><a href="#">Версия браузера</a></li>
                                    <li><a href="#">User-agent</a></li>
                                    <li><a href="#">Мобильное устройство</a></li>
                                    <li><a href="#">Операционная система</a></li>
                                    <li><a href="#">Платформа</a></li>
                                    <li><a href="#">Сотовый оператор</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Параметр в GET-запросе</a></li>
                                </ul>                            
                              </div>
                        </div>
                        <button class='btn btn-default pull-right'>Сохранить</button>
                    </form>
                </td></tr>

            </tbody>
        </table>
    {{/rules}}
</script>

<div class="row">
    <div class="col-sm-9">
        <form class="form-inline" method="post" onsubmit="return validate_add_rule();" id="form_add_rule" role="form" style="margin-bottom:30px">
        <div class="form-group">
            <label class="sr-only">Название правила</label>
            <input type="text" class="form-control" placeholder="Название правила" name="rule_name">
        </div>
        &nbsp;→&nbsp;
        <div class="form-group">
            <label class="sr-only">Ссылка</label>
            <input type="hidden" placeholder="Ссылка" name='out_id' class='select-link' data-selected-value='<?=$js_last_offer_id;?>'>
        </div>
        <button type="submit" class="btn btn-default">Добавить</button>
        <input type="hidden" name="ajax_act" value="add_rule">
        </form>         
    </div>
</div>



<div class='row'>
    <div class="col-md-9" id='rules_container'></div>
</div>

<div class="row">&nbsp;</div>