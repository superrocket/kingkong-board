<?php
  function KingkongBoard_Setting_Panel_Section(){

    do_action('kingkongboard_setting_panel_section_before');

  }

  add_action('kingkongboard_setting_panel_section_before', 'kingkongboard_default_setting_panel_section');

  function kingkongboard_default_setting_panel_section(){
    $board_sections = null;
    $board_id       = null;
    $section_value  = null;
    if(isset($_GET['id'])){
      $board_id = sanitize_text_field($_GET['id']);
      $board_sections = get_post_meta($board_id, 'board_sections', true);
      if($board_sections){
        $board_sections = unserialize($board_sections);
      }
      if($board_sections){
        foreach($board_sections as $section){
          $section_value .= "<div class='each-manager-div'>".$section."<div class='each-manager-remove'><img src='".KINGKONGBOARD_PLUGINS_URL."/assets/images/icon-close.png' style='width:12px; height:auto'></div><input type='hidden' name='board_section[]' value='".$section."'></div>";
        }
      }
    }
?>
  <table class="setting_panel_section_table">
    <tr>
      <th><?php echo __('분류지정', 'kingkongboard');?> :</th>
      <td>
        <input type="text" class="kkb-input kkb-input-section" style="max-width:180px; width:100%">
        <button type="button" class="kkb-icon kkbblue kkb-button-section">
          <i class="kkb-icon kkb-icon-plus" style="position:relative; top:3px"></i>
            <?php echo __('추가하기', 'kingkongboard');?>
        </button>
        <div class="description-container">
          <span class="description"><?php echo __('분류를 기입하세요. 여러개의 분류 기입시 콤마(,)로 분리 됩니다. 분류를 사용하지 않으려면 공백으로 비워 두시면 됩니다.', 'kingkongboard');?></span>
        </div>
        <div class="kkb-read-role-box"><?php echo $section_value;?></div>
      </td>
    </tr>
  </table>
<?php
  }
?>