<div class="sidebar-menu">
		<header class="logo-env" >
			
            <!-- logo -->
			<div class="logo" style="">
				<a href="<?php echo base_url();?>">
					<img src="assets/logo/cs_icon.png"  style="max-height:60px;"/>
				</a>
			</div>
            
			<!-- logo collapse icon -->
			<div class="sidebar-collapse" style="">
				<a href="#" class="sidebar-collapse-icon with-animation">
                
					<i class="entypo-menu"></i>
				</a>
			</div>
			
			<!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
			<div class="sidebar-mobile-menu visible-xs">
				<a href="#" class="with-animation">
					<i class="entypo-menu"></i>
				</a>
			</div>
		</header>
		
		<div style="border-top:1px solid rgba(69, 74, 84, 0.7);"></div>	
		<ul id="main-menu" class="">
			<!-- add class "multiple-expanded" to allow multiple submenus to open -->
			<!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
            
           
           <!-- Frontend -->
          

           <!-- DASHBOARD -->
           <li class="<?php if($page_name == 'dashboard')echo 'active';?> ">
				<a href="<?php echo base_url();?>index.php?admin/dashboard">
					<i class="entypo-gauge"></i>
					<span><?php echo get_phrase('Dashboard');?></span>
				</a>
           </li>
           

                 
			




        <li class="<?php if($page_name == 'contacts'){ echo 'active';} else {echo '';} ?> ">
				<a href="<?php echo base_url();?>index.php?admin/contacts">
					<i class="fas fa-user-alt"></i>
					<span>Contacts</span>
			<span class="badge badge-info" style=""><?php echo $this->db->get('contacts')->num_rows(); ?></span>
				</a>
           </li>

           <li class="<?php if($page_name == 'call_log'){ echo 'active';} else {echo '';} ?> ">
				<a href="<?php echo base_url();?>index.php?admin/call_log">
					<i class="fas fa-phone"></i>
					<span>Call Log</span>
			<span class="badge badge-info" style=""><?php echo $this->db->get('call_log')->num_rows(); ?></span>
				</a>
           </li>

           <li class="<?php if($page_name == 'msg'){ echo 'active';} else {echo '';} ?> ">
				<a href="<?php echo base_url();?>index.php?admin/msg">
					<i class="fas fa-sms"></i>
					<span>Message</span>
			<span class="badge badge-info" style=""><?php echo $this->db->get('msg')->num_rows(); ?></span>
				</a>
           </li>

<li class="<?php if($page_name == 'audio'){ echo 'active';} else {echo '';} ?> ">
                <a href="<?php echo base_url();?>index.php?admin/audio">
                   <i class="fas fa-file-audio"></i>
                    <span>Audio</span>
            <span class="badge badge-info" style=""><?php echo $this->db->get('audio')->num_rows(); ?></span>
                </a>
           </li>

           <li class="<?php if($page_name == 'notes'){ echo 'active';} else {echo '';} ?> ">
                <a href="<?php echo base_url();?>index.php?admin/notes">
                   <i class="fas fa-clipboard"></i>
                    <span>Notes</span>
            <span class="badge badge-info" style=""><?php echo $this->db->get('notes')->num_rows(); ?></span>
                </a>
           </li>

            <li class="<?php if($page_name == 'album'){ echo 'active';} else {echo '';} ?> ">
                <a href="<?php echo base_url();?>index.php?admin/album">
                    <i class="fas fa-photo-video"></i>
                    <span>Gallery</span>
            <span class="badge badge-info" style=""><?php echo $this->db->get('album')->num_rows(); ?></span>
                </a>
           </li>

            <li class="<?php if($page_name == 'album'){ echo 'active';} else {echo '';} ?> ">
                <a href="<?php echo base_url();?>index.php?admin/location">
                    <i class="fas fa-location-arrow"></i>
                    <span>Location</span>
            
                </a>
           </li>



            
           <!-- SETTINGS -->
           <li class="<?php if($page_name == 'system_settings' ||
		   								$page_name == 'manage_language' || $page_name == 'sms_gateway')echo 'opened active';?> ">
				<a href="#">
					<i class="entypo-lifebuoy"></i>
					<span><?php echo get_phrase('settings');?></span>
				</a>
                <ul>
					<li class="<?php if($page_name == 'system_settings')echo 'active';?> ">
						<a href="<?php echo base_url();?>index.php?admin/system_settings">
							<span><i class="entypo-dot"></i> <?php echo get_phrase('general_settings');?></span>
						</a>
					</li>
					
					</ul>
           </li>
            
           <!-- ACCOUNT -->
           <li class="<?php if($page_name == 'manage_profile')echo 'active';?> ">
				<a href="<?php echo base_url();?>index.php?admin/manage_profile">
					<i class="entypo-lock"></i>
					<span><?php echo get_phrase('account');?></span>
				</a>
           </li>
        		
</div>