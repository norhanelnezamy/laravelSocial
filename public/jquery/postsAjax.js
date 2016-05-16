
$(document).ready(function(){

	$.ajaxSetup({
	  headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	  }
  });


	//edit post by ajax
	$('input[name=edit_post_model]').click(function(){

		var post_id =  $(this).attr("id");
		var edit_post_value = $('#edit_post_'+ post_id).val();

		$('#model_error_'+post_id).removeClass("alert alert-danger");
		$('#model_error_'+post_id+' p').remove();
		$.post('/post/update/'+post_id,{edit_post: edit_post_value , id: post_id}, function(data){
			if (data == 1) {
				$('#post_body_'+post_id).text(edit_post_value);
				$('#close_'+post_id).click();
			}
			else {
				$('#model_error_'+post_id).addClass("alert alert-danger").append("<p>"+data+"</p>");
			}
		});
	});

	// delete post by ajax
	$('input[name=delete_post]').click(function(){
		 var post_id = $(this).attr("id");
		 $('#comment_error_'+post_id).removeClass("alert alert-danger");
		 $('#comment_error_'+post_id+' p').remove();
		 $.get('/post/delete/'+ post_id,function(data){
				if (data == 1) {
					$('#post_id_'+post_id).remove();
				}
				else {
					$('#comment_error_'+post_id).addClass("alert alert-danger").append("<p>something went wrong</p>");
				}
		 });
	});

});
