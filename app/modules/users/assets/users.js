var user_messages = {
	is_user : 'You are about to make yourself inactive. This will log you out and you will not be able to log back in until another Administrator makes you active again.',
	deactivate : 'Making this user inactive will mean that they are no longer able to log in.',
	change_role : 'You are about to change your user role. Depending on the privileges that this role has you may be logged out and no longer able to log back in until another Administrator makes you active again. You may also loose privileges that you currently have.',
	group_inactive : 'The user group this user is part of is inactive. Changing the user\'s status will have no effect until the user group is also made active.'
}

$(document).ready(function(){

	$('.active_state').on('click', function(){
		if($(this).data('state') === 'active'){
			if($(this).data('user')){
				if(confirm(user_messages.is_user)){
					switchUsersStatus($(this).data('id'));
				}
			}
			else if(confirm(user_messages.deactivate)){
				switchUsersStatus($(this).data('id'));
			}
		}
		else{
			switchUsersStatus($(this).data('id'));
		}
	});

	$('#active').on('change', function(){
		if(_USER_GROUP_ACTIVE){
			if($('.well').data('user') && !$(this).is(':checked')){
				$('#user-form').on('submit', function(e){
					e.preventDefault();
					if(confirm(user_messages.is_user)){
						$(this).off().submit();
					}
				});
			}
			else{
				$('#user-form').off();
			}
		}
		else{
			alert(user_messages.group_inactive);
		}
	});

	$('#user_group').on('change', function(){
		if($('.well').data('user') && $('#user_group').val() !== _USER_GROUP){
			if(!confirm(user_messages.change_role)){
				$('#user_group').val(_USER_GROUP);
			}
		}
	});

	$('.user-details').on('click', function(){
		var _this = $(this);
		$('.config_panel-nolist').hide();
		if($('#row-' + _this.data('row')).data('active')){
			$('#row-' + _this.data('row')).data('active', false).removeClass('active');
		}
		else{
			$('#' + _this.data('user_details')).show();
			$('.table_list li').data('active', false).removeClass('active');
			$('#row-' + _this.data('row')).data('active', true).addClass('active');
		}
	});

	$('.config_panel-nolist').hide();

});

function switchUsersStatus(id){
	$.ajax({
		type : 'POST',
		url : _APP_BASEURL + 'ajax',
		dataType : 'json',
		data : {
			_use : 'UsersAJAX@switchUsersStatus',
			user_id : id
		},
		success : function(results){
			if(results.status === 'error'){
				alert(results.message);
			}
			else{
				location.reload();
			}
		}
	});
}