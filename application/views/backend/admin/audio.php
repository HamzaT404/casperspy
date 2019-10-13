<br>
<div class="row">
	<div class="col-md-12">
    
        
	
		<div class="tab-content" style="color: black;">
            <!--TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
                <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered datatable" id="datatable_export">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                    		<th><div>Name</div></th>
                            <th><div>Time</div></th>
                            <th><div>Play</div></th>
                            <th>Action</th>
						</tr>
					</thead>
                    <tbody>

                    	<?php
                             //$inquiry   =   $this->db->get('inquiry')->result_array();

                         $count = 1;foreach($audio_data as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
                            <td><?php echo $row['audio_name'];?></td>
                            
							
						
							<td><?php echo $row['time'];?></td>
						
                            <th><audio controls>
                                  <source src="<?php echo base_url().'data/audio/'.$row['file_name']; ?>" type="audio/ogg">
                                    <source src="<?php echo base_url().'data/audio/'.$row['file_name']; ?>" type="audio/mpeg">

                                   Your browser does not support the audio element.
                               </audio>
                           </th>
                           
                           
                             <td> <a class="btn btn-primary"  href="<?php echo base_url().'data/audio/'.$row['file_name']; ?>" download="<?php echo $row['file_name'];?>">
                                            <i class="entypo-export"></i>
                                                Download
                                            </a></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
            <!--TABLE LISTING ENDS-->
            
            
			
            
		</div>
	</div>
</div>