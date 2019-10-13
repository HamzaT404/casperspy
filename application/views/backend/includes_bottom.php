
	<link rel="stylesheet" href="assets/js/selectboxit/jquery.selectBoxIt.css">
	<link rel="stylesheet" href="assets/js/daterangepicker/daterangepicker-bs3.css">
	<link rel="stylesheet" href="assets/js/icheck/skins/minimal/_all.css">
	<link rel="stylesheet" href="assets/js/icheck/skins/square/_all.css">
	<link rel="stylesheet" href="assets/js/icheck/skins/flat/_all.css">
	<link rel="stylesheet" href="assets/js/icheck/skins/futurico/futurico.css">
	<link rel="stylesheet" href="assets/js/icheck/skins/polaris/polaris.css">	

	<!--Note --> 
	<script src="assets/js/neon-notes.js"></script>
	<script src="assets/js/neon-chat.js"></script>

	<!--gallery -->
	

	

    

	<link rel="stylesheet" href="assets/js/datatables/responsive/css/datatables.responsive.css">
	<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
	<link rel="stylesheet" href="assets/js/select2/select2.css">
	<script src="assets/js/datatables/datatables.js"></script>
	<link rel="stylesheet" href="assets/js/selectboxit/jquery.selectBoxIt.css">

   	<!-- Bottom Scripts -->


	<script src="assets/custom/bs/js/bootstrap-select.min.js"></script>

	<script src="assets/js/gsap/main-gsap.js"></script>
	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>
	<script src="assets/js/toastr.js"></script>
    <script src="assets/js/jquery.validate.min.js"></script>
	<script src="assets/js/fullcalendar/fullcalendar.min.js"></script>
    <script src="assets/js/bootstrap-datepicker.js"></script>
    <script src="assets/js/fileinput.js"></script>
    
    <script src="assets/js/jquery.dataTables.min.js"></script>
	<script src="assets/js/datatables/TableTools.min.js"></script>
	<script src="assets/js/dataTables.bootstrap.js"></script>
	<script src="assets/js/datatables/jquery.dataTables.columnFilter.js"></script>
	<script src="assets/js/datatables/lodash.min.js"></script>
	<script src="assets/js/datatables/responsive/js/datatables.responsive.js"></script>
    <script src="assets/js/selectboxit/jquery.selectBoxIt.min.js"></script>
	<script src="assets/js/typeahead.min.js"></script>
	<script src="assets/js/select2/select2.min.js"></script>
	<script src="assets/js/bootstrap-tagsinput.min.js"></script>
	<script src="assets/js/typeahead.min.js"></script>
	<script src="assets/js/bootstrap-datepicker.js"></script>
	<script src="assets/js/bootstrap-timepicker.min.js"></script>
	<script src="assets/js/bootstrap-colorpicker.min.js"></script>
	<script src="assets/js/daterangepicker/moment.min.js"></script>
	<script src="assets/js/daterangepicker/daterangepicker.js"></script>
	<script src="assets/js/jquery.multi-select.js"></script>
	<script src="assets/js/icheck/icheck.min.js"></script>
	<script src="assets/js/jquery.nicescroll.min.js"></script>
	<script src="assets/js/jquery.knob.js"></script>

    
	<script src="assets/js/neon-calendar.js"></script>
	<script src="assets/js/neon-chat.js"></script>
	<script src="assets/js/neon-custom.js"></script>
	<script src="assets/js/neon-demo.js"></script>

<link rel="stylesheet" href="assets/js/icheck/skins/minimal/_all.css">
	<link rel="stylesheet" href="assets/js/icheck/skins/square/_all.css">
	<link rel="stylesheet" href="assets/js/icheck/skins/flat/_all.css">
	<link rel="stylesheet" href="assets/js/icheck/skins/futurico/futurico.css">
	<link rel="stylesheet" href="assets/js/icheck/skins/polaris/polaris.css">
	<link rel="stylesheet" href="assets/js/icheck/skins/line/_all.css">


