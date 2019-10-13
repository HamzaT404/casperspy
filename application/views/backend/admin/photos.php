 <ol class="breadcrumb bc-3" >
                                <li>
                        <a href="<?php echo base_url();?>index.php?admin/dashboard"><i class="entypo-gauge"></i>Dashboard</a>
                    </li>
                       <li>
                        <i class="fas fa-photo-video"></i>
                        <a href="<?php echo base_url().'?admin/album'; ?>">Gallery</a>
                    </li>
                      <li class="active">
        
                                    <strong><?php echo $page_title; ?></strong>
                            </li>
                            </ol>
                

                <script type="text/javascript">
        jQuery(document).ready(function($)
        {
            $(".gallery-env").on("click", ".image-thumb .image-options a.delete", function(ev)
            {
                ev.preventDefault();
                
                
                var $image = $(this).closest('[data-tag]');
                    
                var t = new TimelineLite({
                    onComplete: function()
                    {
                        $image.slideUp(function()
                        {
                            $image.remove();
                        });
                    }
                });
                
                $image.addClass('no-animation');
                
                t.append( TweenMax.to($image, .2, {css: {scale: 0.95}}) );
                t.append( TweenMax.to($image, .5, {css: {autoAlpha: 0, transform: "translateX(100px) scale(.95)"}}) );
                
            }).on("click", ".image-thumb .image-options a.edit", function(ev)
            {
                ev.preventDefault();
                
                // This will open sample modal
                $("#album-image-options").modal('show');
                
                // Sample Crop Instance
                var image_to_crop = $("#album-image-options img"),
                    img_load = new Image();
                
                img_load.src = image_to_crop.attr('src');
                img_load.onload = function()
                {
                    if(image_to_crop.data('loaded'))
                        return false;
                        
                    image_to_crop.data('loaded', true);
                    
                    image_to_crop.Jcrop({
                        //boxWidth: $("#album-image-options").outerWidth(),
                        boxWidth: 580,
                        boxHeight: 385,
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
                        
                        jcrop.animateTo([600, 400, 100, 150]);
                    });
                }
            });
            
            
            // Sample Filtering
            var all_items = $("div[data-tag]"),
                categories_links = $(".image-categories a");
            
            categories_links.click(function(ev)
            {
                ev.preventDefault();
                
                var $this = $(this),
                    filter = $this.data('filter');
                
                categories_links.removeClass('active');
                $this.addClass('active');
                
                all_items.addClass('not-in-filter').filter('[data-tag="' + filter + '"]').removeClass('not-in-filter');
                
                if(filter == 'all' || filter == '*')
                {
                    all_items.removeClass('not-in-filter');
                    return;
                }
            });
            
        });
        </script>
<div class="gallery-env">
        
            <div class="row">
            
                <div class="col-sm-12">
                    
                    <h3>
                        <?php echo $page_title; ?>
                    </h3>
                    
                    <hr />
                    
                    <div class="image-categories">
                        <span>Album details:</span>
                      <span>Number of Photos: <?php echo $no_of_photos; ?></span>
                        
                    </div>
                </div>
            
            </div>
        
            <div class="row">
             
             <?php foreach ($photo_data as $row) { ?>

                <div class="col-sm-2 col-xs-4" data-tag="1d">
                    
                    <article class="image-thumb">
                        
                        <a href="data/gallery/<?php echo $album_folder.'/'.$row['photo_url']; ?>" class="image" target="_blank">
                            <img src="data/gallery/<?php echo $album_folder.'/'.$row['photo_url']; ?>" />
                        </a>
                        
                        <div class="image-options">
                            <a href="data/gallery/<?php echo $album_folder.'/'.$row['photo_url']; ?>"  target="_blank"><i class="entypo-eye"></i></a>
                            <a href="data/gallery/<?php echo $album_folder.'/'.$row['photo_url']; ?>"  target="_blank" download="<?php echo $row['photo_url']; ?>" class="delete"><i class="fas fa-download"></i></a>
                        </div>
                         
                    </article>
                
                </div>
            <?php } ?>
            
                
            </div>
        
        </div>
        
        
        
      
        
        <br />
            
