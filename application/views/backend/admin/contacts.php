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
                            <th><div>Mobile</div></th>
                            <th><div>Address</div></th>
                           <th><div>Relationship</div></th>
                           <th> Gender</th>
                           <th>Email</th>
                           <!--  <th>Action</th> -->
						</tr>
					</thead>
                    <tbody>

                    	<?php
                             //$inquiry   =   $this->db->get('inquiry')->result_array();

                         $count = 1;foreach($contacts_data as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
                            <td><?php echo $row['firstname'];?></td>
                            <td><a href="tel:<?php echo $row['mobile'];?>"><?php echo $row['mobile'];?></a></td>
                            <td><?php echo $row['address_home'];?></td>
							
						
							<td><?php echo $row['relationship'];?></td>
							<td><?php echo $row['gender'];?></td>
                            
                           
                            <td><?php echo $row['email'];?></td>
                            <!--  <td><a class="btn btn-info" href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/inquiry/delete/<?php echo $row['inquiry_id'];?>');">
                                            <i class="entypo-eye"></i>
                                                View
                                            </a> <a class="btn btn-primary" href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/inquiry/delete/<?php echo $row['inquiry_id'];?>');">
                                            <i class="entypo-export"></i>
                                                Export
                                            </a></td> -->
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
            <!--TABLE LISTING ENDS-->
            
            
			
            
		</div>
	</div>
</div>