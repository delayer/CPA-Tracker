<? if (!$include_flag){exit();} ?>
<?php
	$filter_by=trim($_REQUEST['filter_by']);
	$arr_sales=get_last_sales($filter_by);
?>
<div class="row">
	<form class="form-inline" role="form" method="post">
		<input type='hidden' name='act' value='reports'>
		<input type='hidden' name='type' value='sales'>
		<input type='hidden' name='sales' value='sales'>

		<div class="form-group col-xs-4">
			<input type="text" class="form-control" name="filter_by" placeholder="Поиск по SubID" value="<?=_e($_REQUEST['filter_by']);?>">
		</div>

		<button type="submit" class="btn btn-default">Найти</button>
	</form>
</div>
<div class='row'>&nbsp;</div>
<?php
	echo "<div class='row'>";
	echo "<div class='col-md-12'>";
	echo "<table class='table table-striped table-bordered table-condensed' style='width:600px;'>";
		echo "<thead>";
		echo "<tr><th>Дата</th><th>Ссылка</th><th>Сумма</th><th>Страна</th><th>Источник</th><th>Кампания</th><th>Реферер</th><th>SubID</th></tr>";
		echo "</thead>";
		echo "<tbody>";	
			foreach ($arr_sales as $cur)
			{

				$cur_referrer=$cur['referer'];
				if (strpos($cur_referrer, 'http://')===0){$cur_referrer=substr($cur_referrer, strlen('http://'));}
				if (strpos($cur_referrer, 'https://')===0){$cur_referrer=substr($cur_referrer, strlen('https://'));}
				if (strpos($cur_referrer, '/')===(strlen($cur_referrer)-1)){$cur_referrer=substr($cur_referrer, 0, -1);}
				
				if (strlen($cur_referrer)>40)
				{
					$cur_referrer=substr($cur_referrer,0,38).'…';
				}

				echo "<tr class='sales_row'  style='cursor:pointer;' onclick='$(this).next().toggle();'>";			
					echo "<td nowrap>".mysqldate2short($cur['date_add'])."</td>
							<td nowrap>"._e($cur['offer_name']);
							echo "<div class='btn-group sales_menu'>
								<button class='btn btn-default btn-xs dropdown-toggle' data-toggle='dropdown'><span class='caret'></span></button>
								<ul class='dropdown-menu'>
									<li><a href='#' style='color:red;' onclick=\"return delete_sale(this, '"._e($cur['type'])."', '"._e($cur['click_id'])."', '"._e($cur['conversion_id'])."')\">Удалить продажу</a></li>
								</ul>
							</div>";							
							echo "</td>
							<td>"._e(round($cur['profit'], 3))."</td>
							<td>"._e($cur['country'])."</td>
							<td>"._e($cur['source_name'])."</td>
							<td>"._e($cur['campaign_name'])." "._e($cur['ads_name'])."</td>
							<td><a target='_blank' href='http://anonym.to/?"._e($cur['referer'])."'>"._e($cur_referrer)."</a></td>
					<td>"._e($cur['subid'])."</a>";
					echo "</td>";
				echo "</tr>";
                                
                                echo '<tr style="display:none;"><td colspan="8">';
                                if ($cur['txt_param1'] != '') {
                                    echo "<span class='badge' style='float:right; font-weight:normal; margin-right:25px;'>"._e($cur['txt_param1'])."</span>";
                                }
                                
                                if ($cur['date_add'] != '') {
                                    echo 'Дата конверсии: '. $cur['date_add'].'<br>';
                                }
                                
                                echo 'Сеть: '.$cur['network'].'<br>';
                                
                                echo 'Статус: ';
                                if ($cur['txt_status'] != '') {
                                    echo $cur['txt_status'];
                                }
                                else {
                                    switch ($cur['status']) {
                                        case '1':
                                            echo 'Approved';
                                            break;
                                        case '2':
                                            echo 'Declined';
                                            break;
                                        case '3':
                                            echo 'Waiting';
                                            break;
                                        default:
                                            echo 'Unknown';
                                            break;
                                    }
                                }
                                echo '<br>';
                                
                                echo 'SubID: '.$cur['subid'];
                                
                                if ($cur['txt_param16'] != '' || $cur['txt_param17'] != '' || $cur['txt_param18'] != '' || $cur['txt_param19'] != '') {
                                    echo '('.$cur['txt_param16'].' '.$cur['txt_param17'].' '.$cur['txt_param18'].' '.$cur['txt_param19'].' '.')';
                                }
                                echo '<br>';
                                
                                if ($cur['txt_param20'] != '') {
                                    echo 'Валюта: '.$cur['txt_param20'].'<br>';
                                }
                                
                                if ($cur['int_param3'] != 0) {
                                    echo 'ID транзакции: '.$cur['int_param3'].'<br>';
                                }
                                
                                if ($cur['int_param9'] != 0) {
                                    echo 'ID выплаты: '.$cur['int_param9'].'<br>';
                                }
                                
                                if ($cur['txt_param2'] != '') {
                                    echo 'UserAgent: '.$cur['txt_param2'].'<br>';
                                }
                                
                                if ($cur['txt_param3'] != '') {
                                    echo 'Цель: '.$cur['txt_param3'].'<br>';
                                }
                                if ($cur['int_param1'] != 0){
                                    echo 'ID Цели: '.$cur['int_param1'].'<br>';
                                }                    
                                if ($cur['int_param2'] != 0) {
                                    echo 'Оффер: '.$cur['int_param2'];
                                    if ($cur['txt_param4'] != '') {
                                        echo ' - '.$cur['txt_param4'];
                                    }
                                    echo '<br>';                                    
                                }
                                
                                if ($cur['txt_param5'] != '') {
                                    echo 'Unique ID: '.$cur['txt_param5'].'<br>';
                                }
                                
                                if ($cur['int_param7'] != 0) {
                                    echo 'Поток: '.$cur['int_param7'];
                                    if ($cur['txt_param6'] != '') {
                                        echo ' - '.$cur['txt_param6'];
                                    }
                                    
                                    echo '<br>';
                                }
                                
                                if ($cur['int_param8'] != 0 || $cur['txt_param7'] != '') {
                                    echo 'Источник: '.$cur['int_param8'].' '.$cur['txt_param7'].'<br>';
                                }
                                
                                if ($cur['txt_param8'] != '') {
                                    echo 'CPL/CPA: '.$cur['txt_param8'].'<br>';
                                }
                                
                                if ($cur['txt_param9'] != '') {
                                    echo 'Страна: '.$cur['txt_param9'].'<br>';
                                }
                                
                                if ($cur['txt_param10'] != '') {
                                    echo 'Город: '.$cur['txt_param10'].'<br>';
                                }
                                
                                if ($cur['txt_param11'] != '') {
                                    echo 'Браузер: '.$cur['txt_param11'].'<br>';
                                }
                                
                                if ($cur['txt_param12'] != '') {
                                    echo 'ОС: '.$cur['txt_param12'].'<br>';
                                }
                                
                                if ($cur['txt_param13'] != '') {
                                    echo 'Устройство: '.$cur['int_param13'].' '.$cur['txt_param13'].'<br>';
                                }
                                
                                
                                if ($cur['txt_param15'] != '') {
                                    echo 'Баннер: '.$cur['int_param10'].' '.$cur['txt_param15'].'<br>';
                                }
                                
                                if (count($cur['add']) > 0) {
                                    echo 'Дополнительно:<br>';
                                    foreach ($cur['add'] as $add) {
                                        echo $add['name'].':'.$add['value'].'<br>';
                                    }
                                }
                                
                                echo '</td></tr>';
			}
		echo "</tbody>";
	echo "</table>";
	echo "</div> <!-- ./col-md-12 -->";
	echo "</div> <!-- ./row -->";
?>
<script>
function delete_sale(obj, type, click_id, conversion_id)
{
	$.ajax({
	  type: 'POST',
	  url: 'index.php',
	  data: 'csrfkey=<?php echo CSRF_KEY;?>&ajax_act=delete_sale&type='+type+'&click_id='+click_id+'&conversion_id='+conversion_id
	}).done(function( msg ) 
	{
		$(obj).parent().parent().parent().parent().parent().remove();
	});

	return false;
}
</script>

<style>
	.sales_row:hover .sales_menu, .sales_row.hover .sales_menu { visibility: visible; }
	.sales_menu{
		visibility: hidden; float:right; margin-left:5px;
	}
</style>