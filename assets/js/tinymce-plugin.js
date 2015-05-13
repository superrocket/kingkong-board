(function() {
	var boards = '';
	var data = {
		'action' 	: 'get_all_kingkong_boards'
	};

	jQuery.post(ajaxurl, data, function(response) { 
		boards = response;
	});
	tinymce.create('tinymce.plugins.KingkongBoard', {
		init : function(ed, url) {
			ed.addButton('KingkongBoard', {
				title : 'Kingkong Board',
				image : url+'/../images/button-kingkong.png',
				onclick : function() {
					if(!jQuery("#wpwrap").find("#KingkongBoard-Shortcode-Wrap").html()){
						jQuery("#wpwrap").append("<div id='KingkongBoard-Shortcode-Wrap'><div class='background-area'></div><div class='content-area'><div class='content-background'><table><tr><td colspan='2'>붙여넣을 게시판을 선택하세요.</td></tr><tr><td><select class='select-kingkongboard'>"+boards+"</select></td><td><button type='button' class='button button-primary paste_kingkongboard'>붙여넣기</button></td></tr></table></div></div></div>");

						jQuery(".paste_kingkongboard").click(function(){
							var shortcode = jQuery(".select-kingkongboard").val();
							ed.execCommand('mceInsertContent', false, '[kingkong_board '+shortcode+']');
							jQuery("#wpwrap").find("#KingkongBoard-Shortcode-Wrap").remove();
						});

						jQuery("#KingkongBoard-Shortcode-Wrap").find(".background-area").not(".content-area").click(function(){
							jQuery("#wpwrap").find("#KingkongBoard-Shortcode-Wrap").remove();
						});
					}
					
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('KingkongBoard', tinymce.plugins.KingkongBoard);
})();