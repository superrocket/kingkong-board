jQuery(document).ready(function(){

	kingkongboard_comment_reply_enable();

	jQuery(".button-verify-submit").click(function(){
		var pwd 		= jQuery("#kingkongboard-wrapper").find("[name=kingkongboard-verifying-pwd]").val();
		var view 		= jQuery("#kingkongboard-wrapper").find("[name=view_type]").val();
		var entry_id 	= jQuery("#kingkongboard-wrapper").find("[name=entry_id]").val();
		var board_id 	= jQuery("#kingkongboard-wrapper").find("[name=board_id]").val();
		if(pwd){
			var data = {
				'action' 	: 'kingkongboard_password_verifying',
				'password'	: pwd,
				'view'		: view,
				'entry_id'	: entry_id,
				'board_id'	: board_id
			}

			jQuery.post(ajax_kingkongboard.ajax_url, data, function(response) {
				if(response.status == "success"){
					switch(view){
						case "read" :
							jQuery("#kingkongboard_verify_form").submit();							
						break;

						case "delete" :
							location.href = response.redirect;
						break;
					}
				}
			});			
		} else {
			return false;
		}
	});

	jQuery("#kingkongboard-wrapper").find(".button-entry-delete").click(function(){
		location.href = jQuery(this).attr("data");
	});

	jQuery("#kingkongboard-wrapper").find(".button-comment-save").click(function(){
		var user_status = jQuery("#kingkongboard-wrapper").find("[name=user_status]").val();
		var writer 		= jQuery("#kingkongboard-wrapper").find("[name=kkb_comment_writer]").val();
		var email 		= jQuery("#kingkongboard-wrapper").find("[name=kkb_comment_email]").val();
		var content 	= jQuery("#kingkongboard-wrapper").find("[name=kkb_comment_content]").val();
		var parent 		= 0;

		if(writer == undefined){
			writer = null;
		}
		if(email == undefined){
			email = null;
		}
		var data = {
			'action' 		: 'kingkongboard_entry_comment_validation',
			'writer'		: writer,
			'email'			: email,
			'content' 		: content
		};

		jQuery.post(ajax_kingkongboard.ajax_url, data, function(response) {
			if(response.status == "failed"){
				alert(response.message);
			} else {
				kingkongboard_save_comment(null, parent);
			}
		});
	});

	jQuery("#kingkongboard-wrapper").find(".button-save").click(function(){
		var origin = jQuery(this);
		origin.hide();
		jQuery(".write-save-loading").css("opacity", 1);
		switch(jQuery("#kingkongboard-wrapper").find("[name=editor_style]").val()){
			case "wp_editor" :
				tinyMCE.triggerSave();
			break;

			case "se2" :
				oEditors.getById["entry_content"].exec("UPDATE_CONTENTS_FIELD", []);
			break;
		}

		var title 		= jQuery("#kingkongboard-wrapper").find("[name=entry_title]").val();
		var secret 		= jQuery("#kingkongboard-wrapper").find("[name=entry_secret]").prop("checked");
		var writer 		= jQuery("#kingkongboard-wrapper").find("[name=entry_writer]").val();
		var content 	= jQuery("#kingkongboard-wrapper").find("[name=entry_content]").val();
		var board_id 	= jQuery("#kingkongboard-wrapper").find("[name=board_id]").val();
		var user_status = jQuery("#kingkongboard-wrapper").find("[name=user_status]").val();
		var pwd  		= jQuery("#kingkongboard-wrapper").find("[name=entry_password]").val();
		var entry_id 	= jQuery("#kingkongboard-wrapper").find("[name=entry_id]").val();
		var board_id 	= jQuery("#kingkongboard-wrapper").find("[name=board_id]").val();
		var thumbnail 	= jQuery("#kingkongboard-wrapper").find(".thumbnail-tr").find("input").val();

		if(entry_id == undefined){
			entry_id = null;
		}
		if(pwd == undefined){
			pwd = null;
		}
 
		var data = {
			'action' 		: 'kingkongboard_entry_validation',
			'data'			: jQuery("#writeForm").serialize(),
			'thumbnail'		: thumbnail,
			'entry_id'		: entry_id
		};

		jQuery.post(ajax_kingkongboard.ajax_url, data, function(response) {

			if(response.status == "failed"){
				alert(response.message);
				jQuery(".write-save-loading").css("opacity", 0);
				origin.show();
			} else {
				jQuery(".write-save-loading").css("opacity", 1);
				if(!jQuery("#kingkongboard-wrapper").find("[name=entry_id]").val()){
					kingkongboard_entry_iframe_controller('proc');
				} else {
					var data = {
						'action' 		: 'kingkongboard_entry_password_check',
						'entry_id'		: jQuery("#kingkongboard-wrapper").find("[name=entry_id]").val(),
						'entry_pwd' 	: pwd
					};
						
					jQuery.post(ajax_kingkongboard.ajax_url, data, function(response) {
						if(response.status == "success"){
							kingkongboard_entry_iframe_controller('modify_proc');
						} else {
							alert(response.message);
							jQuery(".write-save-loading").css("opacity", 0);
							origin.show();
						}
					});
				}
			}
		});
	});
 
	jQuery("#kingkongboard-wrapper").find(".attachment-controller").click(function(){
		var title = jQuery(this).parent().parent().find("th").html();
		jQuery("#kingkongboard-wrapper").find(".attachment-tr").after("<tr><th>"+title+"</th><td><input type='file' name='entry_file[]'></td></tr>");
	});

	jQuery("#kingkongboard-wrapper").find(".entry_attach_remove").click(function(){
		jQuery(this).parent().css("background", "yellow");
		jQuery(this).parent().animate({ opacity : 0 }, {duration:500, complete:function(){
			jQuery(this).remove();
		}})
	});

});

