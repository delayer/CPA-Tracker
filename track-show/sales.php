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
<?
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

				echo "<tr class='sales_row'>";			
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