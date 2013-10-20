var user_group_messages = {
	is_user_group : 'You are about to make a user group that you are part of inactive. This will make you, and all users that are part of this group, inactive and will log you out. You will not be able to log back in until another Administrator makes you active again.',
	deactivate : 'You are about to make a user group inactive. This will make all users that are part of this group inactive as well.'
};

$(document).ready(function(){

	$('.active_state').on('click', function(){
		if($(this).data('state') === 'active'){
			if($(this).data('user_group')){
				if(confirm(user_group_messages.is_user_group)){
					switchUserGroupsStatus($(this).data('id'));
				}
			}
			else if(confirm(user_group_messages.deactivate)){
				switchUserGroupsStatus($(this).data('id'));
			}
		}
		else{
			switchUserGroupsStatus($(this).data('id'));
		}
	});

	$('#active').on('change', function(){
		if(!$(this).is(':checked')){
			$('#user_group-form').on('submit', function(e){
				e.preventDefault();
				var msg = (_CURRENT_USER_GROUP === _USER_GROUP) ? user_group_messages.is_user_group : user_group_messages.deactivate;
				if(confirm(msg)){
					$(this).off().submit();
				}
			});
		}
		else{
			$('#user_group-form').off();
		}
	});

});

function switchUserGroupsStatus(id){
	$.ajax({
		type : 'POST',
		url : _APP_BASEURL + 'ajax',
		dataType : 'json',
		data : {
			_use : 'UsersAJAX@switchUserGroupsStatus',
			group_id : id
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