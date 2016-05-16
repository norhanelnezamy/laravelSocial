
$(document).ready(function(){

	//show comments by ajax
	$('input[name=showComment]').click(function(){
		 var post_id = $(this).attr("id");
		 $.get('/comments/show/'+ post_id,function(data){
			 $('#comment_error_'+post_id).removeClass("alert alert-danger");
			 $('#comment_error_'+post_id+' p').remove();

				if (0 < data.length) {
					$('#div_'+post_id+' ul').remove();
					$.each(data,function(index, value ){
					 		$('#div_'+post_id).append("<ul class='nav nav-pills' ><li role='presentation'><img src='"+data[index]['profile_pic']+"'style='width:35px;height:35px;'></li>"
															 +"<li role='presentation'><a href='/profile/"+data[index]['user_id']+"'>"+data[index]['name']+"</a></li>"
															 +"<li role='presentation'style='margin-top:10px;'>"+data[index]['created_at']+"</li>"
															 +"<li role='presentation'style='margin-top:10px;'>"+data[index]['comment']+"</li></ul>");
					 });
				}
				else {
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
	$('input[name=addComment]').click(function(){

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


});
