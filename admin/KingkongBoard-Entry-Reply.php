<?php
  $parent_id = '';
  if(isset($_POST['entry_title'])){
    $entry_title = sanitize_text_field($_POST['entry_title']);
  } else {
    $entry_title = false;
  }
  if($entry_title){
    $ParentBoard = get_board_id_by_entry_id(sanitize_text_field($_GET['id']));
    $Board = new KKB_Controller($ParentBoard);
    $Board->kkb_entry_write($_POST, 'admin');
  }

  if(isset($_GET['parent'])){
    $parent = sanitize_text_field($_GET['parent']);
  } else {
    $parent = false;
  }

  if($parent){
    if($parent != ''){
      $parent_id = $parent;
    }
  } else {
    $parent_id  = sanitize_text_field($_GET['id']);
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

  $guid = get_kingkong_board_meta_value($parent_id, 'guid');

?>
  <div class="head-area">
    <div style="float:left; position:relative; top:10px; margin-right:10px">
      <a href="?page=KingkongBoard"><img src="<?php echo KINGKONGBOARD_PLUGINS_URL;?>/assets/images/logo-kingkongboard.png" style="width:220px; height:auto"></a>
    </div>
    <div style="float:left; font-size:18px; margin-top:14px; margin-left:20px"><?php echo __('답변하기', 'kingkongboard');?> : <?php echo get_the_title($parent_id);?></div>
    <div style="float:right; position:relative; top:8px">
      <a href="#" class="button">Help</a>
    </div>
  </div>
  <div class="notice-toolbox-wrapper"></div>
  <div class="kkb-entry-wrapper">
    <form id="kingkongboard-entry-write-form" method="post">
    <input type="hidden" name="origin" value="<?php echo sanitize_text_field($_GET['id']);?>">
    <input type="hidden" name="parent" value="<?php echo $parent_id;?>">
    <table class="wp-list-table widefat fixed unite_table_items" style="padding:10px 10px">
      <tr>
        <th width="150"><?php echo __('제목', 'kingkongboard');?></th>
        <td><input type="text" name="entry_title" class="kkb-input" style="max-width:500px; width:100%" value="<?php echo get_the_title($board_id);?>"></td>
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
          <input type="hidden" name="entry_guid" value="<?php echo $guid;?>">
          <div class="description-container">
            <span class="description"><?php echo __('기본값은 데이터베이스 현재시간 입니다. 변경하실 경우 지정된 일시로 저장됩니다.', 'kingkongboard');?></span>
          </div> 
        </td>
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
