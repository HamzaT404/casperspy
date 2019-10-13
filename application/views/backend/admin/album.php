<link rel="stylesheet" href="assets/js/jcrop/jquery.Jcrop.min.css">

<hr />
        
                    <ol class="breadcrumb bc-3" >
                                <li>
                        <a href="<?php echo base_url();?>index.php?admin/dashboard"><i class="entypo-gauge"></i>Home</a>
                    </li>
                      <li class="active">
                                <i class="fas fa-photo-video"></i>
                                    <strong>Gallery</strong>
                            </li>
                            </ol>
<script type="text/javascript">
        jQuery(document).ready(function($)
        {
            // Handle the Change Cover
            $(".gallery-env").on("click", ".album header .album-options", function(ev)
            {
                ev.preventDefault();
                
                // Sample Modal
                $("#album-cover-options").modal('show');
                
                // Sample Crop Instance
                var image_to_crop = $("#album-cover-options .croppable-image img"),
                    img_load = new Image();
                
                img_load.src = image_to_crop.attr('src');
                img_load.onload = function()
                {
                    if(image_to_crop.data('loaded'))
                        return false;
                        
                    image_to_crop.data('loaded', true);
                    
                    image_to_crop.Jcrop({
                        boxWidth: 410,
                        boxHeight: 265,
                        onSelect: function(cords)
                        {
                            // you can use these vars to save cropping of the image coordinates
                            var h = cords.h,
                                w = cords.w,
                                
                                x1 = cords.x,
                                x2 = cords.x2,
                                
                                y1 = cords.w,
                                y2 = cords.y2;
                            
                        }
                    }, function()
                    {
                        var jcrop = this;
                        
                        jcrop.animateTo([800, 600, 150, 50]);
                    });
                }
            });
        });
        </script>
<div class="gallery-env">

        
            <div class="row">
         <?php foreach ($album_data as $row){ 
             
        ?>
                <div class="col-sm-4">
                    
                    <article class="album">
                        
                        <header>
                            
                            <a href="<?php echo base_url();?>index.php?admin/photos/<?php echo $row['album_id']; ?>">
                                <img style="max-height: 300px;" src="data/gallery/<?php echo $row['album_folder'].'/'.$row['album_cover']; ?>" />
                            </a>
                            
                            
                        </header>
                        
                        <section class="album-info">
                            <h3><a href="<?php echo base_url();?>index.php?admin/photos/<?php echo $row['album_id']; ?>"><?php echo $row['album_name']; ?></a></h3>
                            
                
                        </section>
                        
                        <footer>
                            
                            <div class="album-images-count">
                                <i class="entypo-picture"></i>
                              <?php echo $this->db->get_where('photos',array('album_id' => $row['album_id']))->num_rows(); ?> Photos
                            </div>
                            
            
                            
                        </footer>
                        
                    </article>
                    
                </div>
            <?php } ?>
                
              
              
            
            </div>
            
        </div>




        <script src="assets/js/jcrop/jquery.Jcrop.min.js"></script>
        <script src="assets/js/neon-chat.js"></script>
    