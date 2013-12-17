<? if (!$include_flag){exit();} ?>

<div class='span6'>
	<form class="form-horizontal" id="form_settings" onsubmit="return save_settings();">
	  <input type='hidden' name='ajax_act' value='create_database'>
	  <legend>Настройки базы данных</legend>
	  <div class="control-group">
	    <label class="control-label" for="login">Логин</label>
	    <div class="controls">
	      <input type="text" id="login" name='login'>
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="password">Пароль</label>
	    <div class="controls">
	      <input type="text" id="password" name='password'>
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="dbname">Название базы данных</label>
	    <div class="controls">
	      <input type="text" id="dbname" name='dbname'>
	    </div>
	  </div>  
	<div class="control-group">
	    <label class="control-label" for="dbserver">Сервер базы данных</label>
	    <div class="controls">
	      <input type="text" id="dbserver" name="dbserver" value="localhost">
	    </div>
	  </div>  

	  <legend>Настройки сервера</legend> 
	  <div class="control-group">
	      <label class="control-label" for="server_type">Тип сервера</label>
	      <div class="controls">
	        <select id="server_type" name="server_type" style='margin-right:10px;'>
			  <option value='apache' selected>Apache</option>
			  <option value='nginx'>Nginx</option>
			</select>
			<span style='cursor:pointer; border-bottom:1px lightgray dashed; font-family:"Tahoma";' onclick='$("#server_type_help").toggle();'>как&nbsp;узнать?</span>
		   </div>
		   <div id='server_type_help' class='well'>
		   	<span class='btn_close' onclick='$("#server_type_help").hide();'>&times;</span>
		   	<p>Определите ваш текущий IP адрес на <a href='http://www.whatismyip.com' target='_blank'>www.whatismyip.com</a></p>
		   	<p>Найдите ваш IP адрес в таблице:</p>
		   	<table class='table'>
		   		<thead>
		   			<tr><th>IP адрес</th><th>Тип сервера</th></tr></thead>
		   		<tbody>
					<tr>
						<td><?=$_SERVER['REMOTE_ADDR'];?></td>
						<td>Apache</td>
					</tr>
					<tr>
						<td><?=$_SERVER['HTTP_X_FORWARDED_FOR'];?></td>
						<td>Nginx</td>
					</tr>
		   		</tbody>
		   	</table>
		   </div>
	  </div>

	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn">Сохранить</button>
		</div>
	</div>	  

	</form>

	<div id="info_message" class="alert row">
	  <span class='btn_close' onclick='$("#info_message").hide();'>&times;</span>
	  <span id="info_message_text"></span>
	</div>

</div>



<style>
	#info_message, #server_type_help{
		display: none;
		margin-top:10px;
	}

	.btn_close{
	   	float: right;
		font-size: 20px;
		font-weight: bold;
		line-height: 20px;
		color: #000000;
		text-shadow: 0 1px 0 #ffffff;
		opacity: 0.2;
		filter: alpha(opacity=20); cursor:pointer;
	}
</style>
<script>
	$(document).ready(function() 
	{
		$('#login').focus();
	});
	function save_settings()
	{
		$('#info_message').hide();
		if ($('#login').val()=='')
		{
			$('#login').focus();
			return false;
		}	

		if ($('#password').val()=='')
		{
			$('#password').focus();
			return false;
		}	

		if ($('#dbname').val()=='')
		{
			$('#dbname').focus();
			return false;
		}			

		if ($('#dbserver').val()=='')
		{
			$('#dbserver').focus();
			return false;
		}
		
		$.ajax({
		  type: 'POST',
		  url: 'index.php',
		  data: $('#form_settings').serialize()
		}).done(function( msg ) 
		{
			var result=jQuery.parseJSON(msg);
			if (result[0])
			{
				window.location.replace(result[1]);
				return; 
			}
			else
			{
				switch (result[1])
				{
					case 'config_found': 
						$('#info_message_text').html('Файл с настройками уже найден:<br />'+result[2]+'<br />Перед сохранением новых параметров его необходимо удалить.');
						$('#info_message').show();
					break;
					
					case 'cache_not_writable': 
						$('#info_message_text').html('Установите права на запись (777) для папки <br />'+result[2]);
						$('#info_message').show();
					break;

					case 'db_error':
						$('#info_message_text').html('Ошибка базы данных<br />'+result[2]);
						$('#info_message').show();
					break;

					case 'db_not_found': 
						$('#info_message_text').html('База данных '+result[2]+' не найдена. Вам необходимо ее создать.');
						$('#info_message').show();
					break;		
					
					case 'schema_not_found': 
						$('#info_message_text').html('Файл database.php со структурой базы данных не найден.<br />Установите последнюю версию скрипта с официального сайта.');
						$('#info_message').show();					
					break;

					default: 
						$('#info_message_text').html('Неизвестная ошибка. Напишите на support@cpatracker.ru');
						$('#info_message').show();					
					break;					
				}
			}
		});
		

		return false;
	}
</script>