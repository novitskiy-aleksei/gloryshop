<?php if($informations){  ?>
<li class="elem_menu mobile_menu_toggle">
<a><span><?php echo $text;?></span></a>
<ul >
  <?php foreach ($informations as $information) { ?>
   <li><a href="<?php echo $information['href'];?>"><?php echo $information['title'];?></span></a></li>
   <?php } ?>
</ul>
</li><?php } ?>