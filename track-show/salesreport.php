<?php
if (!$include_flag) {
    exit();
}

$from = $_REQUEST['sStart'];
$to = $_REQUEST['sEnd'];
$total = array();
$month = false;
if ($_REQUEST['subtype']=='monthly') {
    if ($from == '') {
        if ($to == '') {
            $from = get_current_day('-6 days');
            $to = get_current_day();
        } else {
            $from = date('Y-m-d', strtotime('-6 month', strtotime($to)));
        }
    } else {
        if ($to == '') {
            $to = date('Y-m-d', strtotime('+6 month', strtotime($from)));
        }
    }
    $days = getMonthsBetween($from, $to);
    
    $month_active = 'active';
    $month = true;
} else {
    if ($from == '') {
        if ($to == '') {
            $from = get_current_day('-6 days');
            $to = get_current_day();
        } else {
            $from = date('Y-m-d', strtotime('-6 days', strtotime($to)));
        }
    } else {
        if ($to == '') {
            $to = date('Y-m-d', strtotime('+6 days', strtotime($from)));
        }
    }
    $days = getDatesBetween($from, $to);
    
    $days_active='active';
    
}

$sales = get_sales($from, $to, $days, $month);
krsort($sales);
?>
    <div class="row">
        <div class="col-md-4">
            <div class="btn-group">
                <a href="?act=reports&type=salesreport&subtype=daily" type="button" class="btn btn-default <?=$days_active?>">По дням</a>
                <a href="?act=reports&type=salesreport&subtype=monthly" type="button" class="btn btn-default <?=$month_active?>">По месяцам</a>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class="col-md-4"><h3>Продажи по дням:</h3></div>
        <div id="per_day_range" class="pull-right">
            <span class="glyphicon glyphicon-calendar"></span>
            <span id="cur_day_range"><?php echo date(($month)?'m.Y':'d.m.Y', strtotime($from)); ?> - <?php echo date(($month)?'m.Y':'d.m.Y', strtotime($to)); ?></span> <b class="caret"></b>
            <form action="index.php?act=reports&type=salesreport&subtype=<?=($month)?'monthly':'daily'?>" method="POST">
                <input type="hidden" name="sStart" id="sStart" value="">
                <input type="hidden" name="sEnd" id="sEnd" value="">
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php if (is_array($sales)) :?>
            <div id="chart_div"></div>
            <?php endif;?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class='table table-condensed table-striped table-bordered dataTableT'>
                <thead>
                    <tr>
                        <th>Источник</th>
                        <?php foreach ($days as $day) : ?>
                            <th><?= (!$month)?date('d.m', strtotime($day)):$day; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($sales == FALSE) :?>
                    <tr>
                        <td colspan="<?=count($days)+1;?>" style="text-align: center;">
                            За выбранный период продаж не было.
                        </td>
                    </tr>
                    <?php else : ?>
                        <?php foreach ($sales as $sale => $d) :?>
                            <tr>
                                <td><?php if($sale == '_') echo ' '; else echo $sale;?></td>
                                <?php foreach ($days as $day) : ?>
                                    <?php $dkey = (!$month)?date('d.m', strtotime($day)):$day;?>
                                    <td>
                                        <?php if (isset($d[$dkey])):?>
                                            <?=$d[$dkey];?>
                                            <?php $total[$dkey]+=$d[$dkey];?>
                                        <?php else : ?>
                                            0
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach;?>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Итого:</th>
                        <?php foreach ($days as $day) : ?>
                            <th><?= intval($total[(!$month)?date('d.m', strtotime($day)):$day]); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

<link href="lib/daterangepicker/daterangepicker-bs3.css" rel="stylesheet"/>
<script src="lib/daterangepicker/moment.min.js"></script>
<script src="lib/daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script>
    $('#per_day_range').daterangepicker(
            {
                <?php if ($_REQUEST['subtype']=='monthly') :?>
                format: 'MM.YYYY',
                <?php else : ?>    
                format: 'DD.MM.YYYY',
                <?php endif; ?>
                locale: {
                    applyLabel: "Выбрать",
                    cancelLabel: "<i class='fa fa-times' style='color:gray'></i>",
                    fromLabel: "От",
                    toLabel: "До",
                    customRangeLabel: 'Свой интервал',
                    daysOfWeek: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб']
                },
                ranges: {
                    <?php if ($_REQUEST['subtype']=='monthly') :?>
                    'Последние 3 мес': [moment().subtract('month', 3).startOf('month').startOf('month')],
                    'Последние 6 мес': [moment().subtract('month', 6).startOf('month'), moment()],
                    'Последний год': [moment().subtract('month', 12).startOf('month'), moment()],
                    'Последние 2 года': [moment().subtract('month', 24).startOf('month'), moment()],
                    <?php else : ?>
                    'Сегодня': [moment(), moment()],
                    'Вчера': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'Последние 7 дней': [moment().subtract('days', 6), moment()],
                    'Последние 30 дней': [moment().subtract('days', 29), moment()],
                    'Ткущий месяц': [moment().startOf('month'), moment().endOf('month')],
                    'Прошлый месяц': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                    <?php endif; ?>
                }
            },
    function(start, end) {
        $('#cur_day_range').text(start.format(<?=($month)?"'MM.YYYY'":"'DD.MM.YYYY'";?>) + ' - ' + end.format(<?=($month)?"'MM.YYYY'":"'DD.MM.YYYY'";?>));
        $('#sStart').val(start.format('YYYY-MM-DD'));
        $('#sEnd').val(end.format('YYYY-MM-DD'));
        $('#per_day_range form').submit();
    }
    );


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
   <?php if (is_array($sales)) :?> 
    google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          [<?php if ($_REQUEST['subtype']=='monthly') echo "'Месяц'"; else echo "'День'";?>, 'Продажи'],
          <?php $i = 0;?>
          <?php foreach ($days as $day) : ?>
              <?php $i++;?>
              <?php $dkey = (!$month)?date('d.m', strtotime($day)):$day; ?>
              <?= '[\''.$dkey.'\', '. intval($total[$dkey]).']'; ?><?php if ($i < count($days)) echo ',';?>
                
          <?php endforeach; ?>
        ]);

        var options = {
          title: 'Отчет продаж',
          width: '100%',
          height: 500,
          chartArea: {left: '20',width:'800'},
          legend: {position: 'in'},
          hAxis: {title: 'Количество'}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
      <?php endif;?>
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