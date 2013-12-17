<? if (!$include_flag){exit();} ?>
<?
    $arr_timezone_settings=get_timezone_settings();
    if (count ($arr_timezone_settings)==0)
    {
        $arr_timezone_selected_name='Сервер';
    }
    else
    {
        foreach ($arr_timezone_settings as $cur)
        {
            if ($cur['is_active']==1)
            {
                $arr_timezone_selected_name=$cur['timezone_name'];
                break;           
            }
        }
    }
?>
<script>
    function change_current_timezone(id)
    {
        $.ajax({
          type: "get",
          url: "index.php",
          data: { ajax_act: "change_current_timezone", id: id }
        })
          .done(function( msg ) 
          {
            location.reload(true); 
          });        
        return false;
    }
</script>
<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container-fluid">
      <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="brand" href="?act=">CPA Tracker</a>
      <div class="nav-collapse collapse">
        <p class="navbar-text pull-right">
          <!-- Logged in as <a href="#" class="navbar-link">Username</a> -->
        </p>
        <ul class="nav">
          <li <? if ($_REQUEST['page']==''){echo 'class="active"';}?>><a href="?act=">Отчеты</a></li>
          <li <? if ($_REQUEST['page']=='links'){echo 'class="active"';}?>><a href="?page=links">Ссылки</a></li>
          <li <? if ($_REQUEST['page']=='rules'){echo 'class="active"';}?>><a href="?page=rules">Правила</a></li>
          <li <? if ($_REQUEST['page']=='costs'){echo 'class="active"';}?>><a href="?page=costs">Затраты</a></li>                     
          <li <? if ($_REQUEST['page']=='import'){echo 'class="active"';}?>><a href="?page=import">Импорт</a></li>
          <li <? if ($_REQUEST['page']=='support'){echo 'class="active"';}?>><a href="?page=support">Поддержка</a></li>
        </ul>
      </div><!--/.nav-collapse -->
      <ul class="nav pull-right">
        <li class="dropdown">
          <a class="dropdown-toggle" id="drop4" role="button" data-toggle="dropdown" href="#"><i class='icon-time icon-white'></i> <?=_e($arr_timezone_selected_name);?> <b class="caret"></b></a>
          <ul id="menu1" class="dropdown-menu" role="menu" aria-labelledby="drop4">
            <?
                foreach ($arr_timezone_settings as $cur)
                {
                    if ($cur['is_active']!=1)
                    {
                        echo "<li role='presentation'><a role='menuitem' tabindex='-1' href='#' onclick='return change_current_timezone({$cur['id']})'>"._e($cur['timezone_name'])."</a></li>";                        
                    }
                }
                if (count($arr_timezone_settings)>1)
                {
                    echo "<li role='presentation' class='divider'></li>";
                }
            ?>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="?page=settings&type=timezone"><i class='icon-cog'></i> Настроить часовой пояс</a></li>
          </ul>
        </li>        
        <li><a href="?page=logout">Выход</a></li>
      </ul>      
    </div>
  </div>
</div>