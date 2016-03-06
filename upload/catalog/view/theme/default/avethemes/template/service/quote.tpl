<?php global $ave;
 echo $header; ?>
<section class="section page_title">
    <div class="content clearfix">
        <h1><?php echo $heading_title; ?></h1>
    <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="<?php echo $breadcrumb['href']; ?>"><span itemprop="title"><?php echo str_replace('<i class="fa fa-home"></i>','<i class="fa fa-home"></i><b>Home</b>',$breadcrumb['text']); ?></span></a></li>
        <?php } ?>
    </ul>
    </div>
</section>
<section class="section">
  <div class="content content_spacer clearfix">
<div class="content_row clearfix">
		<?php echo $column_left; ?>
        <div id="content" class="<?php echo $ave->layout('content');?>">
        <?php echo $content_top; ?>
       <div class="heading_title centered upper">
				<h2><span class="line"><i class="fa fa-usd"></i></span><?php echo $heading_title; ?></h2>
		</div>
 <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="quote-form" class="mpadding form-horizontal">
				<div class="content_row margin-bottom-20">
				<div class="col-md-6">
                      <h4 class="upper"><?php echo $text_information; ?></h4>
			 <fieldset>
                      <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo $entry_name; ?> <span class="require">*</span></label>
                        <div class="col-sm-8">
                          <input type="text" name="name" value="<?php echo $name; ?>" class="form-control"/>
                            <?php if ($error_name) { ?>
                            <span class="text-danger"><?php echo $error_name; ?></span>
                            <?php } ?>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo $entry_email; ?> <span class="require">*</span></label>
                        <div class="col-sm-8">
                          <input type="text" name="email" value="<?php echo $email; ?>" class="form-control"/>
                        <?php if ($error_email) { ?>
                        <span class="text-danger"><?php echo $error_email; ?></span>
                        <?php } ?>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo $entry_telephone; ?></label>
                        <div class="col-sm-8">
                        <input type="text" name="telephone" value="<?php echo $telephone; ?>" class="form-control"/>
            <?php if ($error_telephone) { ?>
            <span class="text-danger"><?php echo $error_telephone; ?></span>
            <?php } ?>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo $entry_company; ?></label>
                        <div class="col-sm-8">
                        <input type="text" name="company" value="<?php echo $company; ?>" class="form-control"/>
           
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo $entry_competence; ?></label>
                        <div class="col-sm-8">
                        <input type="text" name="competence" value="<?php echo $competence; ?>" class="form-control"/>
                        </div>
                      </div>
                      <div class="form-group">
                      <label class="col-sm-4 control-label"><?php echo $text_enquiry; ?></label>
                        <div class="col-sm-8">
   <textarea class="form-control" name="message" style="height:180px;" id="message"><?php echo $message; ?></textarea>
    <?php if ($error_message) { ?>
    <span class="text-danger"><?php echo $error_message; ?></span>
    <?php } ?>
                           </div>
                      </div>
                     
                      
                      
     </fieldset>
     </div>
     <div class="col-md-6">
       <h4 class="upper"><?php echo $text_services; ?> <a class="pull-right" onclick="reload_scrollbox('services');" data-toggle="tooltip" title="<?php echo $text_refresh;?>"><i style="font-size:14px;" class="fa fa-refresh"></i></a></h4>       
      <fieldset>               
            <div class="scrollbox box-from" id="services">
                  <?php $class = 'odd grey-cararra-bg'; ?>
                  <?php foreach ($services as $service) { ?>
                  
                   <?php $hide=(in_array($service['service_id'],$service_selection))?' hide':''; ?>
                   <?php $class = ($class == 'even' ? 'odd grey-cararra-bg' : 'even'); ?>
                  <div id="addfrom<?php echo $service['service_id']; ?>" class="<?php echo $class.$hide; ?>"><?php echo $service['name']; ?>
                    <input type="hidden" data-name="service_selection[]" value="<?php echo $service['service_id']; ?>"/>
                    <img src="assets/theme/img/add.png" alt="" class="add" onclick="addObject('services','service_selection','<?php echo $service['service_id']; ?>')"/>
                  </div>
                  <?php } ?>
                </div><!-- scrollbox--> 
                
        <p class="reload clearfix"></p>
            <div class="scrollbox box-to" id="service_selection">
                  <?php $class = 'odd grey-cararra-bg'; ?>
                  <?php if(!empty($selections)){
                  foreach ($selections as $selection) { ?>
                  <?php $class = ($class == 'even green-turquoise-bg' ? 'odd grey-cararra-bg' : 'even green-turquoise-bg'); ?>
                  <div id="addto<?php echo $selection['service_id']; ?>" class="<?php echo $class; ?>"><?php echo $selection['name']; ?>
                  <img src="assets/theme/img/delete.png" class="remove" alt=""/>
                    <input type="hidden" name="service_selection[]" value="<?php echo $selection['service_id']; ?>"/>
                  </div>
                  <?php }
                  } ?>
                </div><!-- scrollbox--> 
                
            
                          
                            <?php if ($error_service_selection) { ?>
                              <span class="text-danger"><?php echo $error_service_selection; ?></span>
                            <?php } ?>     
       </fieldset>
     </div><!--col --> 
     </div><!--row -->        
    <div class="content_row">
    
            <div class="col-md-6">
            
    
                       <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo $entry_budget; ?> </label>
                        <div class="col-sm-8">
           <select class="form-control" name="budget">
								 <?php foreach ($budgets as $budget) { ?> 
                                    <?php if ($budget['value'] == $budget) { ?>
                                        <option value="<?php echo $budget['value']; ?>" selected="selected"><?php echo $budget['label']; ?></option>
                                         <?php } else { ?>                                    
                                        <option value="<?php echo $budget['value']; ?>"><?php echo $budget['label']; ?></option>     
                                        <?php } ?> 
                                    <?php } ?>     
	        				</select>
                            <?php if ($error_budget) { ?>
                           <span class="text-danger"> <?php echo $error_budget; ?></span>
                            <?php } ?>
                          </div>
                      </div><!--form-group --> 
                   
            </div> <!--col -->      
                      
            <div class="col-md-6">
                       <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo $entry_captcha; ?> <span class="require">*</span></label>
                        <div class="col-sm-9 radio-list">
                        <div class="content_row">
             <label class="margin-bottom-10 col-md-5">
            <input type="text" name="captcha" value="<?php echo $captcha; ?>" class="form-control"/></label>
             <label class="margin-bottom-10 col-md-7"><img src="index.php?route=avethemes/common/captcha" alt="captcha" id="captcha"/><a style="border-top-width:1px;" onclick="reload_captcha('captcha');" class="btn with-tooltip tooltip-right" title="Reload Captcha"><i class=" fa fa-refresh"></i></a></label>
            <?php if ($error_captcha) { ?>
            <span class="text-danger"><?php echo $error_captcha; ?></span>
            <?php } ?>
                      </div><!--row --> 
                          </div>
                      </div><!--form-group --> 
                      
            </div> <!--col -->      
      </div>   <!--row --> 
              
              
              
    <div class="buttons">
      <div class="pull-left"><a href="<?php echo $back; ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> <?php echo $button_back; ?></a></div>
      <div class="pull-right">    
        <button type="submit" class="btn btn-primary"><?php echo $text_send; ?> <i class="fa fa-arrow-right"></i></button>
      </div>
    </div>
    
