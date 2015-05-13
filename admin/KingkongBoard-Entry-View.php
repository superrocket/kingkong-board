
  <div class="head-area">
    <div style="float:left; position:relative; top:10px; margin-right:10px">
      <a href="?page=KingkongBoard"><img src="<?php echo KINGKONGBOARD_PLUGINS_URL;?>/assets/images/logo-kingkongboard.png" style="width:220px; height:auto"></a>
    </div>
    <div style="float:left; font-size:18px; margin-top:14px; margin-left:20px"><?php echo get_the_title($board_id);?></div>
    <div style="float:right; position:relative; top:8px">
      <a href="#" class="button">Help</a>
    </div>
  </div>
  <div class="notice-toolbox-wrapper"></div>
  <div class="kkb-entry-wrapper">
    <table class="wp-list-table widefat fixed unite_table_items" style="padding:10px 10px">
      <tr>
        <th width="150"><?php echo __('제목', 'kingkongboard');?></th>
        <td><?php echo get_the_title($board_id);?></td>
      </tr>
      <tr>
        <th width="150"><?php echo __('내용', 'kingkongboard');?></th>
        <td><?php echo nl2br(get_post_field('post_content', $board_id));?></td>
      </tr>
      <tr>
        <th width="150"><?php echo __('첨부', 'kingkongboard');?></th>
        <td>
<?php
  $entry_attachment = unserialize(get_post_meta($board_id, 'kingkongboard_attached', true));

  if($entry_attachment){
    foreach($entry_attachment as $attachment_id){
      echo "<div class='entry-attachment-div'><a href='".wp_get_attachment_url( $attachment_id )."' target='_blank'>".preg_replace( '/^.+[\\\\\\/]/', '', get_attached_file( $attachment_id ) )."</a></div>";
    }
  } else {
    echo __("없음", "kingkongboard");
  }

  $board = get_board_id_by_entry_id($board_id);

  if(isset($_GET['parent'])){
    $parent = sanitize_text_field($_GET['parent']);
    if($parent != ''){
      $parent_id  = $parent;
      $parent_prm = '&parent='.$parent_id;
    }
  } else {
    $parent_id    = sanitize_text_field($_GET['id']);
    $parent_prm   = '';
  }

?>
        </td>
      </tr>
      <tr>
        <th></th>
        <td class="entry-file-list"></td>
      </tr>
      <?php do_action('kingkong_board_admin_entry_input_after'); ?>
    </table>
    <br><a href="?page=KingkongBoard&view=entry-reply&id=<?php echo $board_id;?><?php echo $parent_prm;?>" class="button-kkb kkbgreen"><i class="kkb-icon kkb-icon-pen"></i><?php echo __('답변하기', 'kingkongboard');?></a> <a href="?page=KingkongBoard&view=entry&id=<?php echo $board;?>" class="button-kkb kkbred"><i class="kkb-icon kkb-icon-close"></i><?php echo __('취소', 'kingkongboard');?></a>
  </div>
