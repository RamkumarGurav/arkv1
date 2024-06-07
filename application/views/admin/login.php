<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo _project_complete_name_ ?> | Log in</title>
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/admin/css/login.css">
</head>
<body>

<div class="box-form">
<div class="left">
<div class="overlay">
<h1>Hello World.</h1>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.Curabitur et est sed felis aliquet sollicitudin</p>

</div>
</div>
<div class="right text-center">
<img src="<?=base_url()?>assets/front/images/logo.png" class="img-size">
<p>Sign in to start your session</p>
<?php echo $alert_message; ?>
<?php echo form_open(MAINSITE_Admin.'Login', array('method' => 'post', 'id' => '', 'style' => '', 'class' => '')); ?>
<div class="inputs">
<?php 
								$attributes = array(
								'name'	=> 'username',
								'id'	=> 'username',
								'value'	=> set_value('username'),
								'class' => 'form-control',
								'placeholder' => "Email / User Name",
								'autofocus' => 'autofocus',
								'type' => 'text',
								'required' => 'required'
								);
								echo form_input($attributes);?>	
<br>
<?php 
								$attributes = array(
								'name'	=> 'password',
								'id'	=> 'password',
								'value'	=> set_value('password'),
								'class' => 'form-control',
								'placeholder' => "Password",
								'type' => 'password',
								'required' => 'required'
								);
								echo form_input($attributes);?>	
</div>
<br><br>
<div class="remember-me--forget-password">

<label>
<input type="checkbox" name="item" checked />
<span class="text-checkbox">Remember me</span>
</label>
<a class="forget">forget password?</a>
</div>
<br>
<button type="submit" name="login_btn" value="1" class="btn btn-primary btn-block">Sign In</button>
<?php echo form_close() ?>
</div>
</div>

<script>
	$.ajaxSetup({
		headers: {
		    '<?= $csrf['name'] ?>': '<?= $csrf['hash'] ?>'
		}
	});
</script>
</body>
</html>