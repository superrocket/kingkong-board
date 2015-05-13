<?php
  function KingkongBoard_Setting_Panel_Board_Style(){
    $content_url = WP_CONTENT_DIR;
    $path = $content_url."/kingkongboard/skins";
    $dirs = array_filter(glob($path . '/*' , GLOB_ONLYDIR), 'is_dir');
    if(isset($_GET['id'])){
      $board_id = sanitize_text_field($_GET['id']);
      $board_skin = get_post_meta($board_id, 'board_skin', true);
    } else {
      $board_skin = "basic";
    }
?>

    <table>
      <tr>
        <th><?php echo __('스타일 설정', 'kingkongboard');?>
          <div class="description-container">
            <span class="description"><?php echo __('기본 스타일은 킹콩보드 에서 기본적으로 제공하는 스킨을 뜻합니다.', 'kingkongboard');?></span>
          </div>                
        </th>
      </tr>
      <tr>
        <td>
          <div>
            <ul>
<?php
  if(($board_skin == "basic") or !isset($board_skin)){
    $basic_selected_class = "selected";
  } else {
    $basic_selected_class = null;
  }
?>
              <li class="each-skin-li <?php echo $basic_selected_class;?>" data="basic"><ul><li><img src="<?php echo KINGKONGBOARD_PLUGINS_URL;?>/assets/images/basic-thumbnail.png" style="width:120px; height:auto"></li><li><?php echo __('기본 스타일', 'kingkongboard');?></li></ul></li>
<?php
    $skins = get_option("kingkongboard_skins");
    if($skins){
      $skins = maybe_unserialize($skins);
      if($skins != false){
        foreach($skins as $skin){
          if($board_skin == $skin['slug']){
            $skin_selected_class = "selected";
          } else {
            $skin_selected_class = null;
          }
          echo "<li class='each-skin-li ".$skin_selected_class."' data='".$skin['slug']."'><ul><li><img src='".$skin['plugins_url']."/banner.png' style='width:120px; height:auto'></li><li>".$skin['title']."</li></ul><input type='hidden' class='board_skin_path'></li>";        
        }
      }
    }

?>
            </ul>
          </div>
          <div>
            <a href="?page=srshop">보다 다양한 스킨을 찾으신다면 클릭하세요!</a>
          </div>
          <input type="hidden" name="board_skin_slug" value="<?php echo $board_skin;?>">
        </td>
      </tr>
    </table>

<?php
  }
?>