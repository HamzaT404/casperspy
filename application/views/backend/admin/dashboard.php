<div class="row">

    <div class="col-md-12">
    <div class="alert alert-info">
   
  <strong>Hi! <?php echo $this->session->userdata('name'); ?>,</strong>  Welcome to Casper Spy Admin Panel.
</div>

     
</div></div>

<div class="row">

    <div class="col-md-12">
        

            

<div class="col-md-3">
            <a href="<?php echo base_url()?>index.php?admin/contacts">
                <div class="tile-stats tile-primary">
                    <div class="icon"><i class="entypo-users"></i></div>
                    <div class="num" data-start="0" data-end="<?php echo  $this->db->count_all('contacts');?>" 
                            data-postfix="" data-duration="500" data-delay="0"><?php echo $this->db->count_all('contacts');?></div>
                        
                    <h3>Contacts</h3>
                   <p><?php echo get_phrase('click_here_to_view');?></p>

                </div>
                </a>
 </div>

 <div class="col-md-3">
            <a href="<?php echo base_url()?>index.php?admin/call_log">
                <div class="tile-stats tile-green">
                    <div class="icon"><i class="entypo-phone"></i></div>
                    <div class="num" data-start="0" data-end="<?echo $this->db->count_all('call_log');;?>" 
                            data-postfix="" data-duration="500" data-delay="0"><?php echo $this->db->count_all('call_log');?></div>
                        
                    <h3>Call Log</h3>
                   <p><?php echo get_phrase('click_here_to_view');?></p>

                </div>
                </a>
 </div>


 <div class="col-md-3">
            <a href="<?php echo base_url()?>index.php?admin/audio">
                <div class="tile-stats tile-red">
                    <div class="icon"><i class="entypo-mic"></i></div>
                    <div class="num" data-start="0" data-end="<?phpecho $this->db->count_all('audio');?>" 
                            data-postfix="" data-duration="500" data-delay="0"><?php echo $this->db->count_all('audio');?></div>
                        
                    <h3>Audio</h3>
                   <p><?php echo get_phrase('click_here_to_view');?></p>

                </div>
                </a>
 </div>

               <div class="col-md-3">
            <a href="<?php echo base_url()?>index.php?admin/notes">
                <div class="tile-stats tile-orange">
                    <div class="icon"><i class="entypo-doc-text"></i></div>
                    <div class="num" data-start="0" data-end="<?php echo  $this->db->count_all('notes');?>" 
                            data-postfix="" data-duration="500" data-delay="0"><?php echo $this->db->count_all('notes');?></div>
                        
                    <h3>Notes</h3>
                   <p><?php echo get_phrase('click_here_to_view');?></p>

                </div>
                </a>
 </div>
      <div class="col-md-3">
            <a href="<?php echo base_url()?>index.php?admin/album">
                <div class="tile-stats tile-purple">
                    <div class="icon"><i class="entypo-picture"></i></div>
                    <div class="num" data-start="0" data-end="<?php echo  $this->db->count_all('album');?>" 
                            data-postfix="" data-duration="500" data-delay="0"><?php echo $this->db->count_all('notes');?></div>
                        
                    <h3>Album</h3>
                   <p><?php echo get_phrase('click_here_to_view');?></p>

                </div>
                </a>
 </div>

  <div class="col-md-3">
            <a href="<?php echo base_url()?>index.php?admin/msg">
                <div class="tile-stats tile-plum">
                    <div class="icon"><i class="entypo-mail"></i></div>
                    <div class="num" data-start="0" data-end="<?php echo  $this->db->count_all('msg');?>" 
                            data-postfix="" data-duration="500" data-delay="0"><?php echo $this->db->count_all('notes');?></div>
                        
                    <h3>Message</h3>
                   <p><?php echo get_phrase('click_here_to_view');?></p>

                </div>
                </a>
 </div>

  <div class="col-md-3">
            <a href="<?php echo base_url()?>index.php?admin/location">
                <div class="tile-stats tile-cyan">
                    <div class="icon"><i class="entypo-location"></i></div>

                     <div class="num" data-start="" data-end="" 
                            data-postfix="" data-duration="500" data-delay="0"><i class="fas fa-location-arrow"></i></div>
                    
                        
                    <h3>Location</h3>
                   <p><?php echo get_phrase('click_here_to_view');?></p>

                </div>
                </a>
 </div>

            </div>

            </div>

 

            

