 
  <div class="head-area">
    <div style="float:left; position:relative; top:10px; margin-right:10px">
      <a href="?page=KingkongBoard"><img src="<?php echo KINGKONGBOARD_PLUGINS_URL;?>/assets/images/logo-kingkongboard.png" style="width:220px; height:auto"></a>
    </div>
    <div style="float:left; font-size:18px; margin-top:14px; margin-left:20px"><?php echo __('게시판 글목록', 'kingkongboard');?> : <?php echo get_the_title($board_id);?></div>
    <div style="float:right; position:relative; top:8px">
      <div class="fb-like" data-href="https://facebook.com/superrocketer" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true" style="position:relative; top:-10px; margin-right:10px"></div>
      <a href="http://superrocket.io" target="_blank"><img src="<?php echo KINGKONGBOARD_PLUGINS_URL;?>/assets/images/superrocket-symbol.png" style="height:34px; width:auto" class="superrocket-logo" alt="superrocket.io"></a>
      <a href="https://www.facebook.com/superrocketer" target="_blank"><img src="<?php echo KINGKONGBOARD_PLUGINS_URL;?>/assets/images/icon-facebook.png" style="height:34px; width:auto" class="superrocket-logo" alt="facebook"></a>
      <a href="https://instagram.com/superrocketer/" target="_blank"><img src="<?php echo KINGKONGBOARD_PLUGINS_URL;?>/assets/images/icon-instagram.png" style="height:34px; width:auto" class="superrocket-logo" alt="instagram"></a>
    </div>
  </div>
  <div class="content-area">
    <div style="padding:20px 10px">
      <div style="float:left; position:relative; top:0px; margin-right:10px">"킹콩마트가 오픈하였습니다. 보다 다양한 스킨과 익스텐션을 경험하세요! "</div> <a href="?page=srshop" class="button-kkb kkbred">킹콩마트 둘러보기</a>
    </div>
  </div>
  <div class="notice-toolbox-wrapper"></div>
  <div class="kkb-entry-wrapper">
<?php 
  $KKB_List = new KKB_List($board_id);
  $entries = apply_filters('admin_kingkong_board_entry_columns', 'admin_kingkong_board_entry_columns', $entry = null, $board_id); 
?>
    <input type="hidden" class="board_id" value="<?php echo $board_id;?>">
    <div style="float:left; padding-bottom:5px"><select class="kkb-input entry_filter_select" style="max-width:300px"><option><?php echo __('일괄작업', 'kingkongboard');?></option><option value="remove-all"><?php echo __('선택된 게시글을 모두 삭제합니다.', 'kingkongboard');?></option></select> <a class="button-kkb kkbblue proc-entry-all-remove"><?php echo __('적용', 'kingkongboard');?></a></div>
    <div style="float:right; margin-right:5px; padding-bottom:5px"><?php echo __('등록된 총 글 수', 'kingkongboard');?> : <span style="background:#616161; color:#fff; border-radius:10px; padding:0 5px"><?php echo $KKB_List->entry_count;?></span></div>
    <table class="wp-list-table widefat fixed unite_table_items">
      <tr>
<?php
    echo "<th class='entry-th-checkbox'><input type='checkbox' class='select-all-entry'></th>";
    echo "<th class='entry-th-id'>".__('번호', 'kingkongboard')."</th>";
  foreach($entries as $entry){
    echo "<th class='entry-th-".$entry['value']."'>".$entry['label']."</th>";
  }
?>
      </tr>

<?php
  if(isset($_GET['paged'])){
    $page = sanitize_text_field($_GET['paged']);
  } else {
    $page = 1;
  }

  $bResults    = $KKB_List->kkb_get_basic_list($page);
  $nResults    = $KKB_List->kkb_get_notice_list();
  $totalCount  = $KKB_List->kkb_get_list_count('all');
  $noticeCount = $KKB_List->kkb_get_list_count('notice');
  $pageCount   = $KKB_List->kkb_pagination();
  $basic_rows  = '';
  $notice_rows = '';

  foreach($nResults as $nResult){
    $notice_rows .= '<tr class="entry-notice"><td><input type="checkbox" class="each_entry_checkbox" value="'.$nResult->post_id.'"></td><td><span class="label-notice">'.__('공지', 'kingkongboard').'</span></td>';
    $notice_rows .= apply_filters('admin_kingkong_board_manage_entry_column', $entries, $nResult->post_id );
    $notice_rows .= '</tr>';
  }

  $cnt = ($totalCount-$noticeCount) - (($page * $KKB_List->config->board_rows) - ($KKB_List->config->board_rows));

  foreach($bResults as $bResult){
    $basic_rows .= '<tr><td><input type="checkbox" class="each_entry_checkbox" value="'.$bResult->post_id.'"></td><td>'.$cnt.'</td>';
    $basic_rows .= apply_filters('admin_kingkong_board_manage_entry_column', $entries, $bResult->post_id );
    $basic_rows .= '</tr>';
    $cnt--;
  }

    echo $notice_rows.$basic_rows;
?>

    </table>
    <nav class='kingkong-board-entry-nav'>
 <?php 

      $activate_page = 'class="activated"';
      $pagination    = '';

      if($pageCount > 1){
        for ($i=0; $i < $pageCount; $i++) { 
          if($page == ($i+1)){
            $pagination .= '<span>'.($i+1).'</span>';
          } else {
            $pagination .= '<a href="?page=KingkongBoard&view=entry&id='.$board_id.'&paged='.($i+1).'"><span>'.($i+1).'</span></a>';
          }
        }

        echo $pagination;

      }
  ?>
    </nav>
    <br><input type="hidden" class="remove_entry_id"><a href="?page=KingkongBoard&view=entry-write&id=<?php echo $board_id;?>" class="button-kkb kkbblue"><i class="kkb-icon kkb-icon-pen"></i><?php echo __('글 쓰기', 'kingkongboard');?></a> <a href="?page=KingkongBoard&view=modify&id=<?php echo $board_id;?>" class="button-kkb kkbgreen"><i class="kkb-icon kkb-icon-setting"></i><?php echo __('게시판 옵션설정', 'kingkongboard');?></a> <a href="?page=KingkongBoard" class="button-kkb kkbred"><?php echo __('이전으로', 'kingkongboard');?></a>
  </div>