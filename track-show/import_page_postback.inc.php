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
  });
</script>

<p><strong>Автоматический импорт продаж</strong></p>


<div class="row">
  <div class="col-lg-6">
    <div class="input-group">
      <input type="text" class="form-control" id='global_postback_url' value="http://<? echo _e(str_replace ('http://','',  str_replace ('/track-show/', '/track/postback.php', full_url())));?>?t=[TYPE]&a=[AMOUNT]&c=[CURRENCY]&s=[SUBID]">
      <span class="input-group-btn">
        <button id="copy-button" class="btn btn-default" data-clipboard-target='global_postback_url' title="Скопировать в буфер" type="button"><i class='fa fa-copy' id='clipboard_copy_icon'></i></button>
      </span>
    </div><!-- /input-group -->
    <p class="help-block">Добавьте эту ссылку в качестве Postback URL в CPA сети</p>
  </div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<br />

<div class="row">
  <div class="col-lg-12">
  <p><b> Описание параметров</b></p>
   
  [TYPE] &mdash; sale или lead<br />
  [AMOUNT] &mdash; доход от продажи<br />
  [CURRENCY] &mdash; usd или rub<br />
  [SUBID] &mdash; значение SubID<br />
</div>
</div>