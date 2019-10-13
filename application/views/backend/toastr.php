<script src="assets/js/toastr.js"></script>
<!-- SHOW TOASTR NOTIFICATION -->
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