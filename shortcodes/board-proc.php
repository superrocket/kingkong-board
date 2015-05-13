<?php
  $board_id     = sanitize_text_field($_POST['board_id']);
  $post_id      = sanitize_text_field($_POST['post_id']);
  $cpt_response = sanitize_text_field($_POST['g-recaptcha-response']);
  $response     = kingkongboard_captcha_initialize($board_id, $cpt_response);

  if($response == false){
    //echo "<script>console.log('".$cpt_response."');</script>";
  } else {
    $Board      = new KKB_Controller($board_id);
    $entry_id   = $Board->kkb_entry_write($_POST, "front-end");
    if($entry_id){
      $upload   = $Board->kkb_entry_attach_upload($entry_id, $_POST, $_FILES);
      $kkbContent .= "<script>parent.location.href='".get_the_permalink($post_id)."';</script>";
    }
  }

?>