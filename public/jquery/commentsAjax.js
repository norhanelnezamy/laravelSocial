

$(document).ready(function(){

	//show comments by ajax
	$(document).on('click','input[name=showComment]',function(){
		 var input = $(this);
		 var post_id = $(this).attr("id");
		 $.get('/comments/show/'+ post_id,function(data){

			 $('#comment_error_'+post_id).removeClass("alert alert-danger");
			 $('#comment_error_'+post_id+' p').remove();

				if(Object.keys(data).length != 0){
					$('#div_'+post_id+' ul').remove();
						$.each(data,function(index, value ){
								$('#div_'+post_id).append(data[index]);
						 });
			  }
				else{
					$('#comment_error_'+post_id).addClass("alert alert-danger").append("<p>there is no comment yet</p>");
				}
		 });
	});


	$.ajaxSetup({
	  headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	  }
  });


	//add comment by ajax
	$(document).on('click','input[name=addComment]',function(){

		var comment_val = $('#comment_'+ $(this).attr("id")).val();
		var post_id =  $(this).attr("id");
		$('#comment_error_'+post_id).removeClass("alert alert-danger");
		$('#comment_error_'+post_id+' p').remove();

		$.post('/comment/add',{comment: comment_val , id: post_id}, function(data){
			$('#comment_'+post_id+' p').remove();
			if (data == 1) {
				$('#comment_'+post_id).val("");
				$('.show_'+post_id).click();
			}
			else {
				$('#comment_error_'+post_id).addClass("alert alert-danger").append("<p>"+data+"</p>");
			}
		});
	});

// delete comment by ajax
	$(document).on('click','input[name=deleteComment]',function(){
		 var comment_id = $(this).attr("id");
		 $('#comment_error_'+comment_id).removeClass("alert alert-danger");
		 $('#comment_error_'+comment_id+' p').remove();
		 $.get('/comment/delete/'+ comment_id,function(data){
				if (data == 1) {
					$('#ul_comment_'+comment_id).remove();
				}
				else {
					$('#comment_error_'+comment_id).addClass("alert alert-danger").append("<p>something went wrong</p>");
				}
		 });
	});


	$(document).on('click','input[name=editComment]',function(){
			var comment_id =  $(this).attr("id");
			var edit_comment_value = $('#li_comment_'+comment_id).text();
			$('#edit_comment').val(edit_comment_value);
			$('input[name=edit_comment_model]').attr('id',comment_id);
	});


		$(document).on('click','input[name=edit_comment_model]',function(){
			var comment_val = $('#edit_comment').val();
			var comment_id =  $(this).attr("id");
			$('#model_error').removeClass("alert alert-danger");
			$('#model_error p').remove();

			$.post('/comment/update/'+comment_id,{edit_comment: comment_val , id: comment_id}, function(data){
				$('#comment_'+comment_id+' p').remove();
				if (data == 1) {
					$('#li_comment_'+comment_id).text(comment_val);
					$('#close').click();
				}
				else {
					$('#model_error').addClass("alert alert-danger").append("<p>"+data+"</p>");
				}
			});
		});


});
