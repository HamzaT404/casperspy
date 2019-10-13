<hr />

    <div class="row">
    <?php echo form_open(base_url() . 'index.php?admin/system_settings/do_update' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top', 'enctype' => 'multipart/form-data'));?>

        <div class="col-md-6">
            
            <div class="panel panel-primary" >
            
                <div class="panel-heading">
                    <div class="panel-title">
                        <?php echo get_phrase('system_settings');?>
                    </div>
                </div>
                
                <div class="panel-body">
                    
                 
                 

                  <div class="form-group">
                      <label  class="col-sm-3 control-label">Title</label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="customer_title" 
                              value="<?php echo $this->db->get_where('settings' , array('type' =>'customer_title'))->row()->description;?>">
                      </div>
                  </div>
                    
                  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('address');?></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="address" 
                              value="<?php echo $this->db->get_where('settings' , array('type' =>'address'))->row()->description;?>">
                      </div>
                  </div>
                    
                  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('phone');?></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="phone" 
                              value="<?php echo $this->db->get_where('settings' , array('type' =>'phone'))->row()->description;?>">
                      </div>
                  </div>

                   <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('mobile');?></label>
                      <div class="col-sm-9">
                          <input type="number" maxlength="10" minlength="10" class="form-control" name="mobile" 
                              value="<?php echo $this->db->get_where('settings' , array('type' =>'mobile'))->row()->description;?>">
                      </div>
                  </div>
                 
                    
                  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('customer_email');?></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="customer_email" 
                              value="<?php echo $this->db->get_where('settings' , array('type' =>'customer_email'))->row()->description;?>">
                      </div>
                  </div>
               
                    
                    
                
               
                    <div class="form-group">
                      <label  class="col-sm-3 control-label">SMS</label>
                      <div class="col-sm-9">
                          <select name="sms" class="form-control">
                              <?php $sms = $this->db->get_where('settings' , array('type'=>'sms'))->row()->description;?>
                              <option value="1" <?php if ($sms == 1)echo 'selected';?>> Active</option>
                              <option value="0" <?php if ($sms == 0)echo 'selected';?>> Deactive</option>
                          </select>
                      </div>
                  </div>
                 
                  
                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-info">Save</button>
                    </div>
                  </div>
                    <?php echo form_close();?>
                    
                </div>
            
            </div>
			

        
        </div>

      
    
       
              
              </div>

   
            
        
        </div>

    </div>

<script type="text/javascript">
    $(".gallery-env").on('click', 'a', function () {
        skin = this.id;
        $.ajax({
            url: '<?php echo base_url();?>index.php?admin/system_settings/change_skin/'+ skin,
            success: window.location = '<?php echo base_url();?>index.php?admin/system_settings/'
        });
});
</script>