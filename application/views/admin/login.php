<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title><?php echo _project_complete_name_ ?> | Log in</title>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/admin/css/login.css">
	<!-- Font Awesome -->
<link rel="stylesheet" href="<?=_lte_files_?>plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?=_lte_files_?>dist/css/custome.css">
	<link rel="stylesheet" href="<?=_lte_files_?>css/jquery-ui-12.min.css">
    <script src="<?=_lte_files_?>plugins/jquery/jquery.min.js"></script>
  <!-- Select2 -->
   <link rel="stylesheet" href="<?=_lte_files_?>plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?=_lte_files_?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?=_lte_files_?>plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=_lte_files_?>dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <?php /*?><link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"><?php */?>
  <style type="text/css">
  	#example1 thead th { position: sticky; top: 56px; background-color:#fff;}
  </style>
</head>

<body style="padding:50px;">

	<div class="box-form " 
	>
		<div class="left" >
			<div class="overlay">
				<h1>Hello World.</h1>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.Curabitur et est sed felis aliquet sollicitudin</p>

			</div>
		</div>
		<div class="right text-center"  style="min-width:400px;">
			<p>Sign in to start your session</p>
			<?php echo $alert_message; ?>
			<?php echo form_open(MAINSITE_Admin . 'Login', array('method' => 'post', 'id' => '', 'style' => '', 'class' => '')); ?>
			<div class="inputs">
				<?php
				$attributes = array(
					'name' => 'username',
					'id' => 'username',
					'value' => set_value('username'),
					'class' => 'form-control',
					'placeholder' => "Email / User Name",
					'autofocus' => 'autofocus',
					'type' => 'text',
					'required' => 'required'
				);
				echo form_input($attributes); ?>
				<br>
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
	<script src="<?=_lte_files_?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?=_lte_files_?>plugins/moment/moment.min.js"></script>
<!-- DataTables -->
<script src="<?=_lte_files_?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=_lte_files_?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=_lte_files_?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=_lte_files_?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?=_lte_files_?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="<?=_lte_files_?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?=_lte_files_?>plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?=_lte_files_?>plugins/pace-progress/pace.min.js"></script>
<script src="<?=_lte_files_?>plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="<?=_lte_files_?>plugins/select2/js/select2.full.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?=_lte_files_?>plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?=_lte_files_?>plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=_lte_files_?>dist/js/adminlte.min.js"></script>
<script src="<?=_lte_files_?>plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=_lte_files_?>dist/js/demo.js"></script>
<script src="<?=_lte_files_?>js/alert.js"></script>

<script src="<?=_lte_files_?>js/common.js"></script>
<div id="base_url_function" style="display:none"><?=MAINSITE_Admin?></div>
<script src="<?=_lte_files_?>js/function.js"></script>
<script src="<?=_lte_files_?>js/jquery-ui-12.min.js"></script>
<!-- page script -->
<script>
	$("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
  });
  $(function () {
   <?php /*?> $("#example1").DataTable({
      "paging": true,
	  "lengthChange": true,
      "searching": true,
      "ordering": true,
	  //"scrollX": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
	})<?php */?>

var table = $('#example1').DataTable({
		 aLengthMenu: [
			[25, 50, 100, 200, -1],
			[25, 50, 100, 200, "All"]
		],
		iDisplayLength: 100
	});
	if ( $("*").is("#example1") ) {
	new $.fn.dataTable.FixedHeader( table, {
    "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
	  //"scrollX": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
	  fixedHeader:true,



} );
	}
     /*$('#example2').DataTable({
       "paging": true,
       "lengthChange": false,
       "searching": false,
       "ordering": true,
       "info": true,
       "autoWidth": false,
       "responsive": true,
     });*/

		bsCustomFileInput.init();
		$('.summernote').summernote({<?=_summernote_?>});//for text editor
  });

</script>
</body>

</html>