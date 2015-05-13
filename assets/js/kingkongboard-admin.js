jQuery(document).ready(function(){

	jQuery(".comment-list-background-color").wpColorPicker();
	jQuery(".comment-list-writer-color").wpColorPicker();
	jQuery(".comment-list-date-color").wpColorPicker();
	jQuery(".comment-list-content-color").wpColorPicker();
	jQuery(".comment-list-background-border-color").wpColorPicker();

	jQuery("#entry_date").datepicker({
		dateFormat : 'yy-mm-dd'
	});
 
	kkb_each_manager_remove();
	kkb_latest_shortcode_remove();

	jQuery(".srshop-button-detail").click(function(){
		jQuery(".srshop-modal-wrapper").find(".srshop-modal-loading").hide();
		jQuery(".srshop-detail-wrapper").find(".detail-thumbnail").html('');
		jQuery(".srshop-detail-wrapper").find(".detail-info").find(".detail-info-title").html('');
		jQuery(".srshop-detail-wrapper").find(".detail-info").find(".detail-info-description").html('');
		jQuery(".srshop-detail-wrapper").find(".detail-info").find(".detail-info-version").html('');
		jQuery(".srshop-detail-wrapper").find(".detail-info").find(".detail-info-button").html('');
		jQuery(".srshop-detail-wrapper").find(".detail-content").html('');

		jQuery(".srshop-modal-wrapper").find(".srshop-modal-background").css("opacity", 0);
		jQuery(".srshop-modal-wrapper").find(".srshop-modal-content").hide();

		var product_id 				= jQuery(this).attr("data-id");
		var body_width 				= jQuery("body").width() * 1;
		var body_height 			= jQuery("body").height() * 1;
		var wpcontent_width 		= jQuery("#wpcontent").width() * 1;
		var wpcontent_position_left = jQuery("#wpcontent").offset().left * 1;
		var modal_width 			= jQuery(".srshop-modal-wrapper").find(".srshop-modal-content").outerWidth() * 1;
		var cal_left 				= (body_width - modal_width)/2;
		jQuery(".srshop-modal-wrapper").show();
		jQuery(".srshop-modal-wrapper").find(".srshop-modal-background").animate({"opacity" : 0.8}, {duration:300, complete:function(){
			jQuery(".srshop-modal-wrapper").find(".srshop-modal-content").css("left", cal_left+"px");
			jQuery(".srshop-modal-wrapper").find(".srshop-modal-loading").css("left", (cal_left+(modal_width/2))+"px");
			jQuery(".srshop-modal-wrapper").find(".srshop-modal-loading").show();
				var data = {
					'action' 	 : 'srshop_product_detail',
					'product_id' : product_id
				}
				jQuery.post(ajaxurl, data, function(response) {
					jQuery(".srshop-modal-wrapper").find(".srshop-modal-loading").hide();
					jQuery(".srshop-detail-wrapper").find(".detail-thumbnail").html('<img src='+response.thumbnail_url+' style="width:300px; height:auto; border:1px solid #e0e0e0">');
					jQuery(".srshop-detail-wrapper").find(".detail-info").find(".detail-info-title").html(response.title);
					jQuery(".srshop-detail-wrapper").find(".detail-info").find(".detail-info-description").html(response.description);
					jQuery(".srshop-detail-wrapper").find(".detail-info").find(".detail-info-version").html(response.ptype+'/'+response.pversion+'/'+response.psupport);
					jQuery(".srshop-detail-wrapper").find(".detail-info").find(".detail-info-price").html(response.price+'<span style="color:#424242; font-weight:normal">원</span>');
					jQuery(".srshop-detail-wrapper").find(".detail-info").find(".detail-info-button").html('<a href="'+response.link+'" target="_blank" class="button button-primary">구매하러가기</a>');
					jQuery(".srshop-detail-wrapper").find(".detail-content").html(response.pcontent);
					jQuery(".srshop-modal-wrapper").find(".srshop-modal-content").show();
				});
				jQuery(".srshop-modal-background").not(".srshop-modal-content").click(function(){
					jQuery(".srshop-modal-wrapper").hide();
				});
		}});
	});

	jQuery(".kkb-button-section").click(function(){
		var plugins_url = jQuery(".kingkongboard_plugins_url").val();
		var sections = jQuery(this).parent().find(".kkb-input-section").val();
		var section = sections.split(",");
		for (var i = 0; i < section.length; i++) {
			var trim_value = jQuery.trim(section[i]);
				trim_value = trim_value.replace(/ /g, '');
			jQuery(this).parent().find(".kkb-read-role-box").append("<div class='each-manager-div'>"+trim_value+"<div class='each-manager-remove'><img src='"+plugins_url+"/assets/images/icon-close.png' style='width:12px; height:auto'></div><input type='hidden' name='board_section[]' value='"+trim_value+"'></div>");
		};
		kkb_each_manager_remove();		
	});

	jQuery(".select-all-entry").click(function(){
		if(jQuery(this).prop("checked") == true){
			jQuery(".each_entry_checkbox").prop("checked", true);
			remove_check_sum_entry_id();
		} else {
			jQuery(".each_entry_checkbox").prop("checked", false);
			jQuery(".remove_entry_id").val('');
		}
	});

	jQuery(".each_entry_checkbox").click(function(){
		remove_check_sum_entry_id();	
	})

	jQuery(".proc-entry-all-remove").click(function(){
		var filter = jQuery(this).parent().find(".entry_filter_select").val();

		switch(filter){
			case "remove-all" :
				var remove_ids = jQuery(".remove_entry_id").val();
				if(remove_ids){
					var data = {
						'action' 	: 'remove_kingkong_board_all_entry',
						'entry_id'	: remove_ids,
						'board_id'  : jQuery(".board_id").val()
					}

					jQuery.post(ajaxurl, data, function(response) {
						location.reload();
					});
				} else {
					kkb_notice_input('cancel', '삭제할 게시글을 선택하셔야 합니다.');
				}
			break;
		}
	});

	jQuery(".button-add-latest-shortcode").click(function(){
		var shortcode_title 	= jQuery("[name=kkb_shortcode_title]").val();
		var shortcode_skin 		= jQuery("[name=kkb_shortcode_skin]").val();
		var shortcode_number 	= jQuery("[name=kkb_shortcode_list_number]").val();
		var shortcode_length	= jQuery("[name=kkb_shortcode_length]").val();
		var board_id 			= jQuery("[name=board_id]").val();
		var plugins_url 		= jQuery(".kingkongboard_plugins_url").val();

		jQuery("[name=kkb_shortcode_title]").css("border", "none");
		jQuery("[name=kkb_shortcode_skin]").css("border", "none");
		jQuery("[name=kkb_shortcode_list_number]").css("border", "none");

		if(!board_id){
			kkb_notice_input('cancel', '최신글 리스트는 게시판을 생성 후 이용하실 수 있습니다.');
		} else if(!shortcode_title){
			kkb_notice_input('cancel', '숏코드 타이틀은 반드시 지정되어야 합니다.');
			jQuery("[name=kkb_shortcode_title]").css("border", "1px dashed red");
		} else if(!shortcode_skin){
			kkb_notice_input('cancel', '스킨은 반드시 지정 되어야 합니다.');
			jQuery("[name=kkb_shortcode_skin").css("border", "1px dashed red");
		} else if(!shortcode_number){
			kkb_notice_input('cancel', '표시게시물 수는 반드시 지정되어야 합니다.');
			jQuery("[name=kkb_shortcode_list_number]").css("border", "1px dashed red");
		} else {
			jQuery(".shortcode-result").append('<div class="each-shortcode-list"><ul><li>'+shortcode_title+'</li><li>[kingkong_board_latest title="'+shortcode_title+'" skin="'+shortcode_skin+'" number="'+shortcode_number+'" length="'+shortcode_length+'" board_id="'+board_id+'"]</li></ul><input type="hidden" name="added_latest_shortcode_title[]" value="'+shortcode_title+'"><input type="hidden" name="added_latest_skin[]" value="'+shortcode_skin+'"><input type="hidden" name="added_latest_list_number[]" value="'+shortcode_number+'"><input type="hidden" name="added_latest_length[]" value="'+shortcode_length+'"><input type="hidden" name="added_latest_board_id[]" value="'+board_id+'"><div class="each-shortcode-list-remove"><img src="'+plugins_url+'/assets/images/icon-close.png" style="width:15px; height:auto"></div></div>');
			kkb_notice_toolbox_auto_close();
			jQuery("[name=kkb_shortcode_title]").css("border", "none");
			jQuery("[name=kkb_shortcode_skin]").css("border", "none");
			jQuery("[name=kkb_shortcode_list_number]").css("border", "none");
			jQuery("[name=kkb_shortcode_title]").val('');
			jQuery("[name=kkb_shortcode_list_number]").val('');
			jQuery("[name=kkb_shortcode_length]").val('');
			kkb_latest_shortcode_remove();
		}
	});	
	
	jQuery(".button-add-manager").click(function(){
		var user_ids = jQuery(this).parent().find(".manager-input").val();
		var plugins_url = jQuery(".kingkongboard_plugins_url").val();
		if(user_ids){
			var user_id = user_ids.split(",");
			for (var i = 0; i < user_id.length; i++) {
				var trim_value = jQuery.trim(user_id[i]);
					trim_value = trim_value.replace(/ /g, '');
				jQuery(this).parent().find(".kkb-read-role-box").append("<div class='each-manager-div'>"+trim_value+"<div class='each-manager-remove'><img src='"+plugins_url+"/assets/images/icon-close.png' style='width:12px; height:auto'></div><input type='hidden' name='board_manager[]' value='"+trim_value+"'></div>");
			};

			kkb_each_manager_remove();
		}
	});

	jQuery(".each-skin-li").click(function(){
		var skin_slug = jQuery(this).attr("data");
		jQuery(".each-skin-li").removeClass("selected");
		jQuery("[name=board_skin_slug]").val(skin_slug);
		jQuery(this).addClass("selected");
	});

	jQuery("[name=kkb_board_slug]").keyup(function(){
		var repSlug = jQuery(this).val();
			repSlug = repSlug.replace(" ", "_");
			repSlug = repSlug.replace(" ", "");
		jQuery("[name=kkb_board_shortcode]").val("[kingkong_board "+repSlug+"]");
	});

	jQuery("[name=kkb_board_slug]").change(function(){
		var repSlug = jQuery(this).val();
			repSlug = repSlug.replace(" ", "_");
			repSlug = repSlug.replace(" ", "");
			jQuery(this).val(repSlug);		
	});

	jQuery("[name=kkb_board_shortcode]").click(function(){
		jQuery(this).select();
	});

	jQuery(".button-entry-file-upload").click(function(){
		var duplicated = 0;
		wp.media.editor.send.attachment = function(props, attachment){
			jQuery(".entry-attachment-div").each(function(){
				if(jQuery(this).attr("data") == attachment.id){
					duplicated++;
				}
			});

			if(duplicated > 0){
				kkb_notice_input('cancel', '해당 파일은 이미 등록되어 있습니다.');
			} else {
				jQuery(".entry-file-list").append('<div class="entry-attachment-div" data="'+attachment.id+'">'+attachment.filename+'<input type="hidden" name="entry_attachment[]" value="'+attachment.id+'"><div class="entry-attachment-remove"></div></div>');
				kingkongboard_entry_remove_button_enable();
			}
		}
		wp.media.editor.open(this);
		return false;
	});

	jQuery(".button-remove-each-entry").click(function(){
		var origin = jQuery(this);
		if(confirm("삭제하시겠습니까?") == true){
			var data = {
				'action' 	: 'remove_kingkong_board_each_entry',
				'entry_id'	: jQuery(this).attr("data"),
				'board_id'  : jQuery(".board_id").val()
			}

			jQuery.post(ajaxurl, data, function(response) {
				if(response.status == 'success'){
					origin.parent().parent().css("background", "yellow");
					origin.parent().parent().animate({opacity : 0}, {duration:600, complete : function(){
						jQuery(this).remove();
						kkb_notice_input(response.status, response.message);
					}});
				} else {
					kkb_notice_input(response.status, response.message);
				}
			});
		}
	});

	jQuery(".button-board-remove").click(function(){
		var origin = jQuery(this);
		if(confirm("게시판의 모든 글 포함 영구적으로 삭제 됩니다.\n삭제하시겠습니까?") == true){

			var data = {
				'action' 	: 'remove_kingkong_board',
				'board_id'	: jQuery(this).attr("data")
			}
			jQuery.post(ajaxurl, data, function(response) {
				if(response.status == 'success'){
					origin.parent().parent().css("background", "yellow");
					origin.parent().parent().animate({opacity : 0}, {duration:600, complete : function(){
						jQuery(this).remove();
						kkb_notice_input(response.status, response.message);
					}});
				} else {
					kkb_notice_input(response.status, response.message);
				}
			});
			
		}
	});

	jQuery(".button-kkb-create-board").click(function(){
		tinyMCE.triggerSave();
		var BoardName 		= jQuery("[name=kkb_board_name]").val();
		var BoardSlug 		= jQuery("[name=kkb_board_slug]").val();
		var BoardShortcode 	= jQuery("[name=kkb_board_shortcode]").val();
		var BoardRows 		= jQuery("[name=kkb_board_rows]").val();

		if(!BoardName || !BoardSlug){
			kkb_notice_input('cancel', '게시판 명과 슬러그는 반드시 입력하셔야 합니다.');		
		} else if(!BoardRows){
			kkb_notice_input('cancel', '한 페이지에 보여지는 게시물 수 를 기입하셔야 합니다. (게시물 표시에서 입력합니다.)');
		}else {

			var data = {
				'action' 	: 'create_kingkong_board',
				'data'		: jQuery("#kkb-create-board-form").serialize()
			};

			jQuery.post(ajaxurl, data, function(response) {
				//alert(response);
				if(response){
					switch(response.status){
						case 'success' :
							kkb_notice_input('success', response.message);
							jQuery("[name=kkb_type]").val("modify");
							if(!jQuery("[name=board_id]").val()){
								jQuery("[name=board_id]").val(response.board_id);
							}
							jQuery(".button-kkb-create-board").html("수정 완료");
							jQuery("[name=kkb_board_slug]").prop("disabled", true);
							jQuery("[name=kkb_board_shortcode]").prop("disabled", true);
						break;

						case 'error' :
							kkb_notice_input('cancel', response.message);
						break;

						default :
							kkb_notice_input('cancel', '생성에 문제가 발생하였습니다. 기술지원에 문의하시기 바랍니다.');
						break;
					}
				} else {
					kkb_notice_input('cancel', '생성에 문제가 발생하였습니다. 기술지원에 문의하시기 바랍니다.');
				}
			});				

		}

		kkb_notice_toolbox_close();

	});

	if(jQuery(".settings-panel-right").html()){

		jQuery(".settings-panel-right").find(".settings-title").each(function(i){
			var thisContent_Height = jQuery(this).parent().find(".settings-table-wrapper").outerHeight();
			jQuery(this).find(".thisHeight").val(thisContent_Height);
			if(i == 0){
				jQuery(this).parent().find(".inside").show();
				jQuery(this).find(".postbox-onoff").html("▼");
			} else {
				jQuery(this).parent().find(".inside").hide();
				jQuery(this).parent().find(".inside").css("height", 0);
			}
		});

		jQuery(".settings-panel-right").find(".settings-title").click(function(){
			var thisContent_Height = jQuery(this).find(".thisHeight").val();
			if(jQuery(this).parent().find(".inside").css("display") == "none"){
				jQuery(".settings-panel-right").find(".settings-title").not(this).parent().find(".inside").hide();
				jQuery(".settings-panel-right").find(".settings-title").find(".postbox-onoff").html("◀");
				jQuery(this).find(".postbox-onoff").html("▼");
				jQuery(this).parent().find(".inside").css("height", 0);
				jQuery(this).parent().find(".inside").show();
				jQuery(this).parent().find(".inside").animate({height: thisContent_Height},{duration:200, complete:function(){
					jQuery(this).css("overflow", "visible");
					jQuery(this).css("height", "auto");
					//jQuery(document).scrollTop(jQuery(this).parent().position().top);
					jQuery("html, body").animate({scrollTop: jQuery(this).parent().position().top}, 300);
				}});
			} else {
				jQuery(".settings-panel-right").find(".settings-title").find(".postbox-onoff").html("◀");
				jQuery(this).parent().find(".inside").animate({height: 0},{duration:200, complete:function(){
					jQuery(".settings-panel-right").find(".inside").hide();
				}});
				
			}
		});
	}

	jQuery(".button-kkb").hover(function(){
		if(jQuery(this).attr("original-title")){
			var OriginTitle = jQuery(this).attr("original-title");
			if(!jQuery(".KingkongBoard-Wrap").find(".help_title").html()){
				jQuery(".KingkongBoard-Wrap").append("<div class='help_title'>"+OriginTitle+"</div>");
				//jQuery(".KingkongBoard-Wrap").find(".help_title")

				var ThisPositionTop = ((jQuery(this).offset().top)*1) - 60;
				var ThisPositionLeft = (jQuery(this).position().left * 1) - (((jQuery(".KingkongBoard-Wrap").find(".help_title").width() * 1) - (jQuery(this).width() * 1)) * 0.5);
				jQuery(".KingkongBoard-Wrap").find(".help_title").css("top", ThisPositionTop+"px");
				jQuery(".KingkongBoard-Wrap").find(".help_title").css("left", ThisPositionLeft+"px");
			}
		}
	}, function(){
		jQuery(".help_title").remove();
	});
});

