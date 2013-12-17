<? if (!$include_flag){exit();} ?>
<script>
  $(document).ready(function() 
  {
    $('input[name="email"]').focus(); 
  });

  function check_form()
  {
    $('#email').css('background-color', 'white');
    $('#password').css('background-color', 'white');

    if (($('#email').val()!='') && ($('#password').val()!=''))
    {
      return true;
    }

    if ($('#password').val()=='')
    {
      $('#password').css('background-color', 'lightyellow');
      $('#password').focus();
    }

    if ($('#email').val()=='')
    {
      $('#email').css('background-color', 'lightyellow');
      $('#email').focus();
    }

    return false;
  }
</script>
<form class="form-horizontal" action='index.php' method="POST" id="register_admin" onSubmit="return check_form();">
  <input type=hidden name='page' value='register'>
  <input type=hidden name='act' value='register_admin'>
  <fieldset>
    <div id="legend">
      <legend class="">Заполните данные администратора</legend>
    </div>
    <div class="control-group">
      <label class="control-label" for="email">E-mail</label>
      <div class="controls">
        <input type="text" id="email" name="email" class="input-xlarge">
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="password">Пароль для входа</label>
      <div class="controls">
        <input type="password" id="password" name="password" class="input-xlarge">
      </div>
    </div>

    <div class="control-group">
      <!-- Button -->
      <div class="controls">
        <button class="btn btn-success">Сохранить</button>
      </div>
    </div>
  </fieldset>
</form>