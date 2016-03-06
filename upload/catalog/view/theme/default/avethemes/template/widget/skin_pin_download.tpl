<?php if($downloads){  ?>
<li class="elem_menu mobile_menu_toggle">
<a><span><?php echo $text;?></span></a>
<ul >
  <?php foreach ($downloads as $download) { ?>
   <li><a href="<?php echo $download['href'];?>"><?php echo $download['name'];?></span></a></li>
   <?php } ?>
</ul>
</li><?php } ?>