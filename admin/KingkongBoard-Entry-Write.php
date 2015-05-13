<?php
if(isset($_POST['entry_title'])){
  $entry_title = sanitize_text_field($_POST['entry_title']);
} else {
  $entry_title = null;
}
  if($entry_title){
    $Board = new KKB_Controller(sanitize_text_field($_GET['id']));
    $Board->kkb_entry_write($_POST, 'admin');
  }

  $current_user   = wp_get_current_user();
  $hour_options   = null;
  $minute_options = null;
  $second_options = null;

  for ($i = 0; $i < 24; $i++) { 
    if($i == date( 'H', current_time( 'timestamp', 0 ) ) ){
      $hour_options .= '<option selected>'.$i.'</option>';
    } else {
      $hour_options .= '<option>'.$i.'</option>';
    }
  }

  for ($i = 0; $i < 60; $i++) {
    if($i == date( 'i', current_time( 'timestamp', 0 ) ) ){
      $minute_options .= '<option selected>'.$i.'</option>';
    } else {
      $minute_options .= '<option>'.$i.'</option>';
    }
  }

  for ($i = 0; $i < 60; $i++) {
    if($i == date( 's', current_time( 'timestamp', 0 ) ) ){
      $second_options .= '<option selected>'.$i.'</option>';
    } else {
      $second_options .= '<option>'.$i.'</option>';
    }
  }

  $post_list  = null;
  $board_slug = get_post_meta( $board_id, 'kingkongboard_slug', true );
  $board_slug = "kingkong_board ".$board_slug;
  $added_post_lists = check_board_shortcode_using( $board_slug );

  foreach($added_post_lists as $list){
    $post_list .= '<option value="'.$list.'">'.get_the_title($list).'</option>';
  }

?>
  <div class="head-area">
    <div style="float:left; position:relative; top:10px; margin-right:10px">
      <a href="?page=KingkongBoard"><img src="<?php echo KINGKONGBOARD_PLUGINS_URL;?>/assets/images/logo-kingkongboard.png" style="width:220px; height:auto"></a>
    </div>
    <div style="float:left; font-size:18px; margin-top:14px; margin-left:20px"><?php echo __('게시판 글쓰기', 'kingkongboard');?> : <?php echo get_the_title($board_id);?></div>
    <div style="float:right; position:relative; top:8px">
      <a href="#" class="button">Help</a>
    </div>
  </div>

<?php

  if($added_post_lists){

?>
  <div class="notice-toolbox-wrapper"></div>
  <div class="kkb-entry-wrapper">
    <form id="kingkongboard-entry-write-form" method="post">
    <input type="hidden" name="page_id" value="<?php echo sanitize_text_field($_GET['id']);?>">
    <table class="wp-list-table widefat fixed unite_table_items" style="padding:10px 10px">
      <tr>
        <th width="150"><?php echo __('제목', 'kingkongboard');?></th>
        <td><input type="text" name="entry_title" class="kkb-input" style="max-width:500px; width:100%"></td>
      </tr>
      <tr>
        <th width="150"><?php echo __('작성자', 'kingkongboard');?></th>
        <td>
          <input type="text" name="entry_writer" class="kkb-input" style="max-width:150px; width:100%" value="<?php echo $current_user->display_name;?>">
          <div class="description-container">
            <span class="description"><?php echo __('기본값은 현재 관리자 display name 입니다. 변경하실 경우 수정하시면 됩니다.', 'kingkongboard');?></span>
          </div>  
        </td>
      </tr>
      <tr>
        <th width="150"><?php echo __('작성일시', 'kingkongboard');?></th>
        <td>
          년-월-일 : <input type="text" id="entry_date" class="kkb-input" name="entry_ymd" value="<?php echo date( 'Y-m-d', current_time( 'timestamp', 0 ) );?>" style="max-width:100px; width:100%" /> <select class="kkb-input" name="entry_h"><?php echo $hour_options;?></select>시 <select class="kkb-input" name="entry_i"><?php echo $minute_options;?></select>분 <select class="kkb-input" name="entry_s"><?php echo $second_options;?></select>초
          <div class="description-container">
            <span class="description"><?php echo __('기본값은 데이터베이스 현재시간 입니다. 변경하실 경우 지정된 일시로 저장됩니다.', 'kingkongboard');?></span>
          </div> 
        </td>
      </tr>
      <tr>
        <th width="150"><?php echo __('동록된 페이지/포스트', 'kingkongboard');?></th>
        <td>
          <select class="kkb-input" name="entry_guid" style="max-width:400px; width:100%"><?php echo $post_list;?></select>
          <div class="description-container">
            <span class="description"><?php echo __('관리자에서 임의로 글을 등록하기 위해서는 해당 게시판이 등록되어 있는 페이지 또는 포스트의 ID 값이 필요합니다.', 'kingkongboard');?></span>
          </div>           
        </td>
      </tr>
      <tr>
        <th width="150"><?php echo __('종류', 'kingkongboard');?></th>
        <td><input type="checkbox" name="entry_notice" value="notice"> <?php echo __('공지사항', 'kingkongboard');?></td>
      </tr>
      <tr>
        <th width="150"><?php echo __('설정', 'kingkongboard');?></th>
        <td><input type="checkbox" name="entry_secret"> <?php echo __('비밀글', 'kingkongboard');?></td>
      </tr>
      <tr>
        <th width="150"><?php echo __('비밀번호', 'kingkongboard');?></th>
        <td><input type="password" name="entry_password" class="kkb-input" style="max-width:300px; width:100%"></td>
      </tr>
      <tr>
        <th width="150"><?php echo __('내용', 'kingkongboard');?></th>
        <td><textarea class="kkb-textarea" name="entry_content" style="max-width:500px; width:100%; height:200px"></textarea></td>
      </tr>
      <tr>
        <th width="150"><?php echo __('첨부', 'kingkongboard');?></th>
        <td><button type="button" class="button-kkb kkbblue button-entry-file-upload"><i class="kkb-icon kkb-icon-file"></i><?php echo __('첨부파일 업로드', 'kingkongboard');?></button></td>
      </tr>
      <tr>
        <th></th>
        <td class="entry-file-list"></td>
      </tr>
      <?php do_action('kingkong_board_admin_entry_input_after'); ?>
    </table>
    <br><button type="submit" class="button-kkb kkbgreen"><i class="kkb-icon kkb-icon-pen"></i><?php echo __('작성 완료', 'kingkongboard');?></button> <button class="button-kkb kkbred"><i class="kkb-icon kkb-icon-close"></i><?php echo __('취소', 'kingkongboard');?></button>
    </form>
  </div>

<?php 
  } else {
?>
  <div class="kkb-entry-wrapper">
    <?php echo __('관리자 모드에서 글을 등록하기 위해서는 해당 게시판 숏코드를 페이지 또는 포스트에 등록을 먼저 해주셔야 합니다.', 'kingkongboard');?>
  </div>
<?php
  }
?>
