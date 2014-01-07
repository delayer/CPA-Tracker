<? if (!$include_flag){exit();} ?>
<div class="span3">
  <div class="well sidebar-nav">
    <ul class="nav nav-list">
      <li class="nav-header">Посетители</li>
      <li <? if ($_REQUEST['type']==''){echo 'class="active"';}?>><a href="?act=">Лента переходов</a></li>
      <li <? if ($_REQUEST['subtype']=='source_name'){echo 'class="active"';}?>><a href="?act=reports&type=daily_stats&subtype=source_name">Переходы по источникам</a></li>
      <li <? if ($_REQUEST['subtype']=='out_id'){echo 'class="active"';}?>><a href="?act=reports&type=daily_stats&subtype=out_id">Переходы по ссылкам</a></li>      
      <li class="nav-header">Продажи</li>
      <li <? if ($_REQUEST['type']=='sales'){echo 'class="active"';}?>><a href="?act=reports&type=sales&subtype=sales">Отчет по продажам</a></li>
      <li <? if ($_REQUEST['type']=='salesreport'){echo 'class="active"';}?>><a href="?act=reports&type=salesreport&subtype=daily">Продажи за период</a></li>
    </ul>
  </div><!--/.well -->
</div><!--/span-->