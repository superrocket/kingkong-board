<?php
function KingkongBoard(){
?>

<div class="KingkongBoard-Wrap">
<input type="hidden" class="kingkongboard_plugins_url" value="<?php echo KINGKONGBOARD_PLUGINS_URL;?>">
<?php

  if(isset($_GET['view'])){
    $view = sanitize_text_field($_GET['view']);
  } else {
    $view = '';
  }

  if(isset($_GET['id'])){
    $board_id = sanitize_text_field($_GET['id']);
  } else {
    $board_id = null;
  }

  switch($view){
    case "create" :
      require_once (dirname(__FILE__).'/KingkongBoard-Create.php');
    break;

    case "modify" :
      require_once (dirname(__FILE__).'/KingkongBoard-Modify.php');
    break;

    case "entry" :
      require_once (dirname(__FILE__).'/KingkongBoard-Entries.php');
    break;

    case "entry-write" :
      require_once (dirname(__FILE__).'/KingkongBoard-Entry-Write.php');
    break;

    case "entry-view" :
      require_once (dirname(__FILE__).'/KingkongBoard-Entry-View.php');
    break;

    case "entry-reply" :
      require_once (dirname(__FILE__).'/KingkongBoard-Entry-Reply.php');
    break;

    case "recovery" :
      require_once (dirname(__FILE__).'/KingkongBoard-Recovery.php');
    break;

    case "recovery-upload" :
      require_once (dirname(__FILE__).'/KingkongBoard-Recovery-Upload.php');
    break;

    default :
      require_once (dirname(__FILE__).'/KingkongBoard-Index.php');
    break;
  }

?>
</div>
<div id="fb-root"></div>
<?php
}
?>