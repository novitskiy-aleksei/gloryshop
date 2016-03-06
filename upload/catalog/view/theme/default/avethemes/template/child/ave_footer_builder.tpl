<?php if(isset($layouts) ){ ?>
 	<?php foreach ( $layouts as $row) {?>
            <div class="content_row clearfix <?php echo $row->clss?>">
                <?php foreach( $row->cols as $col ) {
                $split_col = isset($col->rows)?'split-col':'';
                 ?>
                    <div class="<?php echo  $split_col;?> col-lg-<?php echo $col->col_lg; ?> col-md-<?php echo $col->col_md;?> col-sm-<?php echo $col->col_sm;?> col-xs-<?php echo $col->col_xs;?>">
                    <div class="child-col clearfix">
                        <?php foreach ( $col->widgets as $widget ){ ?>
                            <?php if( isset($widget->content) ) { ?>
                                    <?php echo $widget->content; ?>
                            <?php } ?>
                        <?php } ?>
                        <?php if (isset($col->rows)&&$col->rows) { ?>
                           <?php foreach ($col->rows as $row) {?>
                                    <div class="child-row clearfix">
                                        <div class="content_row <?php echo $row->clss?>">
                                            <?php foreach( $row->cols as $col ) { ?>
                                                <div class="col-lg-<?php echo $col->col_lg; ?> col-md-<?php echo $col->col_md;?> col-sm-<?php echo $col->col_sm;?> col-xs-<?php echo $col->col_xs;?>">
                                                     <div class="child-col clearfix">
                                                    <?php foreach ( $col->widgets as $widget ){ ?>
                                                        <?php if( isset($widget->content) ) { ?>
                                                                <?php echo $widget->content; ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    </div>
                                                </div><!--//col --> 
                                            <?php } ?>
                                        </div><!--//row --> 
                                    </div><!--//child-row --> 
                            <?php } ?>
                            <!-- $col->rows--> 
                        <?php } ?>
                        </div><!--//bordered --> 
                    </div><!--//col --> 
                <?php } ?>
            </div><!--//row --> 
    <?php } ?>
<?php }	  ?> 
