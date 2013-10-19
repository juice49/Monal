$(document).ready(function(){

	$('.active_state').on('click', function(){
		if($(this).data('state') === 'active'){
			if(confirm('Making this user inactive will mean that they are no longer able to log in.')){
				switchUsersStatus($(this).data('id'));
			}
		}
		else{
			switchUsersStatus($(this).data('id'));
		}
	});

});

function switchUsersStatus(id){
	$.ajax({
		type : 'POST',
		url : _APP_BASEURL + 'ajax',
		data : {
			_use : 'UsersAJAX@switchUsersStatus',
			user_id : id
		},
		success : function(results){
			if(results == 'success'){
				location.reload();
			}
		}
	});
}