function kkb_notice_toolbox_close(){
	jQuery(".notice-toolbox").click(function(){
		jQuery(this).animate({top: -50, 'opacity': 0}, {duration:500, easing:'easeOutBack', complete:function(){
			jQuery(this).remove();
		}});
	});	
}

function kkb_notice_toolbox_auto_close(){
	jQuery(".notice-toolbox").animate({top: -50, 'opacity': 0}, {duration:500, easing:'easeOutBack', complete:function(){
			jQuery(this).remove();
	}});
}

function kkb_notice_toolbox_remove(){
	jQuery(this).animate({top: -50, 'opacity': 0}, {duration:500, easing:'easeOutBack', complete:function(){
		jQuery(this).remove();
	}});	
}

function kkb_notice_toolbox_open(type, message){
		jQuery(".notice-toolbox-wrapper").find(".notice-toolbox").remove();
		jQuery(".notice-toolbox-wrapper").append( kkb_notice_message_div(type, message) );
		jQuery(".notice-toolbox-wrapper").find(".notice-toolbox").css("opacity", 0);
		jQuery(".notice-toolbox-wrapper").find(".notice-toolbox").css("top", -100);
		jQuery(".notice-toolbox-wrapper").find(".notice-toolbox").animate({top: 0, 'opacity': 1}, {duration:300, easing:'easeOutBack'});

		kkb_notice_toolbox_close();
}

