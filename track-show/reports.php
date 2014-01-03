<? if (!$include_flag){exit();} ?>
<script src="js/report_toolbar.js"></script>
<?php
// Create dates array for reports
$date1 = date('Y-m-d', strtotime('-6 days', strtotime(date('Y-m-d'))));
$date2 = date('Y-m-d');
$arr_dates = getDatesBetween($date1, $date2);

switch ($_REQUEST['type']) {
    case 'daily_stats':
        // Show report name
        $subtype = $_REQUEST['subtype'];
        switch ($subtype) {
            case 'out_id':
                $report_name = "Переходы по ссылкам за ";
                $report_main_column_name = "Ссылка";
                $empty_name = "Без ссылки";
                break;

            case 'source_name':
                $report_name = "Переходы по источникам за ";
                $report_main_column_name = "Источник";
                $empty_name = "Без источника";
                break;
        }

        $from = $_REQUEST['from'];
        $to = $_REQUEST['to'];
        if ($from == '') {
            if ($to == '') {
                $from = get_current_day('-6 days');
                $to = get_current_day();
            } else {
                $from = date('d.m.Y', strtotime('-6 days', strtotime($to)));
            }
        } else {
            if ($to == '') {
                $to = date('d.m.Y', strtotime('+6 days', strtotime($from)));
            } else {
                // Will use existing values
            }
        }

        $fromF = date('d.m.Y', strtotime($from));
        $toF = date('d.m.Y', strtotime($to));
        $value_date_range = "$fromF - $toF";
        $days_active = '';
        $month_active = '';
        if($_GET['type']=='monthly_stats'){$month_active = 'active';}else{$days_active='active';}
        echo '<div class="btn-group">
          <a href="?act=reports&type=daily_stats&subtype='.$_GET['subtype'].'" type="button" class="btn btn-default '.$days_active.'">По дням</a>
          <a href="?act=reports&type=monthly_stats&subtype='.$_GET['subtype'].'" type="button" class="btn btn-default '.$month_active.'">По месяцам</a>
        </div>';
        echo '<form method="post"  name="datachangeform">
                <div style="width: 229px;float: right;position: relative;top: -5px;">
                    <div class="input-group">                          
			  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
			  <input style="width: 192px;" type="text" name="date_range" value="' . $value_date_range . '" id="putdate_range" class="form-control">
			  <input type="hidden" id="form_range_from" name="from" value="' . $from . '">
                          <input  id="form_range_to"  type="hidden" name="to" value="' . $to . '">
                    </div>
                </div>
                <div><h3>' . $report_name . '</h3></div>
              </form>';

        // Show report data
        include "report_daily.inc.php";
        break;
     case 'monthly_stats':
            // Show report name
            $subtype = $_REQUEST['subtype'];
            switch ($subtype) {
                case 'out_id':
                    $report_name = "Переходы по ссылкам за ";
                    $report_main_column_name = "Ссылка";
                    $empty_name = "Без ссылки";
                    break;

                case 'source_name':
                    $report_name = "Переходы по источникам за ";
                    $report_main_column_name = "Источник";
                    $empty_name = "Без источника";
                    break;
            }

            $from = $_REQUEST['from'];
            $to = $_REQUEST['to'];
            if ($from == '') {
                if ($to == '') {
                    $from = get_current_day('-6 months');
                    $to = get_current_day();
                } else {
                    $from = date('d.m.Y', strtotime('-6 months', strtotime($to)));
                }
            } else {
                if ($to == '') {
                    $to = date('d.m.Y', strtotime('+6 months', strtotime($from)));
                } else {
                     $from=date ('Y-m-d',  strtotime('13.'.$from));
                         $to=date ('Y-m-d', strtotime('13.'.$to));
                }
            }
            $from=date ('Y-m-01',  strtotime($from));
            $to=date ('Y-m-t',  strtotime($to));
            $fromF = date('m.Y', strtotime($from));
            $toF = date('m.Y', strtotime($to));
                
            $days_active = '';
            $month_active = '';
            if($_GET['type']=='monthly_stats'){$month_active = 'active';}else{$days_active='active';}
            echo '<div class="btn-group">
              <a href="?act=reports&type=daily_stats&subtype='.$_GET['subtype'].'" type="button" class="btn btn-default '.$days_active.'">По дням</a>
              <a href="?act=reports&type=monthly_stats&subtype='.$_GET['subtype'].'" type="button" class="btn btn-default '.$month_active.'">По месяцам</a>
            </div>';
            echo '<form method="post"  name="datachangeform">
             
                    <div style=" width: 240px; float: right;position: relative;top: -5px;">
                        <div class="input-group">                          
                              <div class="input-group-addon "><i class="fa fa-calendar"></i></div>
                      
                              <input style="display: inline; float:left; width: 80px;   border-right: 0;" id="dpMonthsF"   type="text"  data-date="102/2012" data-date-format="mm.yyyy" data-date-viewmode="years" data-date-minviewmode="months"  class="form-control"  name="from" value="' . $fromF . '">
                              <input style="display: inline; float:left; width: 80px;  border-right: 0;  border-top-right-radius: 0; border-bottom-right-radius: 0;" id="dpMonthsT"   type="text"  data-date="102/2012" data-date-format="mm.yyyy" data-date-viewmode="years" data-date-minviewmode="months" type="text" class="form-control"   name="to" value="' . $toF . '">
                              <button type="button" style="width:40px;" class="btn btn-default form-control" onclick="$(\'[name = datachangeform]\').submit();"><i class="glyphicon glyphicon-search"></i></button>  
                        </div>

				 
                    </div>
                    <div><h3>' . $report_name . '</h3></div>
                  </form>';

            // Show report data
            include "report_monthly.inc.php";
            break;
    case 'daily_grouped':
        // Show report data
        include "report_daily_grouped.inc.php";
        break;
}
?>

