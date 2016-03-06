function check_subscribe(index,type) {
		$.ajax({
			url: 'index.php?route=avethemes/newsletter/'+type,
			type: 'post',
			dataType: 'json',
			data: 'subscribe_email=' + encodeURIComponent($('#subscribe_box_'+index+' input[name=\'subscribe_email\']').val())+'&subscribe_name='+ encodeURIComponent($('#subscribe_box_'+index+' input[name=\'subscribe_name\']').val()),
			beforeSend: function() {
				$('#subscribe_box_'+index+' .e_subscribe').attr('disabled', true);
				$('#subscribe_message').html('<div class="alert alert-attention"><img src="assets/global/img/input-spinner.gif"/></div>');
			},
			complete: function() {
				$('#subscribe_box_'+index+' .e_subscribe').attr('disabled', false);
			},
			success: function(data) {
				if (data['error']) {
					$('#subscribe_message_'+index).html('<div class="alert alert-warning"><i class="fa fa-warning red"></i><span> ' + data['error'] + '</span><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}
				if (data['success']) {
					$('#subscribe_message_'+index).html('<div class="alert alert-success\"><i class="fa fa-check green"></i><span> ' + data['success'] + '</span><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					$('input[name=subscribe_name]').attr('value', '');
					$('input[name=subscribe_email]').attr('value', '');
				}
			}
		});
}