function kkb_notice_input(type, message){
	if(jQuery(".notice-toolbox-wrapper").find(".notice-toolbox").html()){
		jQuery(".notice-toolbox-wrapper").find(".notice-toolbox").animate({top: -50, 'opacity': 0}, {duration:500, easing:'easeOutBack', complete:function(){
		kkb_notice_toolbox_open(type, message);			
		}});
	} else {
		jQuery(".notice-toolbox-wrapper").append( kkb_notice_message_div(type, message) );
		jQuery(".notice-toolbox-wrapper").find(".notice-toolbox").css("opacity", 0);
		jQuery(".notice-toolbox-wrapper").find(".notice-toolbox").css("top", -100);
		jQuery(".notice-toolbox-wrapper").find(".notice-toolbox").animate({top: 0, 'opacity': 1}, {duration:300, easing:'easeOutBack'});			
	}

	kkb_notice_toolbox_close();
}

function kkb_notice_message_div(type, message){
	var messageDiv = '<div class="notice-toolbox"><table style="max-width:360px"><tr><td><i class="kkb-notice-icon kkb-notice-icon-'+type+'"></i></td><td><div>'+message+'</div></td></tr></table></div>';
	return messageDiv;
}

function kingkongboard_entry_remove_button_enable(){
	jQuery(".entry-attachment-remove").click(function(){
		jQuery(this).parent().css("background", "yellow");
		jQuery(this).parent().animate({opacity: 0}, {duration:500, complete:function(){
			jQuery(this).remove();
		}});
	});
}

function kkb_each_manager_remove(){
	jQuery(".each-manager-remove").click(function(){
		jQuery(this).parent().css("background", "yellow");
		jQuery(this).parent().animate({opacity : 0}, {duration:500, complete : function(){
			jQuery(this).remove();
		}})
	});
}

function kkb_latest_shortcode_remove(){
	jQuery(".each-shortcode-list-remove").click(function(){
		jQuery(this).parent().css("background", "yellow");
		jQuery(this).parent().animate({opacity: 0}, {duration:500, complete : function(){
			jQuery(this).remove();
		}})
	});
}

function remove_check_sum_entry_id(){
	var each_entry_id = '';
	jQuery(".each_entry_checkbox").each(function(i){
		if(jQuery(this).prop("checked") == true){
			if( i == (jQuery(".each_entry_checkbox").length - 1) ){
				each_entry_id += jQuery(this).val();
			} else {
				each_entry_id += jQuery(this).val()+",";
			}
		}
	});
	jQuery(".remove_entry_id").val(each_entry_id);
}

function check_kkb_xml_file(){
	if(!jQuery("[name=kkb_recovery_file]").val()){
		alert('복구하실 파일을 선택 해 주세요.');
		return false;
	}
}









