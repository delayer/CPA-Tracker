<?

require_once '../track/lib/class/common.php';
require_once '../track/lib/class/custom.php';
$custom = new custom();
?>
<link href="lib/select2/select2.css" rel="stylesheet"/>

<script src="lib/mustache/mustache.js"></script>
<script src="lib/select2/select2.js"></script>
<script src="lib/clipboard/ZeroClipboard.min.js"></script>

<script type="text/javascript">
    var base_custom = "<?=$custom->get_pixel_link();?>";
    $(document).ready(function(){
        $('#master-form input[type=checkbox]').change(function(){
            var cur_url = base_custom;
            
            $('#master-form input[type=checkbox]').each(function(i) {
                if ($(this).is(':checked')) {
                    cur_url =  +cur_url + '&' + $(this).attr('id') + '=' + $('#'+$(this).attr('id')+'_val').val();
                }
                $('#custom-link-val').val("<img src='"+cur_url+"' width='1' height='1'>");
            });
            
        });
        
        $('#master-form input[type=text]').change(function(){
            var cur_url = base_custom;
            $('#master-form input[type=checkbox]').each(function(i) {
                if ($(this).is(':checked')) {
                    cur_url = cur_url + '&' + $(this).attr('id') + '=' + $('#'+$(this).attr('id')+'_val').val();
                }
                $('#custom-link-val').val("<img src='"+cur_url+"' width='1' height='1'>");
            });
            
        });
    });
</script>

<div class="row">
    <div class="col-md-12">
        <h3>Пиксель отслеживания</h3>
    </div>
</div>

<div class="row" id="master-form">
    <div class="col-md-12">
        
        <div class='alert alert-info'>
            <strong>Внимание!</strong><br>
            Устанавливайте пиксель отслеживание <strong>ТОЛЬКО</strong> на страницу СПАСИБО Вашего сайта. Пиксель работает по принципу Postback.
        </div>
        
        <div class="input-group">
            <span class="input-group-btn">
                <button id="copy-button" class="btn btn-default clpbrd-copy" id="custom-link" data-clipboard-target='custom-link-val' title="Скопировать в буфер" type="button"><i class='fa fa-copy' id='clipboard_copy_icon'></i></button>
            </span>
            <input type="text" style="width:100%;" class="form-control" id="custom-link-val" value="<img src='<?=$custom->get_pixel_link();?>' width='1' height='1'>" ><br>
        </div><br>
        Выберите какие параметры отслеживать (помимо параметров из таблицы трекер хранит все параметры начинающиеся с префикса pbsave_):<br>
        
        <table class="table table-hover table-striped">
            <tr>
                <td><input type="checkbox" id="profit"></td>
                <td>Сумма конверсии:</td>
                <td><input type="text" id="profit_val" value=""></td>
            </tr>
            <tr>
                <td><input type="checkbox" id="int_param3"></td>
                <td>ID заказа:</td>
                <td><input type="text" id="int_param3_val" value=""></td>
            </tr>
        </table>
    </div>    
</div>