<?
$script_url = str_replace ('http://','',  str_replace ('/track-show/', '/track/postback.php', full_url()));
$default_params = "?t=[TYPE]&a=[AMOUNT]&c=[CURRENCY]&s=[SUBID]";
$postbackurl = _e($script_url.$default_params);
$networks = array('default', 'actionads.ru', 'primelead.com.ua', 'adwad.ru', 'actionpay.ru');
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
      // this.style.display = 'none';
      $('#clipboard_copy_icon').animate({opacity: 0.4}, "fast").animate({opacity: 1}, "fast");
});


   $('#network').change(function() {
     text_val = $(this).val();

   $.ajax({
            type: "POST",
            url: "postback_link.php",
            data: "network="+text_val
        }).done(function(msg) {
            var template = $('#postbackTemplate').html();
            var template_data = $.parseJSON(msg);


            var html = Mustache.to_html(template, template_data);


            $('#postback_container').html(html);

            });


});

  });
</script>

<script id="postbackTemplate" type="text/template">

 <div class="col-lg-8">
    <div class="input-group">
      <input type="text" class="form-control" id='global_postback_url' value="http://{{url}}">
      <span class="input-group-btn">
        <button id="copy-button" class="btn btn-default" data-clipboard-target='global_postback_url' title="Скопировать в буфер" type="button"><i class='fa fa-copy' id='clipboard_copy_icon'></i></button>
      </span>
    </div><!-- /input-group -->
    <p class="help-block">Добавьте эту ссылку в качестве Postback URL в CPA сети</p>
  </div><!-- /.col-lg-8 -->

<br />

<div class="row">
  <div class="col-lg-8">
  <p><b> Описание параметров</b></p>

  {{{vars}}}
</div>
</div>


</script>



<p><strong>Автоматический импорт продаж</strong></p>

	<form role="form" class="form-horizontal" method="post" id='add_costs' onsubmit="return add_costs();">
<div class="row">
  <div class="col-lg-8">




            <div class="form-group">
		    <label class="col-sm-12">Выберите CPA сеть для автоматической генерации Postback URL</label>
		    <div class='col-sm-10'>

			<select class='select2' style='width:100%' name='network' id='network'>
	<?
    foreach ($networks as $network)
    {
    print '<option value="'.$network.'">'.$network.'</option>';
    }

    ?>     </select>

			</div><!-- /.col-sm-10 -->
		</div><!-- /.form-group -->

  </div><!-- /.col-lg-8 -->


  <div class="col-lg-10"  id="postback_container">
  <div class="col-lg-8">
    <div class="input-group">
      <input type="text" class="form-control" id='global_postback_url' value="http://<? echo $postbackurl;?>">
      <span class="input-group-btn">
        <button id="copy-button" class="btn btn-default" data-clipboard-target='global_postback_url' title="Скопировать в буфер" type="button"><i class='fa fa-copy' id='clipboard_copy_icon'></i></button>
      </span>
    </div><!-- /input-group -->
    <p class="help-block">Добавьте эту ссылку в качестве Postback URL в CPA сети</p>
  </div><!-- /.col-lg-8 -->

<br />

<div class="row">
  <div class="col-lg-8">
  <p><b> Описание параметров</b></p>

  [TYPE] &mdash; sale или lead<br />
  [AMOUNT] &mdash; доход от продажи<br />
  [CURRENCY] &mdash; usd или rub<br />
  [SUBID] &mdash; значение SubID<br />
</div>
</div>

</div><!-- /#postback_container -->

</div><!-- /.row -->
</form>