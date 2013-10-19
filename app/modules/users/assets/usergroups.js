$(document).ready(function(){

	$('.active_state').on('click', function(){
		if(confirm('Making a group inactive will make all users associated with this group inactive as well.')){
			$.ajax({
				type : 'POST',
				url : _APP_BASEURL + 'ajax',
				data : {
					_use : 'UsersAJAX@switchUserGroupsStatus',
					group_id : $(this).data('id')
				},
				success : function(results){
					if(results == 'success'){
						location.reload();
					}
				}
			});
		}
	});

});