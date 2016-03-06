<?php
 if($ave->getConfig('ave_cms_sitemap_status')==1){ ?>
    <div class="col-sm-4 col-xs-12">    
    <h3><?php echo $ave->text('text_content');?> </h3>
    <?php if($categories) { ?>
    <ul class="list-unstyled">
     <?php foreach ($categories as $category) { ?>
                <li><a href="<?php echo $category['href']; ?>"><i class="fa fa-angle-right"></i> <?php echo $category['name']; ?></a>
                <?php if ($category['level_1']) { ?>
                <ul class="list-unstyled">                  
                  <?php foreach ($category['level_1'] as $level_1) {?>
            <li>
                <a href="<?php echo $level_1['href']; ?>"> <i class="fa fa-angle-right"></i> <?php echo $level_1['name']; ?></a> 
                    <?php if ($level_1['level_2']) { ?> 
                          <ul class="list-unstyled">
                          <?php foreach ($level_1['level_2'] as $level_2) {?> 
                                <li>
                                    <a href="<?php echo $level_2['href']; ?>"><i class="fa fa-angle-right"></i> <?php echo $level_2['name']; ?></a> 
                                        <?php if ($level_2['level_3']) { ?>                                         
                                              <ul class="list-unstyled">
                                              <?php foreach ($level_2['level_3'] as $level_3) {?>                                               
                                                <li><a href="<?php echo $level_3['href']; ?>"><i class="fa fa-angle-right"></i> <?php echo $level_3['name']; ?></a></li>
                                                <?php } ?>
                                              </ul>
                                        <?php } ?>
                              </li>
                          
                            <?php } ?>
                          </ul>
                    <?php } ?>
          </li>
      <?php } ?>
                </ul>
                <?php } ?>
              </li>
      <?php } ?>
    </ul>
 <?php } ?>
    </div>
    
<?php } ?>