function kingkongboard_save_comment(origin, parent){
	var user_status = jQuery("#kingkongboard-wrapper").find("[name=user_status]").val();
	var writer 		= jQuery("#kingkongboard-wrapper").find("[name=kkb_comment_writer]").val();
	var email 		= jQuery("#kingkongboard-wrapper").find("[name=kkb_comment_email]").val();
	var content 	= jQuery("#kingkongboard-wrapper").find("[name=kkb_comment_content]").val();
	var entry_id 	= jQuery("#kingkongboard-wrapper").find("[name=entry_id]").val();
	var data = {
		'action' 		 : 'kingkongboard_comment_save',
		'writer'		 : writer,
		'email' 		 : email,
		'content'		 : content,
		'entry_id'		 : entry_id,
		'comment_parent' : parent,
		'comment_origin' : origin
	}

	jQuery.post(ajax_kingkongboard.ajax_url, data, function(response) {
		kingkongboard_comment_list(entry_id);
		var originCount = jQuery("#kingkongboard-wrapper").find(".total-comments-count").html();
		var originCount = (originCount*1) + 1;
		jQuery("#kingkongboard-wrapper").find(".total-comments-count").html(originCount);
		jQuery("#kingkongboard-wrapper").find("[name=kkb_comment_content]").val("");
	});

}

function kingkongboard_entry_iframe_controller(type){

	var page_uri 	= jQuery("#kingkongboard-wrapper").find("[name=page_uri]").val();

	if(!jQuery("#kingkongboard-wrapper").find("#_procFrame").html()){
		jQuery("#kingkongboard-wrapper").append('<iframe name="_procFrame" id="_procFrame" width="0" height="0" style="" scrolling="no" frameborder="0" marginheight="0" marginheight="0" marginwidth="0"></iframe>');
	}
	writeForm.target = "_procFrame";
	writeForm.action = page_uri;
	writeForm.submit();	
}

function kingkongboard_comment_list(entry_id){

	var data = {
		'action' 	: 'kingkongboard_comment_list',
		'entry_id'	: entry_id,
	}

	jQuery.post(ajax_kingkongboard.ajax_url, data, function(response) {
		jQuery("#kingkongboard-wrapper").find(".comments-list").html(response);
		kingkongboard_comment_reply_enable();
	});	
}


function kingkongboard_comment_reply_enable(){
	var user_status = jQuery("#kingkongboard-wrapper").find("[name=user_status]").val();
	var plugins_url = jQuery("#kingkongboard-wrapper").find(".plugins_url").val();
	var default_input;
	var guest_input;
	if(user_status == 0){
		var writer_text = jQuery(".comments-add-ul").find(".comments-add-writer").html();
		var email_text 	= jQuery(".comments-add-ul").find(".comments-add-email").html();
		guest_input = '<ul class="comments-reply-ul">';
		guest_input += '<li>'+writer_text+'</li>';
		guest_input += '<li><input class="kkb-comment-input kkb-comment-writer" type="text" name="kkb_comment_writer"></li>';
		guest_input += '<li>'+email_text+'</li>';
		guest_input += '<li><input class="kkb-comment-input kkb-comment-email" type="text" name="kkb_comment_email"></li>';
		guest_input += '</ul>';
	} else {
		guest_input = '';
	}

		default_input = '<img src="'+plugins_url+'/assets/images/icon-comment-reply.png" class="kkb_comment_reply_icon">'+guest_input;
	  	default_input += '<ul class="kkb-comment-input-ul">';
	  	default_input += '<li class="kkb-comment-content-li"><table class="kkb-comment-content-table"><tr><td class="kkb-comment-content-td"><textarea class="kkb-comment-input kkb-comment-content" height="30px" name="kkb_comment_content"></textarea></td><td class="kkb-comment-button-td"><input type="image" src="'+plugins_url+'/assets/images/button-ok.png" class="button-comment-reply" style="border:0;margin-left:6px"></td></tr></table></li>';
	  	default_input += '</ul>';

	jQuery("#kingkongboard-wrapper").find(".comment-reply-button").click(function(){
		var parent_id = jQuery(this).attr("data");
		var origin_id = jQuery(this).attr("data-origin");
		jQuery(".each-comment-reply").remove();
		jQuery(this).parent().parent().parent().parent().parent().parent().after('<div class="each-comment-reply">'+default_input+'<input type="hidden" name="comment_parent" value="'+parent_id+'"><input type="hidden" name="comment_origin" value="'+origin_id+'"></div>');
		kingkongboard_comment_reply_save();
	});	
}

function kingkongboard_comment_reply_save(){
	jQuery("#kingkongboard-wrapper").find(".button-comment-reply").click(function(){
		var user_status = jQuery("#kingkongboard-wrapper").find("[name=user_status]").val();
		var writer 		= jQuery(".each-comment-reply").find("[name=kkb_comment_writer]").val();
		var email 		= jQuery(".each-comment-reply").find("[name=kkb_comment_email]").val();
		var content 	= jQuery(".each-comment-reply").find("[name=kkb_comment_content]").val();
		var parent 		= jQuery(".each-comment-reply").find("[name=comment_parent]").val();
		var origin 		= jQuery(".each-comment-reply").find("[name=comment_origin]").val();
		if(writer == undefined){
			writer = null;
		}
		if(email == undefined){
			email = null;
		}
		var data = {
			'action' 		: 'kingkongboard_entry_comment_validation',
			'writer'		: writer,
			'email'			: email,
			'content' 		: content
		};

		jQuery.post(ajax_kingkongboard.ajax_url, data, function(response) {
			if(response.status == "failed"){
				alert(response.message);
			} else {
				kingkongboard_save_comment(origin, parent);
			}
		});
	});	
}

