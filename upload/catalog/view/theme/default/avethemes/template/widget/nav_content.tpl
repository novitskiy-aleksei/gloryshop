<?php if ($categories) { 
?>

    <?php foreach ($categories as $category) {
        if ($category['type']=='content') {?>
        <li class="elem_mega_menu mobile_menu_toggle <?php echo $category['class'];?>">
        <a><span ><?php echo $category['name']; ?></span></a> 
            <ul class="mega_menu <?php echo $category['content_size'];?>">
             <li class="mega-menu-content">
              <div class="mpadding">
                  <?php echo $category['description'];?>
              </div>
              </li>
            </ul>
        </li>
        
       <?php }else{ 
       //begin type='category' or  type='link'
        if ($category['level_1']) {
        $category_count=count($category['level_1']);
        $column=($category['column']<4)?$category['column']:4;
        ?>
        
    <li class="<?php echo ($category['display']=='mega'&&$column>1)?'elem_mega_menu':'elem_menu';?> mobile_menu_toggle <?php echo $category['class'];?>"><a href="<?php echo $category['href']; ?>" <?php echo ($category['type']=='link')?'target="'.$category['target'].'"':'';?>><span><?php echo $category['name']; ?></span></a>
        <?php }else{?>
    <li class="elem_menu mobile_menu_toggle <?php echo $category['class'];?>"><a href="<?php echo $category['href']; ?>" <?php echo ($category['type']=='link')?'target="'.$category['target'].'"':'';?>><span ><?php echo $category['name']; ?></span></a>
        <?php } ?>
      <?php if ($category['level_1']) { 
        if($category['display']=='mega'&&$column>1){
      ?> 
      <ul class="mega_menu col-<?php echo $column;?>">
        <?php foreach (array_chunk($category['level_1'], ceil(count($category['level_1'])/$column)) as $level_1) { ?>
                <li>
          <?php foreach ($level_1 as $level_1_data) { ?>         
           <ul class="mega_menu_in clearfix">
					<li> 
          	<a href="<?php echo $level_1_data['href']; ?>" <?php echo ($level_1_data['type']=='link')?'target="'.$level_1_data['target'].'"':'';?>> <?php echo $level_1_data['name']; ?> <?php echo $level_1_data['count']; ?></a>
           <?php if (isset($level_1_data['level_2'])&&count($level_1_data['level_2'])>0) { ?>
           <ul class="clearfix">
              <?php foreach ($level_1_data['level_2'] as $level_2_data) { ?>
              <li>
       <a href="<?php echo $level_2_data['href']; ?>" <?php echo ($level_2_data['type']=='link')?'target="'.$level_2_data['target'].'"':'';?>> <?php echo $level_2_data['name']; ?><?php echo $level_2_data['count']; ?></a>
              </li>
              <?php } ?>    
              </ul> <!--//end level --> 
          <?php } ?>
                  </li>
              </ul>   
          <?php } ?>
        </li>
          <?php } ?>
      </ul><!--end mega--> 
    <?php }else{ ?>
    <!-- vertical-->
     <ul>
      <?php foreach ($category['level_1'] as $level_1) {?>
     	<?php if($level_1['level_2']){  ?>
            <li class="elem_menu">
                <a href="<?php echo $level_1['href']; ?>" <?php echo ($level_1['type']=='link')?'target="'.$level_1['target'].'"':'';?>><span><?php echo $level_1['name']; ?> <?php echo $level_1['count']; ?></span></a> 
                    <?php if ($level_1['level_2']) { ?> 
                          <ul >
                          <?php foreach ($level_1['level_2'] as $level_2) {?> 
                          	<?php if($level_2['level_3']){  ?>
                                <li class="elem_menu">
                                    <a href="<?php echo $level_2['href']; ?>" <?php echo ($level_2['type']=='link')?'target="'.$level_2['target'].'"':'';?>> <?php echo $level_2['name']; ?> <?php echo $level_2['count']; ?></a> 
                                        <?php if ($level_2['level_3']) { ?> 
                                              <ul >
                                              <?php foreach ($level_2['level_3'] as $level_3) {?> 
                                                <li><a href="<?php echo $level_3['href']; ?>" <?php echo ($level_3['type']=='link')?'target="'.$level_3['target'].'"':'';?>><?php echo $level_3['name']; ?> <?php echo $level_3['count']; ?></a></li>
                                                <?php } ?>
                                              </ul>
                                        <?php } ?>
                              </li>
                          
                              <?php }else{?>
                                <li><a href="<?php echo $level_2['href']; ?>" <?php echo ($level_2['type']=='link')?'target="'.$level_2['target'].'"':'';?>><?php echo $level_2['name']; ?><?php echo $level_2['count']; ?></a></li>
                              <?php } ?>
                            <?php } ?>
                          </ul>
                    <?php } ?>
          </li>
      
          <?php }else{?>
            <li><a href="<?php echo $level_1['href']; ?>" <?php echo ($level_1['type']=='link')?'target="'.$level_1['target'].'"':'';?>><?php echo $level_1['name']; ?><?php echo $level_1['count']; ?></a></li>
          <?php } ?>
      <?php } ?>
      </ul>
      <!-- end vertical-->
    <?php } ?>
    <?php } ?>
    </li>
    <?php } //end type='category' or  type='link'
    ?>
    <?php } ?>
<?php } ?>