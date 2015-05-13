<?php
  function KingkongBoard_Setting_Panel_Latest_Board(){
?>

    <table>
      <tr>
        <th><?php echo __('타이틀', 'kingkongboard');?> :</th>
        <td>
          <input type="text" name="kkb_shortcode_title" class="kkb-input" style="max-width:100%; width:100%">
          <div class="description-container">
            <span class="description"><?php echo __('해당 숏코드의 명칭을 지정하세요.', 'kingkongboard');?></span>
          </div>
        </td>
      </tr>
      <tr>
        <th><?php echo __('스킨선택', 'kingkongboard');?> :</th>
        <td>
          <select class="kkb-input-select" name="kkb_shortcode_skin">
            <option value="basic"><?php echo __('최신글 리스트', 'kingkongboard');?></option>
            <?php do_action('kingkongboard_latest_option_after'); ?>
          </select>
        </td>
      </tr>
      <tr>
        <th><?php echo __('표시 게시물 수', 'kingkongboard');?> :</th>
        <td>
          <input type="text" name="kkb_shortcode_list_number" class="kkb-input" style="max-width:80px; width:100%">
          <div class="description-container">
            <span class="description"><?php echo __('리스트에 보여지는 게시물 수를 지정합니다.', 'kingkongboard');?></span>
          </div>          
        </td>
      </tr>
      <tr>
        <th><?php echo __('글 길이 제한', 'kingkongboard');?> :</th>
        <td>
          <input type="text" name="kkb_shortcode_length" class="kkb-input" style="max-width:80px; width:100%">
          <div class="description-container">
            <span class="description"><?php echo __('표시될 글의 길이를 제한합니다.', 'kingkongboard');?></span>
          </div>          
        </td>
      </tr>
      <tr>
        <td colspan="2" style="text-align:right">
          <button type="button" class="kkb-icon kkbblue button-add-latest-shortcode">
            <i class="kkb-icon kkb-icon-plus" style="position:relative; top:3px"></i>
            <?php echo __('숏코드 생성', 'kingkongboard');?>
          </button>
        </td>
      </tr>
      <tr>
        <td colspan="2"><hr></td>
      </tr>
      <tfoot>
        <tr>
          <td colspan="2" class="shortcode-result">
<?php
  if(isset($_GET['id'])){
    $board_id = sanitize_text_field($_GET['id']);
    $added_latest = get_post_meta($board_id, 'kingkongboard_added_latest', true);
     
    if($added_latest){
      $added_latest = unserialize($added_latest);
      foreach($added_latest as $latest){
        echo '<div class="each-shortcode-list"><ul><li>'.$latest['title'].'</li><li>[kingkong_board_latest title="'.$latest['title'].'" skin="'.$latest['skin'].'" number="'.$latest['number'].'" length="'.$latest['length'].'" board_id="'.$latest['board_id'].'"]</li></ul><input type="hidden" name="added_latest_shortcode_title[]" value="'.$latest['title'].'"><input type="hidden" name="added_latest_skin[]" value="'.$latest['skin'].'"><input type="hidden" name="added_latest_list_number[]" value="'.$latest['number'].'"><input type="hidden" name="added_latest_length[]" value="'.$latest['length'].'"><input type="hidden" name="added_latest_board_id[]" value="'.$latest['board_id'].'"><div class="each-shortcode-list-remove"><img src="'.KINGKONGBOARD_PLUGINS_URL.'/assets/images/icon-close.png" style="width:15px; height:auto"></div></div>';
      }
    }
  }
?>
          </td>
        </tr>
      </tfoot>
    </table>

<?php
  }
?>