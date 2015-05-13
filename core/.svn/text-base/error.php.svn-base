<?php

function kingkongboard_error_message($type){
  $return_text = null;
  if($type){
    switch($type){
      case "title_empty" :
        $return_text = __('제목을 기입하시기 바랍니다.', 'kingkongboard');
      break;

      case "writer_empty" :
        $return_text = __('작성자명을 기입하시기 바랍니다.', 'kingkongboard');
      break;

      case "password_empty" :
        $return_text = __('비밀번호를 기입하시기 바랍니다.', 'kingkongboard');
      break;

      case "email_empty" :
        $return_text = __('이메일을 기입하시기 바랍니다.', 'kingkongboard');
      break;

      case "email_not_valid" :
        $return_text = __('이메일 형식이 올바르지 않습니다.', 'kingkongboard');
      break;

      case "content_empty" :
        $return_text = __('내용을 기입하시기 바랍니다.', 'kingkongboard');
      break;

      case "modify_just_writer" :
        $return_text = __('작성자 본인만 수정하실 수 있습니다.', 'kingkongboard');
      break;

      case "password_not_equal" :
        $return_text = __('비밀번호가 일치하지 않습니다.', 'kingkongboard');
      break;

      case "kkb_entry_write_meta" :
        $return_text = __('KKB_Controller 클래스의 kkb_entry_write_meta 함수에 data 값과 id 값이 없거나 올바르지 않습니다.', 'kingkongboard');
      break;

      case "kkb_entry_write_kkbtable" :
        $return_text = __('KKB Controller 클래스의 kkb_entry_write_kkbtable 함수에 data 값과 id 값이 없거나 올바르지 않습니다.', 'kingkongboard');
      break;
    }

    $return_text = apply_filters("kingkongboard_error_message", $return_text, $type);

    return $return_text;

  } else {
    return false;
  }
}

?>