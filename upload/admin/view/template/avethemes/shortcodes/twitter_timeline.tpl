<input type="hidden" name="display" value="<?php echo $element;?>"/>
       	
          
          <div class="form-group">
            <label class="col-sm-2 control-label">Twitter Widget ID</label>
            <div class="col-sm-10">
               <input type="text" name="sections[twitter_widget_id]"class="form-control" value="<?php echo $sections['twitter_widget_id'];?>">
            </div>
          </div>
           <div class="form-group">
            <label class="col-sm-2 control-label">Twitter Username</label>
            <div class="col-sm-10">
               <input type="text" name="sections[twitter_username]"class="form-control" value="<?php echo $sections['twitter_username'];?>">
            </div>
          </div>
          
           <div class="form-group">
            <label class="col-sm-2 control-label" for="input-locale"><?php echo $text_language; ?></label>
            <div class="col-sm-10">
                           
 <select name="sections[twitter_lang]"class="form-control">
              <?php foreach ($tlangs as $value=>$label) { ?>
    <option value="<?php echo $value;?>"  <?php echo ($value==$sections['twitter_lang'])?'selected="selected"':'';?>><?php echo $label;?> - <?php echo $value;?></option> 
              <?php } ?>
            </select>
            
            </div>
          </div>
             
         <div class="form-group">
            <label class="col-sm-2 control-label" for="input-locale"><?php echo $entry_follow_button; ?></label>
            <div class="col-sm-10">
                           
 <select name="sections[twitter_button]"class="form-control">
    <option value="1"  <?php echo (1==$sections['twitter_button'])?'selected="selected"':'';?>>Yes</option> 
    <option value="0"  <?php echo (0==$sections['twitter_button'])?'selected="selected"':'';?>>No</option> 
            </select>
            
            </div>
          </div>
          
         <div class="form-group">
            <label class="col-sm-2 control-label" for="input-locale"><?php echo $text_shown; ?></label>
            <div class="col-sm-10">
                           
 <select name="sections[twitter_shown]"class="form-control">
    <option value="1"  <?php echo (1==$sections['twitter_shown'])?'selected="selected"':'';?>>1</option> 
    <option value="2"  <?php echo (2==$sections['twitter_shown'])?'selected="selected"':'';?>>2</option> 
    <option value="3"  <?php echo (3==$sections['twitter_shown'])?'selected="selected"':'';?>>3</option> 
    <option value="4"  <?php echo (4==$sections['twitter_shown'])?'selected="selected"':'';?>>4</option> 
            </select>
            
            </div>
          </div>  
          
         <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $text_style; ?></label>
            <div class="col-sm-10">
                           
 <select name="sections[twitter_style]"class="form-control">
    <option value="light"  <?php echo ('light'==$sections['twitter_style'])?'selected="selected"':'';?>><?php echo $text_light;?></option> 
    <option value="dark"  <?php echo ('dark'==$sections['twitter_style'])?'selected="selected"':'';?>><?php echo $text_dark;?></option> 
            </select>
            
            </div>
          </div>    
       
          <div class="alert alert-info">How to create Twitter Widget ID?<br>Step 1: <a onclick="window.open('https://twitter.com/settings/widgets');"><b>Sign in on twitter.com</b></a><br>Step 2: <a onclick="window.open('https://twitter.com/settings/widgets/new');"><b>Click Here</b> to create a new widget</a><br>Step 3: The widget-id is provided by Twitter<br>  =&gt; You will be redirected to <b style="color:#f00;">https://twitter.com/settings/widgets/zzz...</b><br>The <b style="color:#f00;">zzz</b> is your widget-id.</div>