</form>

      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div><!-- //content row--> 
    </div><!-- //content spacer-->
    <script type="text/javascript"><!--//
function reload_captcha(id) {
	var obj =document.getElementById(id);
	var src ='index.php?route=avethemes/common/captcha';
	var date =new Date();
	obj.src =src + '&' + date.getTime();
	return false;
}
function reload_scrollbox(obj) {
	$('#'+obj+'>span').each(function(index, element) {
			var data_html=$(element).html();
			$(element).replaceWith(data_html);	
	});
	$('#'+obj).children('div:even').attr('class','odd');	
	$('#'+obj).children('div:odd').attr('class','even');
}
function addObject(from,to,value) {
	var html = $('#'+from+' #addfrom'+value).html();
	var clone_span = $('<div>').append($('#'+from+' #addfrom'+value).clone()).remove().html();	
	$('#'+from+' #addfrom'+value).replaceWith("<span id=\"spanvalue"+value+"\">" + clone_span + "</span>");	
			$('#'+from).children('div:even').attr('class','odd grey-cararra-bg');	
			$('#'+from).children('div:odd').attr('class','even');
				
	$('#'+to+' div#addto'+value).remove();				
	$('#'+to).append('<div id="addto'+value+'">'+html+'</div>');
		
	var name = $('#addto'+value +' input').attr('data-name');
	$('#addto'+value +' input').attr({'name':name,'data-name':''});
	$('#addto'+value +' img').attr({'src':'assets/theme/img/delete.png','onclick':'','data-value':value,'data-from':from,'title':'Remove'});
	
	$('#'+to+' div:even').attr('class', 'odd grey-cararra-bg');	
	$('#'+to+' div:odd').attr('class', 'even green-turquoise-bg');
	$('#'+to).sortable({cursor: "move"});
	$('#'+to).bind('sortupdate', function(event, ui) {
			$('#'+to).children('div:even').attr('class','odd');	
			$('#'+to).children('div:odd').attr('class','even');															
	});	
}
//--></script> 
</section><!-- //main section-->
<?php echo $footer; ?>