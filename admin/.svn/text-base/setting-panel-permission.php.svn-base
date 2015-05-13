<?php
  function KingkongBoard_Setting_Panel_Permission(){
    $roles = get_editable_roles();
    if(isset($_GET['id'])){
      $board_managers = get_post_meta(sanitize_text_field($_GET['id']), 'board_managers', true);
    } else {
      $board_managers = null;
    }
    $managers_value = '';
    if($board_managers){
      $board_managers = maybe_unserialize($board_managers);
      foreach($board_managers as $manager){
        $managers_value .= "<div class='each-manager-div'>".$manager."<div class='each-manager-remove'><img src='".KINGKONGBOARD_PLUGINS_URL."/assets/images/icon-close.png' style='width:12px; height:auto'></div><input type='hidden' name='board_manager[]' value='".$manager."'></div>";
      }
    }
?>

    <table>
      <tr>
        <th><?php echo __('관리자 추가', 'kingkongboard');?> :</th>
        <td>
          <input type="text" class="kkb-input manager-input" style="max-width:180px; width:100%">
          <button type="button" class="kkb-icon kkbblue button-add-manager"><i class="kkb-icon kkb-icon-plus" style="position:relative; top:3px"></i><?php echo __('추가하기', 'kingkongboard');?></button>
          <div class="description-container">
            <span class="description"><?php echo __('사용자 아이디를 입력하세요, 콤마(,)로 구분.', 'kingkongboard');?></span>
          </div>       
          <div class="kkb-read-role-box"><?php echo $managers_value;?></div>         
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <table>
            <tr>
              <th><?php echo __('User Role', 'kingkongboard');?></th>
              <th><?php echo __('읽기', 'kingkongboard');?></th>
              <th><?php echo __('쓰기', 'kingkongboard');?></th>
              <th><?php echo __('삭제', 'kingkongboard');?></th>
            </tr>
<?php

  if(isset($_GET['id'])){
    $board_id = sanitize_text_field($_GET['id']);
  } else {
    $board_id = null;
  }
  foreach( $roles as $role_name => $role_info ){
    if($board_id){
      $permission_read = get_kingkongboard_permission_read_by_role_name($board_id, $role_name);
      $permission_write = get_kingkongboard_permission_write_by_role_name($board_id, $role_name);
      $permission_delete = get_kingkongboard_permission_delete_by_role_name($board_id, $role_name);
    } else {
      $permission_read = "checked";
      $permission_write = "checked";
      $permission_delete = "checked";
    }
?>
            <tr>
              <td><?php echo $role_name;?></td>
              <td><input type="checkbox" name="permission_read[]" value="<?php echo $role_name;?>" <?php echo $permission_read;?>></td>
              <td><input type="checkbox" name="permission_write[]" value="<?php echo $role_name;?>" <?php echo $permission_write;?>></td>
              <td><input type="checkbox" name="permission_delete[]" value="<?php echo $role_name;?>" <?php echo $permission_delete;?>></td>
            </tr>            
<?php
  }
  if($board_id){
    $guest_permission_read = get_kingkongboard_permission_read_by_role_name($board_id, 'guest');
    $guest_permission_write = get_kingkongboard_permission_write_by_role_name($board_id, 'guest');
    $guest_permission_delete = get_kingkongboard_permission_delete_by_role_name($board_id, 'guest');
  } else {
    $guest_permission_read = "checked";
    $guest_permission_write = "checked";
    $guest_permission_delete = "checked";
  }
?>
            <tr>
              <td><?php echo __('비회원', 'kingkongboard');?></td>
              <td><input type="checkbox" name="permission_read[]" value="guest" <?php echo $guest_permission_read;?>></td>
              <td><input type="checkbox" name="permission_write[]" value="guest" <?php echo $guest_permission_write;?>></td>
              <td><input type="checkbox" name="permission_delete[]" value="guest" <?php echo $guest_permission_delete;?>></td>
            </tr>              
          </table>
        </td>
      </tr>
    </table>

<?php
  }
?>