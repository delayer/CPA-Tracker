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
        }).done(function(msg) {  
            var template = $('#rulesTemplate').html();
            var template_data = $.parseJSON(msg);

            var html = Mustache.to_html(template, template_data);
            $('#rules_container').html(html);

            // Init ZeroClipboard
            $('button[id^="copy-button"]').each(function(i)
            {
                var cur_id = $(this).attr('id');
                var clip = new ZeroClipboard(document.getElementById(cur_id), {
                    moviePath: "lib/clipboard/ZeroClipboard.swf"
                });

                clip.on('mouseout', function(client, args) {
                    $('.btn-rule-copy').removeClass('zeroclipboard-is-hover');
                });
            });


            $('.delbut').on("click", function() {
                delete_rule($(this).attr('id'));
            });
            function prepareTextInput(tr,name,title){                
                tr.find('.label-default').text(title);
                tr.find('input.select-item').attr('placeholder',title);
                tr.find('input.select-item').attr('itemtype',name);
                tr.find('input.select-link').select2({data: {results: dictionary_links}, width: 'copy', containerCssClass: 'form-control select2'});
            } 
           // buttons {// 
            
            $('.addcountry').on("click", function(e) {
                e.preventDefault();
                var template = $('#countryTemplate').html();
                var rule_id = $(this).parent().parent().attr('id');
                var rule_table = $('#rule' + rule_id + ' tbody');
                rule_table.prepend(template);
                rule_table.find('input.select-geo_country').select2({data: {results: dictionary_countries}, width: '250px', containerCssClass: 'form-control select2 noborder-select2'});
                rule_table.find('input.select-link').select2({data: {results: dictionary_links}, width: 'copy', containerCssClass: 'form-control select2'});               
                rule_table.find('input.select-link').select2('val',$('#rule'+rule_id).find('[name = default_out_id]').val()) ;    
            });
            $('.addlang').on("click", function(e) {
                e.preventDefault();
                var template = $('#langTemplate').html();
                var rule_id = $(this).parent().parent().attr('id');
                var rule_table = $('#rule' + rule_id + ' tbody');
                rule_table.prepend(template);
                rule_table.find('input.select-lang').select2({data: {results: dictionary_langs}, width: '250px', containerCssClass: 'form-control select2 noborder-select2'});
                rule_table.find('input.select-link').select2({data: {results: dictionary_links}, width: 'copy', containerCssClass: 'form-control select2'});               
                rule_table.find('input.select-link').select2('val',$('#rule'+rule_id).find('[name = default_out_id]').val()) ;    
            });
            $('.addrefer').on("click", function(e) {
                e.preventDefault();
                var template = $('#referTemplate').html();
                var rule_id = $(this).parent().parent().attr('id');
                var rule_table = $('#rule' + rule_id + ' tbody');
                rule_table.prepend(template);
                rule_table.find('input.select-link').select2({data: {results: dictionary_links}, width: 'copy', containerCssClass: 'form-control select2'});               
                rule_table.find('input.select-link').select2('val',$('#rule'+rule_id).find('[name = default_out_id]').val()) ;           
            });
             $('.addcity').on("click", function(e) {
                e.preventDefault();
                var template = $('#referTemplate').html();
                var rule_id = $(this).parent().parent().attr('id');
                var rule_table =  $('#rule' + rule_id + ' tbody');
                rule_table.prepend(template);
                var tr = rule_table.find('tr').first();
                prepareTextInput(tr,'city','Город');               
                rule_table.find('input.select-link').select2('val',$('#rule'+rule_id).find('[name = default_out_id]').val()) ;    
            });
             $('.addregion').on("click", function(e) {
                e.preventDefault();
                var template = $('#referTemplate').html();
                var rule_id = $(this).parent().parent().attr('id');
                var rule_table =  $('#rule' + rule_id + ' tbody');
                rule_table.prepend(template);
                var tr = rule_table.find('tr').first();
                prepareTextInput(tr,'region','Регион');               
                rule_table.find('input.select-link').select2('val',$('#rule'+rule_id).find('[name = default_out_id]').val()) ;    
            });
            $('.addprovider').on("click", function(e) {
                e.preventDefault();
                var template = $('#referTemplate').html();
                var rule_id = $(this).parent().parent().attr('id');
                var rule_table =  $('#rule' + rule_id + ' tbody');
                rule_table.prepend(template);
                var tr = rule_table.find('tr').first();
                prepareTextInput(tr,'provider','Провайдер');               
                rule_table.find('input.select-link').select2('val',$('#rule'+rule_id).find('[name = default_out_id]').val()) ;    
            });
            $('.addip').on("click", function(e) {
                e.preventDefault();
                var template = $('#referTemplate').html();
                var rule_id = $(this).parent().parent().attr('id');
                var rule_table =  $('#rule' + rule_id + ' tbody');
                rule_table.prepend(template);
                var tr = rule_table.find('tr').first();
                prepareTextInput(tr,'ip','IP адрес');               
                rule_table.find('input.select-link').select2('val',$('#rule'+rule_id).find('[name = default_out_id]').val()) ;    
            });
             $('.addos').on("click", function(e) {
                e.preventDefault();
                var template = $('#referTemplate').html();
                var rule_id = $(this).parent().parent().attr('id');
                var rule_table =  $('#rule' + rule_id + ' tbody');
                rule_table.prepend(template);
                var tr = rule_table.find('tr').first();
                prepareTextInput(tr,'os','ОС');               
                rule_table.find('input.select-link').select2('val',$('#rule'+rule_id).find('[name = default_out_id]').val()) ;    
            }); $('.addplatform').on("click", function(e) {
                e.preventDefault();
                var template = $('#referTemplate').html();
                var rule_id = $(this).parent().parent().attr('id');
                var rule_table =  $('#rule' + rule_id + ' tbody');
                rule_table.prepend(template);
                var tr = rule_table.find('tr').first();
                prepareTextInput(tr,'platform','Платформа');               
                rule_table.find('input.select-link').select2('val',$('#rule'+rule_id).find('[name = default_out_id]').val()) ;    
            });
             $('.addbrowser').on("click", function(e) {
                e.preventDefault();
                var template = $('#referTemplate').html();
                var rule_id = $(this).parent().parent().attr('id');
                var rule_table =  $('#rule' + rule_id + ' tbody');
                rule_table.prepend(template);
                var tr = rule_table.find('tr').first();
                prepareTextInput(tr,'browser','Браузер');               
                rule_table.find('input.select-link').select2('val',$('#rule'+rule_id).find('[name = default_out_id]').val()) ;    
            });
             $('.addagent').on("click", function(e) {
                e.preventDefault();
                var template = $('#referTemplate').html();
                var rule_id = $(this).parent().parent().attr('id');
                var rule_table =  $('#rule' + rule_id + ' tbody');
                rule_table.prepend(template);
                var tr = rule_table.find('tr').first();
                prepareTextInput(tr,'agent','User-agent');               
                rule_table.find('input.select-link').select2('val',$('#rule'+rule_id).find('[name = default_out_id]').val()) ;    
            });
            
            
            // buttons }//  
            
            $('.btnsave').on("click", function(e) {
                e.preventDefault();
                var rule_id = $(this).attr('id');
                var rule_table = $('#rule' + rule_id + ' tbody');
                $(rule_table).find('input.select-link').each(function() {                                      
                       $(this).addClass('toSave');                      
                });
                $(rule_table).find('input.select-item').each(function() {                                         
                       $(this).addClass('toSave');                     
                });
                if(update_rule(rule_id) && !$(rule_table).find('.fa-check').size()){
                    $(this).after('<i style="position: relative; right: 20px; top: 9px;"  class="fa fa-check pull-right"></i>');
                }
            });
            $('body').on("click", '.btnrmcountry', function(e) {
                e.preventDefault();
                var rule_id = $(this).closest("tr").parent().attr('id');
                $(this).closest("tr").remove();
                update_rule(rule_id);
            });
            $(".table-rules th").on("click", function() {
                $(this).closest("table").children("tbody").toggle();
                $(this).closest("table").toggleClass("rule-table-selected");
            });

            
            // Fill values for destination links
            var dictionary_links = [];
            dictionary_links.push(<?= $js_offers_data; ?>);
            
            $('input.select-link').each(function()
            {
                $(this).select2({data: {results: dictionary_links}, width: 'copy', containerCssClass: 'form-control select2'});
                $(this).select2("val", $(this).attr('data-selected-value'));
            });

            var dictionary_countries = [];
           
            dictionary_countries.push(<?= $js_countries_data; ?>); 
             
            $('input.select-geo_country').each(function()
            {
                $(this).select2({data: {results: dictionary_countries}, width: '250px', containerCssClass: 'form-control select2 noborder-select2'});
                $(this).select2("val", $(this).attr('data-selected-value'));
            });
            
            dictionary_langs = [];
            dictionary_langs.push({text:"", children:[{id:"en", text:"Английский, en"},{id:"ru", text:"Русский, ru"},{id:"uk", text:"Украинский, uk"}]});
            dictionary_langs.push(<?= $js_langs_data; ?>);
            
            $('input.select-lang').each(function()
            {
                $(this).select2({data: {results: dictionary_langs}, width: '250px', containerCssClass: 'form-control select2 noborder-select2'});
                $(this).select2("val", $(this).attr('data-selected-value'));
            });
            
            
        });
    });

    
    function delete_rule(rule_id)
    {

        $.ajax({
            type: 'POST',
            url: 'index.php',
            data: 'ajax_act=delete_rule&id=' + rule_id
        }).done(function(msg)
        {
            $('#rule' + rule_id).hide();
        });

        return false;
    }
 

    function update_rule(rule_id)
    {

        var links = [];
        var rules_items = '';
        var values = '';
        var error = '';
        var rule_table = $('#rule' + rule_id + ' tbody');
        var name = $(rule_table).prev().find('.rule-name-title').text();
        var i = 0;
        $(rule_table).find('input.select-item.toSave').each(function() {        
            if ($(this).val()) {
                rules_items = rules_items + '&rules_item['+i+"][val]=" + $(this).val();
                rules_items = rules_items + '&rules_item['+i+"][type]=" + $(this).attr('itemtype');
                i++;
            } else {
                error = 'Выберите условие';
            }
        });
        $(rule_table).find('input.select-link.toSave').each(function() {
            if ($(this).val()) {
                if (!in_array($(this).val(), links)) {
                    links.push($(this).val());
                }
                values = values + '&rule_value[]=' + $(this).val();
            } else {
                error = 'Выберите ссылку';
            }
        });
        if (error) {
            alert(error);
            return false;
        } else {
            rules_items = rules_items + '&rules_item['+i+"][val]=default";
            rules_items = rules_items + '&rules_item['+i+"][type]=geo_country" ;
            $.ajax({
                type: 'POST',
                url: 'index.php',
                data: 'ajax_act=update_rule&rule_id=' + rule_id + '&rule_name=' + name + rules_items + values
            }).done(function(msg)
            {
                console.log(msg);
           
                if (links.length > 1) {
                    var badge = '<span class="badge">' + (links.length) + ' ' + declination((links.length), 'ссылка', 'ссылки', 'ссылок') + '</span>';
                    $(rule_table).parent().find('.rule-destination-title').html(badge);
                }
            });
        }
        return true;
    }
    function declination(number, one, two, five) {
        number = Math.abs(number);
        number %= 100;
        if (number >= 5 && number <= 20) {
            return five;
        }
        number %= 10;
        if (number == 1) {
            return one;
        }
        if (number >= 2 && number <= 4) {
            return two;
        }
        return five;
    }
    function in_array(needle, haystack, strict) {
        var found = false, key, strict = !!strict;
        for (key in haystack) {
            if ((strict && haystack[key] === needle) || (!strict && haystack[key] == needle)) {
                found = true;
                break;
            }
        }
        return found;
    }
    function validate_add_rule() {
        var nameR = /^[a-z0-9\-\_]+$/i;
        if (!nameR.test($('input[name=rule_name]', $('#form_add_rule')).val())){
          $('#incorrect_name_alert').show();
          $('input[name=rule_name]', $('#form_add_rule')).focus();
          return false;
        }
        return true;
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
<script id="referTemplate" type="text/template">
     {{#conditions}}
                    <tr>
                        <td>
                            <div class="form-inline" role="form">                            
                                <div class="btn-group trash-button">
                                    <button class='btn btn-default btnrmcountry'><i class="fa fa-trash-o text-muted"></i></button>
                                </div>
                                <div class="form-group">
                                    <span class="label label-default">Реферер</span>
                                </div>
                                <div class="form-group">
                                <input type="text" class="form-control select-item" placeholder="Реферер" itemtype='referer'  > 
                                </div>
                                <div class='pull-right' style='width:200px;'><input placeholder="Ссылка" require="" type="hidden" name='out_id[]' class='select-link' data-selected-value=''></div>
                            </div>
                        </td>
                    </tr>
       {{/conditions}}          
</script>
<script id="countryTemplate" type="text/template">
     {{#conditions}}
                    <tr>
                        <td>
                            <div class="form-inline" role="form">                            
                                <div class="btn-group trash-button">
                                    <button class='btn btn-default btnrmcountry'><i class="fa fa-trash-o text-muted"></i></button>
                                </div>
                                <div class="form-group">
                                    <span class="label label-default">Страна</span>
                                </div>
                                <div class="form-group">
                                <input type="hidden" placeholder="Страна" itemtype='geo_country' class='select-geo_country select-item' data-selected-value=''>
                                <!-- <button class='btn btn-default' style='border:none;'>  <i class="fa fa-caret-down text-muted"></i></button> -->
                                </div>
                                <div class='pull-right' style='width:200px;'><input placeholder="Ссылка" require="" type="hidden" name='out_id[]' class='select-link' data-selected-value=''></div>
                            </div>
                        </td>
                    </tr>
       {{/conditions}}          
</script>
<script id="langTemplate" type="text/template">
     {{#conditions}}
                    <tr>
                        <td>
                            <div class="form-inline" role="form">                            
                                <div class="btn-group trash-button">
                                    <button class='btn btn-default btnrmcountry'><i class="fa fa-trash-o text-muted"></i></button>
                                </div>
                                <div class="form-group">
                                    <span class="label label-default">Язык</span>
                                </div>
                                <div class="form-group">
                                <input type="hidden" placeholder="Язык" itemtype='lang' class='select-lang select-item' data-selected-value=''>
                                <!-- <button class='btn btn-default' style='border:none;'>  <i class="fa fa-caret-down text-muted"></i></button> -->
                                </div>
                                <div class='pull-right' style='width:200px;'><input placeholder="Ссылка" require="" type="hidden" name='out_id[]' class='select-link' data-selected-value=''></div>
                            </div>
                        </td>
                    </tr>
       {{/conditions}}          
</script>
<script id="rulesTemplate" type="text/template">
    {{#rules}}
        <table id="rule{{id}}" class='table table-rules'>
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

            <tbody id="{{id}}">
                {{#conditions}}
                    <tr>
                        <td>
                            <div class="form-inline" role="form">                            
                                <div class="btn-group trash-button">
                                    <button class='btn btn-default btnrmcountry'><i class="fa fa-trash-o text-muted"></i></button>
                                </div>
                                <div class="form-group">
                                    <span class="label label-default">{{type}}</span>
                                </div>                        
                        {{#textinput}}
                                <div class="form-group">
                                <input type="text" class="form-control select-item toSave" placeholder="{{type}}" itemtype='{{select_type}}' value='{{value}}' > 
                                </div>
                        {{/textinput}}
                        {{^textinput}}
                                <div class="form-group">
                                <input type="hidden" placeholder="{{type}}" itemtype='{{select_type}}' class='select-{{select_type}} select-item toSave' data-selected-value='{{value}}'>
                                <!-- <button class='btn btn-default' style='border:none;'>{{value}} <i class="fa fa-caret-down text-muted"></i></button> -->
                                </div>
                        {{/textinput}}                        
                                <div class='pull-right' style='width:200px;'><input type=hidden name='out_id[]' class='select-link toSave' data-selected-value='{{destination_id}}'></div>
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
                        <div class='pull-right' style='width:200px;'><input type='hidden' name='default_out_id' class='select-link toSave' data-selected-value='{{default_destination_id}}'></div>
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
                                    <li><a class="delbut" id="{{id}}" href="#">Удалить правило</a></li>
                                </ul>
                            </div>                        
                              <div class="btn-group">
                                <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown">
                                  Добавить условие
                                  <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" id="{{id}}">
                                    <li><a class="addcountry" href="#">Страна</a></li>
                                    <li><a class="addlang" href="#">Язык браузера</a></li>
                                    <li><a class="addrefer" href="#">Реферер</a></li>
                                    <li><a class="addcity" href="#">Город</a></li>
                                    <li><a class="addregion" href="#">Регион</a></li>
                                    <li><a class="addprovider" href="#">Провайдер</a></li>
                                    <li><a class="addip" href="#">IP адрес</a></li>
                                    <li><a class="addos" href="#">ОC</a></li>
                                    <li><a class="addplatform" href="#">Платформа</a></li>                                    
                                    <li><a class="addbrowser" href="#">Браузер</a></li> 
                                    
                                    <li><a class="addagent" href="#">User-agent</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Параметр в GET-запросе</a></li>
                                </ul>                            
                              </div>
                        </div>
                        <button id="{{id}}" class='btn btn-default pull-right btnsave'>Сохранить</button>
                    </form>
                </td></tr>

            </tbody>
        </table>
    {{/rules}}
</script>

<div class="row">
    <div class="col-sm-9">
        <div class="alert alert-danger" style="display:none;" id="incorrect_name_alert">
            Неверное название правила, используйте только латинские буквы, цифры и знаки _ и -.
        </div>
        <form class="form-inline" method="post" onsubmit="return validate_add_rule();" id="form_add_rule" role="form" style="margin-bottom:30px">
        <div class="form-group">
            <label class="sr-only">Название правила</label>
            <input type="text" class="form-control" placeholder="Название правила" name="rule_name">
        </div>
        &nbsp;→&nbsp;
        <div class="form-group">
            <label class="sr-only">Ссылка</label>
            <input type="hidden" placeholder="Ссылка" name='out_id' class='select-link toSave' data-selected-value='<?=$js_last_offer_id;?>'>
        </div>
        <button type="submit" class="btn btn-default" onclick="">Добавить</button>
        <input type="hidden" name="ajax_act" value="add_rule">
        </form>         
    </div>
</div>



<div class='row'>
    <div class="col-md-9" id='rules_container'></div>
</div>

<div class="row">&nbsp;</div>