<!-- SHOW TOASTR NOTIFIVATION -->
<?php if ($this->session->flashdata('flash_message') != ""):?>

<script type="text/javascript">
	toastr.success('<?php echo $this->session->flashdata("flash_message");?>');
</script>

<?php endif;?>

<?php if ($this->session->flashdata('warning_message') != ""):?>

<script type="text/javascript">
	toastr.warning('<?php echo $this->session->flashdata("warning_message");?>');
</script>

<?php endif;?>

<?php if ($this->session->flashdata('info_message') != ""):?>

<script type="text/javascript">
	toastr.info('<?php echo $this->session->flashdata("info_message");?>');
</script>

<?php endif;?>

<?php if ($this->session->flashdata('error_message') != ""):?>

<script type="text/javascript">
	toastr.error('<?php echo $this->session->flashdata("error_message");?>');
</script>

<?php endif;?>

<?php if ($this->session->flashdata('black_message') != ""):?>

<script type="text/javascript">
	toastr.black('<?php echo $this->session->flashdata("flash_message");?>');
</script>

<?php endif;?>


<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">





	jQuery( document ).ready( function($) {
			var $table4 = jQuery("#datatable_export");
			
			$table4.DataTable( {
				dom: 'Bfrtip',
				buttons: [
					'copyHtml5',
					'excelHtml5',
					'csvHtml5',
					'pdfHtml5'
				]
			} );
		} );

	
		
</script>


<script type="text/javascript">
jQuery(document).ready(function($)
{
	// Skins
	$('input.icheck-1').iCheck({
		checkboxClass: 'icheckbox_minimal',
		radioClass: 'iradio_minimal'
	});
	
	$('input.icheck-2').iCheck({
		checkboxClass: 'icheckbox_minimal-red',
		radioClass: 'iradio_minimal-red'
	});
	
	$('input.icheck-3').iCheck({
		checkboxClass: 'icheckbox_minimal-green',
		radioClass: 'iradio_minimal-green'
	});
	
	$('input.icheck-4').iCheck({
		checkboxClass: 'icheckbox_minimal-blue',
		radioClass: 'iradio_minimal-blue'
	});
	
	$('input.icheck-5').iCheck({
		checkboxClass: 'icheckbox_minimal-aero',
		radioClass: 'iradio_minimal-aero'
	});
	
	$('input.icheck-6').iCheck({
		checkboxClass: 'icheckbox_minimal-grey',
		radioClass: 'iradio_minimal-grey'
	});
	
	$('input.icheck-7').iCheck({
		checkboxClass: 'icheckbox_minimal-orange',
		radioClass: 'iradio_minimal-orange'
	});
	
	$('input.icheck-8').iCheck({
		checkboxClass: 'icheckbox_minimal-yellow',
		radioClass: 'iradio_minimal-yellow'
	});
	
	$('input.icheck-9').iCheck({
		checkboxClass: 'icheckbox_minimal-pink',
		radioClass: 'iradio_minimal-pink'
	});
	
	$('input.icheck-10').iCheck({
		checkboxClass: 'icheckbox_minimal-purple',
		radioClass: 'iradio_minimal-purple'
	});
	
	// Styles
	$('input.icheck-11').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-yellow'
	});
	
	$('input.icheck-12').iCheck({
		checkboxClass: 'icheckbox_flat-pink',
		radioClass: 'iradio_flat-grey'
	});
	
	$('input.icheck-13').iCheck({
		checkboxClass: 'icheckbox_futurico',
		radioClass: 'iradio_futurico'
	});
	
	$('input.icheck-14').iCheck({
		checkboxClass: 'icheckbox_polaris',
		radioClass: 'iradio_polaris'
	});
	
	$('input.icheck-15').each(function(i, el)
	{
		var self = $(el),
			label = self.next(),
			label_text = label.text();
		
		label.remove();
		
		self.iCheck({
			checkboxClass: 'icheckbox_line-green',
			radioClass: 'iradio_line-red',
			insert: '<div class="icheck_line-icon"></div>' + label_text
		});
	});
});
</script>