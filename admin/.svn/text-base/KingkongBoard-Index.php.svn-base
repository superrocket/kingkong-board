  <div class="notice-toolbox-wrapper"></div>
  <div class="head-area">
    <div style="float:left; position:relative; top:10px; margin-right:10px">
      <img src="<?php echo KINGKONGBOARD_PLUGINS_URL;?>/assets/images/logo-kingkongboard.png" style="width:220px; height:auto">
    </div>
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
      <div style="float:right; position:relative; top:-5px; margin-right:5px"><a href="<?php echo KINGKONGBOARD_PLUGINS_URL;?>/data/backup.php" class="button">데이터 백업</a> <a href="?page=KingkongBoard&view=recovery" class="button">데이터 복구</a></div>
    </div>
  </div>
  <div class="content-area">
    <div class="title_line">Kingkong Boards</div>
    <table class="wp-list-table widefat fixed unite_table_items">
      <thead>
        <tr>
          <th width="100px">ID</th>
          <th width="25%"><?php echo __('게시판 명', 'kingkongboard');?></th>
          <th width="120px"><?php echo __('숏코드', 'kingkongboard');?></th>
          <th width="100"><?php echo __('포스트타입', 'kingkongboard');?></th>
          <th width="70px"><?php echo __('종류', 'kingkongboard');?></th>
          <th width="50%"><?php echo __('Actions', 'kingkongboard');?></th>
        </tr>
      </thead>
      <tbody>
<?php
  $args = array(
    'post_type'   => 'kkboard',
    'post_status' => 'publish'
  );

  $query = new WP_Query( $args );

  if( $query->have_posts() ){
    while( $query->have_posts() ){
      $query->the_post();
      $board_id         = get_the_ID();
      $board_title      = get_the_title();
      $board_shortcode  = get_post_meta($board_id, 'kingkongboard_shortcode', true);
      $board_slug       = get_post_meta($board_id, 'kingkongboard_slug', true);
      $board_style      = get_post_meta($board_id, 'board_skin', true);
      if(!$board_style){
        $board_style = "basic";
      }
?>
        <tr>
          <td><?php echo $board_id;?></td>
          <td><a href="?page=KingkongBoard&view=modify&id=<?php echo $board_id;?>"><?php the_title();?></a></td>
          <td><?php echo $board_shortcode;?></td>
          <td><?php echo $board_slug;?></td>
          <td><?php echo $board_style;?></td>
          <td>
            <a href="?page=KingkongBoard&view=modify&id=<?php echo $board_id;?>" class="button-kkb kkbgreen"><i class="kkb-icon kkb-icon-setting"></i><?php echo __('옵션설정', 'kingkongboard');?></a>
            <a href="?page=KingkongBoard&view=entry&id=<?php echo $board_id;?>" class="button-kkb kkbblue"><i class="kkb-icon kkb-icon-list"></i><?php echo __('리스트 보기', 'kingkongboard');?></a>
            <!--<a class="button-kkb kkborange"><i class="kkb-icon kkb-icon-export"></i>Data 내보내기</a>-->
            <a class="button-kkb kkbred button-board-remove" original-title="삭제" data="<?php echo $board_id;?>"><i class="kkb-icon kkb-icon-trash"></i></a>
            <!--<a class="button-kkb kkbyellow" original-title="복사하기"><i class="kkb-icon kkb-icon-duplicate"></i></a>-->
<?php
  $added_post_lists = check_board_shortcode_using( "kingkong_board ".$board_slug );
  if($added_post_lists){
    $link = get_the_permalink($added_post_lists[0]);
?>
            <a href="<?php echo $link;?>" target="_blank" class="button-kkb kkbyellow" original-title="게시판 보기"><i class="kkb-icon kkb-icon-preview"></i></a>
<?php
  } else {
?>
            <a class="button-kkb kkbgray" original-title="페이지 또는 포스트에 숏코드를 등록 하셔야 게시판 보기를 하실 수 있습니다."><i class="kkb-icon kkb-icon-preview"></i></a>
<?php
  }
?>
          </td>
        </tr>
<?php
    }
  } else {
?>
        <tr>
          <td colspan="6"><?php echo __('생성된 게시판이 없습니다.', 'kingkongboard');?></td>
        </tr>
<?php
  }
?>
      </tbody>
    </table>
    <div style="float:left; margin-top:10px">
      <a href="?page=KingkongBoard&view=create" class="button-kkb kkbblue"><?php echo __('신규 게시판 생성', 'kingkongboard');?></a>
    </div>
  </div>