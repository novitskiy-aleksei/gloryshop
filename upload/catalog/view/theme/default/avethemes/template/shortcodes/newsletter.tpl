<div class="content_row" id="subscribe_box_<?php echo $module;?>">
    <h3 class="heading_title"><?php echo $heading_title; ?></h3>
        <span class="footer_desc">
<?php echo (isset($sections['description'][$language_id]))?html_entity_decode($sections['description'][$language_id], ENT_QUOTES, 'UTF-8'):'';?>
        </span>
        <div class="newsletter_con">
            <input type="text" name="subscribe_email" class="form-control" placeholder="<?php echo $entry_email; ?>">
            <a class="newsletter_button" onclick="check_subscribe('<?php echo $module;?>','subscribe');">
                <i class="subscribe_true fa fa-check"></i>
                <i class="subscribe_btn fa fa-send-o"></i>
                <i class="refresh_loader fa fa-refresh"></i>
            </a>
        </div>
        <div id="subscribe_message_<?php echo $module;?>" class="margin-top-20"></div>
</div>