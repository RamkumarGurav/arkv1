<!-- jQuery -->

<!-- Bootstrap 4 -->
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
