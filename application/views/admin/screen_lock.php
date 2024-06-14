<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo _project_complete_name_ ?> | Lockscreen</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<? echo _lte_files_ ?>plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<? echo _lte_files_ ?>dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition lockscreen">
  <!-- Automatic element centering -->
  <div class="lockscreen-wrapper">
    <div class="lockscreen-logo">
      <img src="<?= base_url() ?>assets/front/images/logo.png" style="height:150px">
    </div>


    <!-- User name -->
    <div class="lockscreen-name"><?= $this->data['session_name'] ?></div>

    <!-- START LOCK SCREEN ITEM -->
    <? if (!empty($alert_message)) { ?>
      <div style="margin-bottom:31px"><?php echo $alert_message; ?></div>
    <? } ?>
    <div class="clearfix"></div>
    <div class="lockscreen-item">
      <!-- lockscreen image -->

      <div class="lockscreen-image">
        <img src="<? echo _lte_files_ ?>dist/img/user1-128x128.jpg" alt="User Image">
      </div>
      <!-- /.lockscreen-image -->

      <!-- lockscreen credentials (contains the form) -->

      <?php echo form_open(MAINSITE_Admin . 'Screen-Lock', array('method' => 'post', 'id' => '', 'style' => '', 'class' => 'lockscreen-credentials')); ?>
      <div class="input-group">
        <?php
        $attributes = array(
          'name' => 'password',
          'id' => 'password',
          'value' => set_value('password'),
          'class' => 'form-control',
          'placeholder' => "Password",
          'type' => 'password',
          'required' => 'required'
        );
        echo form_input($attributes); ?>

        <div class="input-group-append">
          <button type="button" class="btn"><i class="fas fa-arrow-right text-muted"></i></button>
        </div>
      </div>
      <?php echo form_close() ?>
      <!-- /.lockscreen credentials -->

    </div>
    <!-- /.lockscreen-item -->
    <div class="help-block text-center">
      Enter your password to retrieve your session
    </div>
    <div class="text-center">
      <a href="<?= MAINSITE_Admin . 'Screen-Lock/logout' ?>">Or sign in as a different user</a>
    </div>
    <div class="lockscreen-footer text-center">
      Copyright &copy; <?= date('Y') ?> <b><a target="_blank" href="https://www.marswebsolution.com/"
          class="text-black">Mars Web Solutions</a></b><br>
      All rights reserved
    </div>
  </div>
  <!-- /.center -->

  <!-- jQuery -->
  <script src="<? echo _lte_files_ ?>plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<? echo _lte_files_ ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>