<link href="lib/datatables/css/jquery.dataTables.css" rel="stylesheet">
<link href="lib/datatables/css/dt_bootstrap.css" rel="stylesheet">
<script src="lib/datatables/js/jquery.dataTables.min.js" charset="utf-8" type="text/javascript"></script>
<script src="lib/datatables/js/dt_bootstrap.js" charset="utf-8" type="text/javascript"></script>
<script src="lib/sparkline/jquery.sparkline.min.js"></script>
<link href="lib/daterangepicker/daterangepicker-bs3.css" rel="stylesheet"/>
<script src="lib/daterangepicker/moment.min.js"></script>
<script src="lib/daterangepicker/daterangepicker.js"></script>
<link href="lib/datepicker/css/datepicker.css" rel="stylesheet"/>
<script type="text/javascript" src="lib/datepicker/js/bootstrap-datepicker.js"></script>
 
<script>
    $('#dpMonthsF').datepicker();
    $('#dpMonthsT').datepicker();
    $('#putdate_range').daterangepicker({format: 'DD.MM.YYYY', locale: {applyLabel: "Выбрать", cancelLabel: "<i class='fa fa-times' style='color:gray'></i>", fromLabel: "От", toLabel: "До", customRangeLabel: 'Свой интервал', daysOfWeek: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб']
        }});
    jQuery.fn.dataTableExt.oSort['click-data-asc'] = function(a, b) {
        x = $('.clicks', $('<div>' + a + '</div>')).text().split(':', 1);
        y = $('.clicks', $('<div>' + b + '</div>')).text().split(':', 1);

        if (x == '') {
            x = 0;
        }
        if (y == '') {
            y = 0;
        }
        x = parseFloat(x);
        y = parseFloat(y);

        return ((x < y) ? -1 : ((x > y) ? 1 : 0));
    };

    jQuery.fn.dataTableExt.oSort['click-data-desc'] = function(a, b)
    {
        x = $('.clicks', $('<div>' + a + '</div>')).text().split(':', 1);
        y = $('.clicks', $('<div>' + b + '</div>')).text().split(':', 1);
        if (x == '') {
            x = 0;
        }
        if (y == '') {
            y = 0;
        }
        x = parseFloat(x);
        y = parseFloat(y);
        return ((x < y) ? 1 : ((x > y) ? -1 : 0));
    };
</script>

<div class="row" id='report_toolbar'>
    <div class="col-md-12">
        <div class="form-group">

            <div class="btn-group" id='rt_type_section' data-toggle="buttons">
                <label id="rt_clicks_button" class="btn btn-default active" onclick='update_stats("clicks");'><input type="radio" name="option_report_type">Клики</label>
                <label id="rt_conversion_button" class="btn btn-default" onclick='update_stats("conversion");'><input type="radio" name="option_report_type">Конверсия</label>	
                <label id="rt_leadprice_button" class="btn btn-default" onclick='update_stats("lead_price");'><input type="radio" name="option_report_type">Стоимость лида</label>					
                <label id="rt_roi_button" class="btn btn-default" onclick='update_stats("roi");'><input type="radio" name="option_report_type">ROI</label>	
                <label id="rt_epc_button" class="btn btn-default" onclick='update_stats("epc");'><input type="radio" name="option_report_type">EPC</label>	
                <label id="rt_profit_button" class="btn btn-default" onclick='update_stats("profit");'><input type="radio" name="option_report_type">Прибыль</label>
            </div>

            <div class="btn-group" id='rt_sale_section' data-toggle="buttons">
                <label class="btn btn-default active" onclick='update_stats("sales");'><input type="radio" name="option_leads_type">Продажи</label>
                <label class="btn btn-default" onclick='update_stats("leads");'><input type="radio" name="option_leads_type">Лиды</label>	
            </div>

            <div class="btn-group invisible" id='rt_currency_section' data-toggle="buttons">
                <label class="btn btn-default active" onclick='update_stats("currency_rub");'><input type="radio" name="option_currency">руб.</label>
                <label class="btn btn-default" onclick='update_stats("currency_usd");'><input type="radio" name="option_currency">$</label>	
            </div>
        </div>
    </div> <!-- ./col-md-12 -->
</div> <!-- ./row -->

<input type='hidden' id='usd_selected' value='1'>
<input type='hidden' id='type_selected' value='clicks'>
<input type='hidden' id='sales_selected' value='1'>