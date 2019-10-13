<br>
<div class="row">
	<div class="col-md-12">
    
        
	
		<div class="tab-content" style="color: black;">
            <!--TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
                <table  class="table table-bordered datatable" id="datatable_export">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                    		<th><div>Name</div></th>
                            <th><div>Number</div></th>
                            <th><div>Time</div></th>
                            <th><div>Message</div>
                           <th> Msg Type</th>
                        
                         
						</tr>
					</thead>
                    <tbody>

                    	<?php
                             //$inquiry   =   $this->db->get('inquiry')->result_array();

                         $count = 1;foreach($msg_data as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
                            <td><?php echo $row['name'];?></td>
                            <td><?php echo $row['number'];?></td>
                            <td><?php echo $row['msg'];?></td>
                            <td><?php echo $row['time'];?></td>
							
						
					
                            <?php 
                            if($row['msg_type'] == 1)
                            {
                            $msg_data = '<font color="green">Incomming <i class="fas fa-arrow-left irotate"></i></font>';
                            }
                            else 
                            {
                                 

                            $msg_data = '<font color="#3FCCFF">Outgoing <i  class="orotate fas fa-arrow-right"></i></font>';
                            }
                            ?>
							<td><?php echo $msg_data; ?></td>
                            
                           
                             
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
            <!--TABLE LISTING ENDS-->
        </div>
	</div>
</div>