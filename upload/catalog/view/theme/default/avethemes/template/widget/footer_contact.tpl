<div class="<?php echo $class;?>">
<h6 class="heading_title"><i class="<?php echo $contact_icon;?>"></i><?php echo $contact_title;?></h6>
            <div>       
            <ul>
          <?php 
          if(!empty($contact_data)){
          foreach ($contact_data as $contact) { ?>
            <li class="footer-contact-block">
            <i class="<?php echo $contact['icon'];?>"></i>
                <div>
                <em><?php echo (isset($contact['title'][$language_id]))?$contact['title'][$language_id]:''; ?></em>
                <h5><?php echo (isset($contact['content'][$language_id]))?$contact['content'][$language_id]:''; ?></h5>           
                </div>
            </li>            
          <?php }?> 
          <?php }?>
   </ul>
</div>
</div>   