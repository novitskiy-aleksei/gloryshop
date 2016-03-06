<div class="content_row">
    <?php if($heading_title){?><h3 class="heading_title"><?php echo $heading_title; ?></h3><?php } ?>
    <div class="sidebar">
<ul class="list-group">
            <?php foreach ($informations as $information) { ?>
                <li class="list-group-item">
                    <a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a>
                </li>
            <?php } ?>
            <li class="list-group-item">
                <a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a>
            </li>
    
            <li class="list-group-item">
                <a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a>
            </li>
        </ul>
    </div>
</div>