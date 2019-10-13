 <?php echo form_open(base_url() . 'index.php?admin/test/create/' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
	
					
                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('go');?></button>
						</div>
					</div>
                <?php echo form_close();?>