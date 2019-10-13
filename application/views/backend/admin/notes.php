<br>
<div class="row">
	<div class="col-md-12">

       <div class="notes-env">
        
 
            
            <div class="notes-list">
            
                <ul class="list-of-notes">
                
                    <!-- predefined notes -->
                    <?php $count = 1;foreach($note_data as $row):?>
                    <li class="current"> <!-- class "current" will set as current note on Write Pad -->
                        <a href="#">
                            <span><?php echo $row['time'];?></span>
                            <strong><?php echo $row['notes'];?></strong>
                          
                        </a>
                        
                        <button class="note-close" disabled>&times;</button>
                        
                        <div class="content"><?php echo $row['notes'];?></div>
                    </li>
                    <?php endforeach;?>
                    
                    
                    <!-- this will be automatically hidden when there are notes in the list -->
                    <li class="no-notes">
                        There are no notes yet!
                    </li>
                </ul>
                    
                
                
                <div class="write-pad">
                    <textarea class="form-control autogrow" disabled></textarea>
                </div>
                
            </div>
        </div>
    
	
	</div>
</div>