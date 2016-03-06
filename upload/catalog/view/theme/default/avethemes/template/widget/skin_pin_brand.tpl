<?php if($manufacturers){  ?>
  <?php 
  $item_limit=$ave->get('skin_pin_brand_limit');
  ?>
  <li class="elem_image_menu mobile_menu_toggle">
    <a href="<?php echo $brand_href;?>"><span><?php echo $text;?></span></a>
    <ul class="image_menu">
        <li class="image_menu_slide">
             <?php foreach ($manufacturers as $manufacturer) { ?>
            <div class="img_menu_i">
                <a href="<?php echo $manufacturer['href'];?>">
                    <img class="img-responsive" src="<?php echo $manufacturer['thumb'];?>" alt="<?php echo $manufacturer['name'];?>" >
                    <span><?php echo $manufacturer['name'];?></span>
                </a>
            </div>
    		<?php } ?> 
            
        </li>
    </ul>
</li>

<?php } ?> 