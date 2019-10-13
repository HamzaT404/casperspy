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
                           <th><div>Duration</div></th>
                           <th> Call Type</th>
                           <th>Status</th>
                         
						</tr>
					</thead>
                    <tbody>

                    	<?php
                             //$inquiry   =   $this->db->get('inquiry')->result_array();

                         $count = 1;foreach($call_log_data as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
                            <td><?php echo $row['name'];?></td>
                            <td><?php echo $row['number'];?></td>
                            <td><?php echo $row['time'];?></td>
							
						
							<td><?php echo $row['call_duration'];?></td>
                            <?php 
                            if($row['call_type'] == 1)
                            {
                            $call_data = '<font color="green">Incomming <i class="fas fa-arrow-left irotate"></i></font>';
                            }
                            else 
                            {
                                 

                            $call_data = '<font color="#3FCCFF">Outgoing <i  class="orotate fas fa-arrow-right"></i></font>';
                            }
                            ?>
							<td><?php echo $call_data; ?></td>
                            
                           
                            <td><?php  if($row['status'] == 1)
                                        {
                                            echo '<font color="green">Connected</font>';
                                        }
                                        else
                                        {
                                            echo '<font color="red">Didn`t Connect</font>';
                                        }
                            ?></td>
                             
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
            <!--TABLE LISTING ENDS-->
        </div>
	</div>
</div>