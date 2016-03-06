<?php global $ave;?>

<?php echo (isset($pre_footer))?$pre_footer:''; ?>    
     
    <footer id="footer"> 
<div class="container split-col content_spacer clearfix">
<?php
 echo $footer_custom;
 ?>

        <?php foreach ($footer_sort as $sort_key) {
        $footer_status[] = $footer_links[$sort_key]['status'];
        }
       if((int)max($footer_status)>0){
        ?>
<div class="content_row clearfix">
	<div class="clearfix">
        <?php foreach ($footer_sort as $sort_key) {?>
        
               <?php if(!empty($footer_links[$sort_key])&&$footer_links[$sort_key]['status']==1&&$footer_links[$sort_key]['display']){ ?> 
               <div class="col-md-<?php echo $col;?> col-sm-<?php echo $col;?> col-xs-12">
               <div class="content_row">
      		<h6 class="heading_title"><i class="<?php echo $footer_links[$sort_key]['icon'];?>"></i><?php echo $footer_links[$sort_key]['text'];?></h6>
                <ul class="list-unstyled"> 
               <?php foreach ($footer_links[$sort_key]['links'] as $link) { ?>
               <?php if($footer_links[$sort_key]['display']&&in_array($link['id'],$footer_links[$sort_key]['display'])){ ?>          
          <li><a href="<?php echo $link['href']; ?>"><i class="fa fa-angle-right"></i> <?php echo $link['title']; ?></a></li>
                 <?php } ?>
                <?php } ?>   
              </ul>
          </div>
        </div>
         <?php } ?>
         <?php } ?>
         </div>
  </div>  
         <?php } ?><!-- end row --> 
</div><!-- end container--> 

<div class="footer_copyright">
<div class="content clearfix">
<div class="content_row clearfix">
<?php $powered_position = $ave->get('powered_position');
$payment_position = ($powered_position!='pull-left')?'pull-left':'pull-right text-right';

$payment_icons_status=$ave->getConfig('skin_payment_icons_status');
$payment_icons=$ave->getConfig('skin_payment_icons_data');

 ?>
         <?php if($payment_icons_status&&!empty($payment_icons)){?> 
<div class="col-md-6 col-sm-6 col-xs-12 <?php echo $payment_position;?>">
<ul class="list-unstyled list-inline payment-icon">
           <?php foreach ($payment_icons as $payment) { ?>
          <?php if(!empty($payment['image'])){ ?>
              <li><img data-toggle="tooltip" src="<?php echo $payment['image']; ?>" alt="<?php echo (isset($payment['title'][$language_id]))?$payment['title'][$language_id]:''; ?>" title="<?php echo (isset($payment['title'][$language_id]))?$payment['title'][$language_id]:''; ?>" style="max-width:40px; max-height:40px;"/>  </li>        
          <?php } ?>
          <?php } ?>
          </ul>
</div>
<?php } ?>

<div class="col-md-6 col-sm-6 col-xs-12 <?php echo $powered_position;?>">
<span class="footer_copy_text"><?php echo (!empty($skin_powered_desc))?$skin_powered_desc:$powered; ?></span>
</div>
  </div><!-- end row -->   
</div><!-- end container--> 
</div><!-- end footer_copyright--> 
</footer><!--//footer -->
	<a id="scroll_to_top" class="back_to_top <?php echo ($ave->get('back_to_top')==1)?'nhide':'hide';?>"></a>
</div>
<!-- End wrapper -->

<?php echo $ave_editor;?> 