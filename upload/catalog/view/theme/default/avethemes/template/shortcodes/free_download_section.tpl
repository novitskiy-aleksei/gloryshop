 <?php foreach ($downloads as $download) { ?>
    <div class="call_to_action boxed_white container">
                <div class="content clearfix">
                    <h3><?php echo $download['name']; ?></h3>
                <span class="intro_text"><?php echo $download['description']; ?></span>
                <a href="<?php echo $download['href'];?>" class="btn_a bg-base f_right">
                    <span><i class="in_left fa fa-download"></i><span><?php echo $text_download;?></span><i class="in_right fa fa-download"></i></span>
                </a>
                </div>
            </div>
    <?php } ?>