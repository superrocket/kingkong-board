<?php
  function KingkongBoard_Setting_Panel_Extension(){

    if(isset($_GET['id'])){
      $board_id = sanitize_text_field($_GET['id']);
      $board_extension = get_post_meta($board_id, 'board_extension', true);
    } else {
      $board_extension = "kkbext_qna";
    }
?>

    <table>
      <tr>
        <th><?php echo __('익스텐션(확장기능) 설정', 'kingkongboard');?>
          <div class="description-container">
            <span class="description"><?php echo __('기본 게시판 기능외의 별도의 기능의 게시판을 설정 합니다. 기능에 따라 게시판 생성 후 추가 옵션 패널이 나타날 수도 있습니다.', 'kingkongboard');?></span>
          </div>                
        </th>
      </tr>
      <tr>
        <td>
          <select name="board_extension" class="kkb-input" style="width:100%; max-width:100%">
            <option>킹콩보드 기본 게시판</option>
<?php
    $extensions = get_option("kingkongboard_extensions");
    if($extensions){
      $extensions = maybe_unserialize($extensions);
      foreach($extensions as $extension){
        if($board_extension == $extension['slug']){
          $extension_selected_class = "selected";
        } else {
          $extension_selected_class = null;
        }
?>
            <option value="<?php echo $extension['slug'];?>" <?php echo $extension_selected_class;?>><?php echo $extension['title'];?></option>
<?php        
      }
    }
?>
          </select>
        </td>
      </tr>
      <tr>
        <td><a href="?page=srshop"><?php echo __('보다 다양한 익스텐션을 찾으신다면 클릭하세요!', 'kingkongboard');?></a></td>
      </tr>
    </table>

<?php
  }
?>