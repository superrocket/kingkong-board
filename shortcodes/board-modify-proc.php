<?php

  $board_id = sanitize_text_field($_POST['board_id']);
  $post_id  = sanitize_text_field($_POST['post_id']);
  $Board    = new KKB_Controller($board_id);
  $entry_id = $Board->kkb_entry_modify($_POST, "front-end");

  if($entry_id){
    wp_reset_postdata();
    $upload = $Board->kkb_entry_attach_upload($entry_id, $_POST, $_FILES);
    $kkbContent .= "<script>parent.location.href='".get_the_permalink($post_id)."';</script>";
  }

?>