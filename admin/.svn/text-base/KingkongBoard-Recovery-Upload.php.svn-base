<?php
  
  $recovery_file = $_FILES['kkb_recovery_file'];
  //$Recovery = new KKB_Backup();
  //$Recovery->importXml($recovery_file['tmp_name']);
  $file = $recovery_file['tmp_name'];
  $upload_dir = wp_upload_dir();

  $folder = $upload_dir['basedir'].'/kingkongboard';
  
  if(!file_exists($folder.'/'.$recovery_file['name'])){
    $mkdir = @mkdir($folder);
  }
  copy($file, $folder.'/'.$recovery_file['name']);

  $file_path = $upload_dir['baseurl'].'/kingkongboard/'.$recovery_file['name'];
?>


<script>
  jQuery(document).ready(function(){
    jQuery.ajax({
      type : 'GET',
      url   : '<?php echo $file_path;?>',
      dataType : 'xml',
      async : false,
      success : kkb_response_parse
    });
  });

  function kkb_response_parse(xml){
    // 전체 DB 초기화
    //console.log(xml);

    jQuery(".kkb_backup_results").html("<li class='backup_reset'>기존 데이터 털어내는중...<span class='result_status'></span></li>");
    var data = {
      'action'  : 'kkb_backup_reset'
    }
    jQuery.post(ajaxurl, data, function(response) {
      if(response.status == 'success'){
        jQuery('.backup_reset').find('.result_status').html('success');
        kkb_step2_insert_board(xml);
      } else {
        jQuery('.backup_reset').find('.result_status').html('failed');
        console.log(response.log);
      }
    });

    // 게시판 부터 삽입
    // 게시판 메타정보 삽입
    // 게시글 삽입
    // 코멘트 삽입
    // 첨부/썸네일 삽입
    // 종료
  }

  function kkb_step2_insert_board(xml){
    var boards      = jQuery(xml).find('board').find('data');
    var board_count = jQuery(xml).find('board').find('data').length;
    jQuery(".kkb_backup_results").append("<li class='backup_create_board'>게시판 한땀한땀 만들고 있는중...<span class='result_status'><span class='current_count'>0</span>/"+board_count+"</span></li>");
    boards.each(function(){
      var ID                    = jQuery(this).find('ID').text();
      var post_title            = jQuery(this).find('post_title').text();
      var post_author           = jQuery(this).find('post_author').text();
      var post_date             = jQuery(this).find('post_date').text();
      var post_date_gmt         = jQuery(this).find('post_date_gmt').text();
      var post_content          = jQuery(this).find('post_content').text();
      var post_excerpt          = jQuery(this).find('post_excerpt').text();
      var post_status           = jQuery(this).find('post_status').text();
      var comment_status        = jQuery(this).find('comment_status').text();
      var ping_status           = jQuery(this).find('ping_status').text();
      var post_password         = jQuery(this).find('post_password').text();
      var post_name             = jQuery(this).find('post_name').text();
      var to_ping               = jQuery(this).find('to_ping').text();
      var pinged                = jQuery(this).find('pinged').text();
      var post_modified         = jQuery(this).find('post_modified').text();
      var post_modified_gmt     = jQuery(this).find('post_modified_gmt').text();
      var post_content_filtered = jQuery(this).find('post_content_filtered').text();
      var post_parent           = jQuery(this).find('post_parent').text();
      var guid                  = jQuery(this).find('guid').text();
      var menu_order            = jQuery(this).find('menu_order').text();
      var post_type             = jQuery(this).find('post_type').text();
      var post_mime_type        = jQuery(this).find('post_mime_type').text();
      var comment_count         = jQuery(this).find('comment_count').text();

      var data = {
        'action'                : 'kkb_backup_insert_post',
        'ID'                    : ID,
        'post_title'            : post_title,
        'post_author'           : post_author,
        'post_date'             : post_date,
        'post_date_gmt'         : post_date_gmt,
        'post_content'          : post_content,
        'post_excerpt'          : post_excerpt,
        'post_status'           : post_status,
        'comment_status'        : comment_status,
        'ping_status'           : ping_status,
        'post_password'         : post_password,
        'post_name'             : post_name,
        'to_ping'               : to_ping,
        'pinged'                : pinged,
        'post_modified'         : post_modified,
        'post_modified_gmt'     : post_modified_gmt,
        'post_content_filtered' : post_content_filtered,
        'post_parent'           : post_parent,
        'guid'                  : guid,
        'menu_order'            : menu_order,
        'post_type'             : post_type,
        'post_mime_type'        : post_mime_type,
        'comment_count'         : comment_count
      }
      jQuery.post(ajaxurl, data, function(response) {     
        if(response.status == 'success'){
          var current_count = jQuery(".backup_create_board").find(".current_count").html();
              current_count = current_count * 1;
          jQuery(".backup_create_board").find(".current_count").html((current_count+1));

          if( (current_count + 1) == board_count ){
            // 다음단계로 Go
            kkb_step3_insert_board_meta(xml);
          }
        } else {
          alert(response.status);
        }
      });
      //console.log(jQuery(this).find('post_title').text());
    });
  }


  function kkb_step3_insert_board_meta(xml){
    var board_meta  = jQuery(xml).find('board_meta').find('data');
    var board_count = jQuery(xml).find('board_meta').find('data').length;
    var meta_count  = jQuery(xml).find('board_meta').find('data').children().length;
    jQuery(".kkb_backup_results").append("<li class='backup_create_board_meta'>게시판 메타정보 들어서 옮기는중...<span class='result_status'><span class='current_count'>0</span>/"+(meta_count * board_count)+"</span></li>");
    board_meta.each(function(){
      var board_id          = jQuery(this).find('board_id').text();
      var title             = jQuery(this).find('title').text();
      var slug              = jQuery(this).find('slug').text();
      var shortcode         = jQuery(this).find('shortcode').text();
      var rows              = jQuery(this).find('rows').text();
      var editor            = jQuery(this).find('editor').text();
      var search_filter     = jQuery(this).find('search_filter').text();
      var thumbnail_dp      = jQuery(this).find('thumbnail_dp').text();
      var thumbnail_input   = jQuery(this).find('thumbnail_input').text();
      var board_skin        = jQuery(this).find('board_skin').text();
      var permission_read   = jQuery(this).find('permission_read').text();
      var permission_write  = jQuery(this).find('permission_write').text();
      var permission_delete = jQuery(this).find('permission_delete').text();
      var board_comment     = jQuery(this).find('board_comment').text();
      var notice_emails     = jQuery(this).find('notice_emails').text();
      var comment_options   = jQuery(this).find('comment_options').text();
      var thumbnail_upload  = jQuery(this).find('thumbnail_upload').text();
      var file_upload       = jQuery(this).find('file_upload').text();
      var board_sections    = jQuery(this).find('board_sections').text();
      var captcha           = jQuery(this).find('captcha').text();
      var captcha_sitekey   = jQuery(this).find('captcha_sitekey').text();
      var captcha_key       = jQuery(this).find('captcha_key').text();
      var managers          = jQuery(this).find('managers').text();
      var basic_form        = jQuery(this).find('basic_form').text();
      var exclude_keyword   = jQuery(this).find('exclude_keyword').text();
      var reply_use         = jQuery(this).find('reply_use').text();

      var data = {
        'action'            : 'kkb_backup_insert_board_meta',
        'board_id'          : board_id,
        'title'             : title,
        'slug'              : slug,
        'shortcode'         : shortcode,
        'rows'              : rows,
        'editor'            : editor,
        'search_filter'     : search_filter,
        'thumbnail_dp'      : thumbnail_dp,
        'thumbnail_input'   : thumbnail_input,
        'board_skin'        : board_skin,
        'permission_read'   : permission_read,
        'permission_write'  : permission_write,
        'permission_delete' : permission_delete,
        'board_comment'     : board_comment,
        'notice_emails'     : notice_emails,
        'comment_options'   : comment_options,
        'thumbnail_upload'  : thumbnail_upload,
        'file_upload'       : file_upload,
        'board_sections'    : board_sections,
        'captcha'           : captcha,
        'captcha_sitekey'   : captcha_sitekey,
        'captcha_key'       : captcha_key,
        'managers'          : managers,
        'basic_form'        : basic_form,
        'exclude_keyword'   : exclude_keyword,
        'reply_use'         : reply_use
      }

      jQuery.post(ajaxurl, data, function(response) { 
        if(response.status == 'success'){
          //jQuery(".backup_create_board_meta").find('.current_count').html();
          var current_count = jQuery(".backup_create_board_meta").find(".current_count").html();
              current_count = current_count * 1;
          jQuery(".backup_create_board_meta").find(".current_count").html((current_count+meta_count));
          if( (current_count + meta_count) == (meta_count * board_count) ){
            // 다음단계로 Go
            kkb_step4_insert_entry(xml);
          }
        }
      });
    });
  }


  function kkb_step4_insert_entry(xml){
    var boards      = jQuery(xml).find('kingkongboard_posts').find('data');
    var board_count = jQuery(xml).find('kingkongboard_posts').find('data').length;
    jQuery(".kkb_backup_results").append("<li class='backup_create_entry'>게시글 차에서 옮기는중...<span class='result_status'><span class='current_count'>0</span>/"+board_count+"</span></li>");

    boards.each(function(){
      var ID                    = jQuery(this).find('ID').text();
      var post_title            = jQuery(this).find('post_title').text();
      var post_author           = jQuery(this).find('post_author').text();
      var post_date             = jQuery(this).find('post_date').text();
      var post_date_gmt         = jQuery(this).find('post_date_gmt').text();
      var post_content          = jQuery(this).find('post_content').text();
      var post_excerpt          = jQuery(this).find('post_excerpt').text();
      var post_status           = jQuery(this).find('post_status').text();
      var comment_status        = jQuery(this).find('comment_status').text();
      var ping_status           = jQuery(this).find('ping_status').text();
      var post_password         = jQuery(this).find('post_password').text();
      var post_name             = jQuery(this).find('post_name').text();
      var to_ping               = jQuery(this).find('to_ping').text();
      var pinged                = jQuery(this).find('pinged').text();
      var post_modified         = jQuery(this).find('post_modified').text();
      var post_modified_gmt     = jQuery(this).find('post_modified_gmt').text();
      var post_content_filtered = jQuery(this).find('post_content_filtered').text();
      var post_parent           = jQuery(this).find('post_parent').text();
      var guid                  = jQuery(this).find('guid').text();
      var menu_order            = jQuery(this).find('menu_order').text();
      var post_type             = jQuery(this).find('post_type').text();
      var post_mime_type        = jQuery(this).find('post_mime_type').text();
      var comment_count         = jQuery(this).find('comment_count').text();

      var data = {
        'action'                : 'kkb_backup_insert_post',
        'ID'                    : ID,
        'post_title'            : post_title,
        'post_author'           : post_author,
        'post_date'             : post_date,
        'post_date_gmt'         : post_date_gmt,
        'post_content'          : post_content,
        'post_excerpt'          : post_excerpt,
        'post_status'           : post_status,
        'comment_status'        : comment_status,
        'ping_status'           : ping_status,
        'post_password'         : post_password,
        'post_name'             : post_name,
        'to_ping'               : to_ping,
        'pinged'                : pinged,
        'post_modified'         : post_modified,
        'post_modified_gmt'     : post_modified_gmt,
        'post_content_filtered' : post_content_filtered,
        'post_parent'           : post_parent,
        'guid'                  : guid,
        'menu_order'            : menu_order,
        'post_type'             : post_type,
        'post_mime_type'        : post_mime_type,
        'comment_count'         : comment_count
      }
      jQuery.post(ajaxurl, data, function(response) {  
        if(response.status == 'success'){
          var current_count = jQuery(".backup_create_entry").find(".current_count").html();
              current_count = current_count * 1;
          jQuery(".backup_create_entry").find(".current_count").html((current_count+1));

          if( (current_count + 1) == board_count ){
            // 다음단계로 Go
            kkb_step5_remove_all_meta(xml);
          }
        } else {
          alert(response.status);
        }
      });
      //console.log(jQuery(this).find('post_title').text());
    });    
  }

  function kkb_step5_remove_all_meta(xml){
    jQuery(".kkb_backup_results").append("<li class='backup_remove_entry_meta'>기존 메타정보 청소기 돌리는중...<span class='result_status'></span></li>");
    data = {
      'action' : 'kkb_remove_all_kkb_meta'
    }
    jQuery.post(ajaxurl, data, function(response) { 
      if(response.status == 'success'){
        jQuery(".backup_remove_entry_meta").find(".result_status").html('success');
        kkb_step6_insert_entry_meta(xml);
      } else {
        jQuery(".backup_remove_entry_meta").find(".result_status").html('failed');
      }
    });
  }

  function kkb_step6_insert_entry_meta(xml){
    var board_meta      = jQuery(xml).find('kingkongboard_meta').find('data');
    var count           = jQuery(xml).find('kingkongboard_meta').find('data').length;
    jQuery(".kkb_backup_results").append("<li class='backup_create_entry_meta'>복원될 메타정보 끼워맞추는중...<span class='result_status'><span class='current_count'>0</span>/"+count+"</span></li>");

    board_meta.each(function(){
      var hits        = jQuery(this).find('hits').text();
      var attached    = jQuery(this).find('attached').text();
      var secret      = jQuery(this).find("secret").text();
      var thumbnail   = jQuery(this).find('thumbnail').text();
      var ID          = jQuery(this).find('ID').text();
      var board_id    = jQuery(this).find('board_id').text();
      var post_id     = jQuery(this).find('post_id').text();
      var section     = jQuery(this).find('section').text();
      var related_id  = jQuery(this).find('related_id').text();
      var list_number = jQuery(this).find('list_number').text();
      var depth       = jQuery(this).find('depth').text();
      var parent      = jQuery(this).find('parent').text();
      var type        = jQuery(this).find('type').text();
      var date        = jQuery(this).find('date').text();
      var guid        = jQuery(this).find('guid').text();
      var login_id    = jQuery(this).find('login_id').text();
      var writer      = jQuery(this).find('writer').text();

      var data = {
        'action'      : 'kkb_backup_insert_entry_meta',
        'hits'        : hits,
        'attached'    : attached,
        'secret'      : secret,
        'thumbnail'   : thumbnail,
        'ID'          : ID,
        'board_id'    : board_id,
        'post_id'     : post_id,
        'section'     : section,
        'related_id'  : related_id,
        'list_number' : list_number,
        'depth'       : depth,
        'parent'      : parent,
        'type'        : type,
        'date'        : date,
        'guid'        : guid,
        'login_id'    : login_id,
        'writer'      : writer
      }

      jQuery.post(ajaxurl, data, function(response) { 
        //alert(response);
        if(response.status == 'success'){
          var current_count = jQuery(".backup_create_entry_meta").find(".current_count").html();
              current_count = current_count * 1;
          jQuery(".backup_create_entry_meta").find(".current_count").html((current_count+1));

          if( (current_count + 1) == count ){
            // 다음단계로 Go
            kkb_step7_remove_all_comment(xml);
          }
        } else {
          //alert(response.status);
        }
      });

    });
  }

  function kkb_step7_remove_all_comment(xml){
    jQuery(".kkb_backup_results").append("<li class='backup_remove_comment'>기존 댓글 메타정보 쓸어담는중...<span class='result_status'></span></li>");
    var data = {
      'action' : 'remove_kkb_comment_meta'
    }
    jQuery.post(ajaxurl, data, function(response) {
      if(response.status == 'success'){
        jQuery(".backup_remove_comment").find(".result_status").html("success");
        kkb_step8_insert_comments(xml);
      } else {
        jQuery(".backup_remove_comment").find(".result_status").html("failed");
      }
    });
  }

  function kkb_step8_insert_comments(xml){
    var comments      = jQuery(xml).find('comments').find('data');
    var count           = jQuery(xml).find('comments').find('data').length;
    jQuery(".kkb_backup_results").append("<li class='backup_create_comment'>댓글을 밀어 넣고 있습니다...<span class='result_status'><span class='current_count'>0</span>/"+count+"</span></li>");
    comments.each(function(){
      var comment_ID            = jQuery(this).find("comment_ID").text();
      var comment_post_ID       = jQuery(this).find("comment_post_ID").text();
      var comment_author        = jQuery(this).find("comment_author").text();
      var comment_author_email  = jQuery(this).find("comment_author_email").text();
      var comment_author_url    = jQuery(this).find("comment_author_url").text();
      var comment_author_IP     = jQuery(this).find("comment_author_IP").text();
      var comment_date          = jQuery(this).find("comment_date").text();
      var comment_date_gmt      = jQuery(this).find("comment_date_gmt").text();
      var comment_content       = jQuery(this).find("comment_content").text();
      var comment_karma         = jQuery(this).find("comment_karma").text();
      var comment_approved      = jQuery(this).find("comment_approved").text();
      var comment_agent         = jQuery(this).find("comment_agent").text();
      var comment_type          = jQuery(this).find("comment_type").text();
      var comment_parent        = jQuery(this).find("comment_parent").text();
      var user_id               = jQuery(this).find("user_id").text();

      var data = {
        'action'                : 'kkb_backup_insert_comments',
        'comment_ID'            : comment_ID,
        'comment_post_ID'       : comment_post_ID,
        'comment_author'        : comment_author,
        'comment_author_email'  : comment_author_email,
        'comment_author_url'    : comment_author_url,
        'comment_author_IP'     : comment_author_IP,
        'comment_date'          : comment_date,
        'comment_date_gmt'      : comment_date_gmt,
        'comment_content'       : comment_content,
        'comment_karma'         : comment_karma,
        'comment_approved'      : comment_approved,
        'comment_agent'         : comment_agent,
        'comment_type'          : comment_type,
        'comment_parent'        : comment_parent,
        'user_id'               : user_id
      }

      jQuery.post(ajaxurl, data, function(response) {
        if(response.status == 'success'){
          var current_count = jQuery(".backup_create_comment").find(".current_count").html();
              current_count = current_count * 1;
          jQuery(".backup_create_comment").find(".current_count").html((current_count+1));

          if( (current_count + 1) == count ){
            // 다음단계로 Go
            kkb_step9_insert_comment_meta(xml);
          }
        } else {
          //alert(response.status);
        }
      });

    });
  }

  function kkb_step9_insert_comment_meta(xml){
    var comments      = jQuery(xml).find('kingkongboard_comment_meta').find('data');
    var count           = jQuery(xml).find('kingkongboard_comment_meta').find('data').length;
    jQuery(".kkb_backup_results").append("<li class='backup_create_comment_meta'>댓글 메타정보 이쁘게 저장중...<span class='result_status'><span class='current_count'>0</span>/"+count+"</span></li>");
    comments.each(function(){
      var ID      = jQuery(this).find("ID").text();
      var lnumber = jQuery(this).find("lnumber").text();
      var eid     = jQuery(this).find("eid").text();
      var cid     = jQuery(this).find("cid").text();
      var origin  = jQuery(this).find("origin").text();
      var parent  = jQuery(this).find("parent").text();
      var depth   = jQuery(this).find("depth").text();

      var data = {
        'action'  : 'kkb_backup_insert_comment_meta',
        'ID'      : ID,
        'lnumber' : lnumber,
        'eid'     : eid,
        'cid'     : cid,
        'origin'  : origin,
        'parent'  : parent,
        'depth'   : depth
      }

      jQuery.post(ajaxurl, data, function(response) {
        if(response.status == 'success'){
          var current_count = jQuery(".backup_create_comment_meta").find(".current_count").html();
              current_count = current_count * 1;
          jQuery(".backup_create_comment_meta").find(".current_count").html((current_count+1));

          if( (current_count + 1) == count ){
            // 다음단계로 Go
            kkb_step10_remove_temp_xml();
          }
        } else {
          //alert(response.status);
        }        
      });

    });
  }

  function kkb_step10_remove_temp_xml(){
    jQuery(".kkb_backup_results").append("<li class='backup_remove_temp'>임시파일 삭제중...<span class='result_status'></span></li>");
    var data = {
      'action'  : 'kkb_remove_temp_file'
    }
    jQuery.post(ajaxurl, data, function(response) {
      if(response.status == 'success'){
        jQuery(".backup_remove_temp").find(".result_status").html("success");
        kkb_step11_success_message();      
      } else {
        jQuery(".backup_remove_temp").find(".result_status").html("failed");        
      }
    });
  }


  function kkb_step11_success_message(){
    jQuery(".kkb_backup_results").append("<li class='backup_success' style='color:green; font-weight:600'>정상적으로 복원 되었습니다!</li>");
  }









</script>

<h2><?php echo __('킹콩보드 복원 진행중', 'kingkongboard');?></h2>
<div class="kkb_backup_results"></div>