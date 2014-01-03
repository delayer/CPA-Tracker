<?php
if (!$include_flag) {
    exit();
}
?>
<!--<div class="row">
        <form class="form-inline" role="form" method="post">
                <input type='hidden' name='act' value='reports'>
                <input type='hidden' name='type' value='sales'>
                <input type='hidden' name='sales' value='sales'>

                <div class="form-group col-xs-4">
                        <input type="text" class="form-control" name="filter_by" placeholder="Поиск по SubID" value="<?= _e($_REQUEST['filter_by']); ?>">
                </div>

                <button type="submit" class="btn btn-default">Найти</button>
        </form>
</div>-->
<div class="jumbotron" style="padding: 10px;"> 
    <div class='row'>
        <div class="col-md-4"><h3>Продажи по дням:</h3></div>
        <div id="per_day_range" class="pull-right">
            <span class="glyphicon glyphicon-calendar"></span>
            <span id="cur_day_range"><?php echo date("d.m.Y", strtotime('-30 day')); ?> - <?php echo date("d.m.Y"); ?></span> <b class="caret"></b>
        </div>
    </div>

</div>
<?php
//	echo "<div class='row'>";
//	echo "<div class='col-md-12'>";
//	echo "<table class='table table-striped table-bordered table-condensed' style='width:600px;'>";
//		echo "<thead>";
//		echo "<tr><th>Дата</th><th>Ссылка</th><th>Сумма</th><th>Страна</th><th>Источник</th><th>Кампания</th><th>Реферер</th><th>SubID</th></tr>";
//		echo "</thead>";
//		echo "<tbody>";	
//			foreach ($arr_sales as $cur)
//			{
//
//				$cur_referrer=$cur['referer'];
//				if (strpos($cur_referrer, 'http://')===0){$cur_referrer=substr($cur_referrer, strlen('http://'));}
//				if (strpos($cur_referrer, 'https://')===0){$cur_referrer=substr($cur_referrer, strlen('https://'));}
//				if (strpos($cur_referrer, '/')===(strlen($cur_referrer)-1)){$cur_referrer=substr($cur_referrer, 0, -1);}
//				
//				if (strlen($cur_referrer)>40)
//				{
//					$cur_referrer=substr($cur_referrer,0,38).'…';
//				}
//
//				echo "<tr class='sales_row'>";			
//					echo "<td nowrap>".mysqldate2short($cur['date_add'])."</td>
//							<td nowrap>"._e($cur['offer_name']);
//							echo "<div class='btn-group sales_menu'>
//								<button class='btn btn-default btn-xs dropdown-toggle' data-toggle='dropdown'><span class='caret'></span></button>
//								<ul class='dropdown-menu'>
//									<li><a href='#' style='color:red;' onclick=\"return delete_sale(this, '"._e($cur['type'])."', '"._e($cur['click_id'])."', '"._e($cur['conversion_id'])."')\">Удалить продажу</a></li>
//								</ul>
//							</div>";							
//							echo "</td>
//							<td>"._e(round($cur['profit'], 3))."</td>
//							<td>"._e($cur['country'])."</td>
//							<td>"._e($cur['source_name'])."</td>
//							<td>"._e($cur['campaign_name'])." "._e($cur['ads_name'])."</td>
//							<td><a target='_blank' href='http://anonym.to/?"._e($cur['referer'])."'>"._e($cur_referrer)."</a></td>
//					<td>"._e($cur['subid'])."</a>";
//					echo "</td>";
//				echo "</tr>";				
//			}
//		echo "</tbody>";
//	echo "</table>";
//	echo "</div> <!-- ./col-md-12 -->";
//	echo "</div> <!-- ./row -->";
?>
<link href="lib/daterangepicker/daterangepicker-bs3.css" rel="stylesheet"/>
<script src="lib/daterangepicker/moment.min.js"></script>
<script src="lib/daterangepicker/daterangepicker.js"></script>
<script>
    $('#per_day_range').daterangepicker(
            {
                format: 'DD.MM.YYYY',
                locale: {
                    applyLabel: "Выбрать",
                    cancelLabel: "<i class='fa fa-times' style='color:gray'></i>",
                    fromLabel: "От",
                    toLabel: "До",
                    customRangeLabel: 'Свой интервал',
                    daysOfWeek: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб']
                },
                ranges: {
                    'Сегодня': [moment(), moment()],
                    'Вчера': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'Последние 7 дней': [moment().subtract('days', 6), moment()],
                    'Последние 30 дней': [moment().subtract('days', 29), moment()],
                    'Ткущий месяц': [moment().startOf('month'), moment().endOf('month')],
                    'Прошлый месяц': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                }
            },
    function(start, end) {
        $('#cur_day_range').text(start.format('DD.MM.YYYY') + ' - ' + end.format('DD.MM.YYYY'));
        get_sales('by_day', start.format('DD.MM.YYYY'), end.format('DD.MM.YYYY'));
    }
    );


    function get_sales(type, start, end) {
        $.post(
            'index.php?ajax_act=get_sales',
            {
                sType: type,
                sStart: start,
                sEnd: end
            },
            'json'
        ).done(function(data){
            console.log(data);
        });
    
    }


    function delete_sale(obj, type, click_id, conversion_id)
    {
        $.ajax({
            type: 'POST',
            url: 'index.php',
            data: 'ajax_act=delete_sale&type=' + type + '&click_id=' + click_id + '&conversion_id=' + conversion_id
        }).done(function(msg)
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

    #per_day_range {
        background: #ffffff;
        -webkit-box-shadow: 0 1px 3px rgba(0,0,0,.25), inset 0 -1px 0 rgba(0,0,0,.1);
        -moz-box-shadow: 0 1px 3px rgba(0,0,0,.25), inset 0 -1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 3px rgba(0,0,0,.25), inset 0 -1px 0 rgba(0,0,0,.1);
        color: #333333;
        padding: 8px;
        line-height: 18px;
        cursor: pointer;
        margin-top: 12px;
        margin-right: 20px;
    }
    
</style>