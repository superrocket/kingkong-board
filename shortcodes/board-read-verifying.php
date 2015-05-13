<?php

if(isset($_POST['view_type']) && isset($_POST['entry_id']) && isset($_POST['board_id'])){

    if(sanitize_text_field($_POST['view_type']) == "read"){
        if (file_exists(TEMPLATEPATH . '/' . "kingkongboard/board-read.php")) {
            require_once(TEMPLATEPATH . "/kingkongboard/board-read.php");
        } else {
            if( file_exists(WP_CONTENT_DIR . '/' . "kingkongboard/skins/".$board_skin."/board-read.php")){
                require_once(WP_CONTENT_DIR."/kingkongboard/skins/".$board_skin."/board-read.php");
            } else {
                require_once(KINGKONGBOARD_ABSPATH."/shortcodes/board-read.php");
            }
        }
    } else {
        $kkbContent .= __("잘못된 접근 입니다.", "kingkongboard");
    }

} else {

    if(isset($_GET['pageid'])){
        $pageid = sanitize_text_field($_GET['pageid']);
    } else {
        $pageid = 1;
    }

    switch(sanitize_text_field($_GET['view'])){
        case "read" :
            $input_text = __('비밀글 입니다. ', 'kingkongboard');
            $list_path  = add_query_arg( 'pageid', $pageid, get_the_permalink());
            $button     = '<div style="margin-top:10px"><a href="'.$list_path.'" class="'.kkb_button_classer($board_id).'">'.__('목록보기', 'kingkongboard').'</a></div>';
        break;

        case "delete" :
            $input_text = __('삭제 하시려면 ', 'kingkongboard');
            $view_path  = add_query_arg( array('pageid' => $pageid, 'view' => 'read', 'id' => $entry_id), get_the_permalink());
            $button     = '<div style="margin-top:10px"><a href="'.$view_path.'" class="'.kkb_button_classer($board_id).'">'.__('돌아가기', 'kingkongboard').'</a></div>';
        break;

        default :
            $input_text = null;
        break;
    }

        $verifyContent  = '<div>';
        $verifyContent .= $input_text.__('아래에 비밀번호를 입력 해 주시기 바랍니다.', 'kingkongboard');
        $verifyContent .= '</div>';
        $verifyContent .= '<form method="post" id="kingkongboard_verify_form">';
        $verifyContent .= '<div class="kingkongboard-read-verifying-wrapper">';
        $verifyContent .= '<table class="kingkongboard-read-verifying-table"><tr><td style="width:300px"><input type="password" name="kingkongboard-verifying-pwd" style="width:100%"></td><td style="padding-left:5px"><a  class="'.kkb_button_classer($board_id).' button-verify-submit" style="height:26px;">'.__('확인', 'kingkongboard').'</a></td></tr></table>';
        $verifyContent .= '</div>';
        $verifyContent .= '<input type="hidden" name="view_type" value="'.sanitize_text_field($_GET['view']).'">';
        $verifyContent .= '<input type="hidden" name="entry_id" value="'.$entry_id.'">';
        $verifyContent .= '<input type="hidden" name="board_id" value="'.$board_id.'">';
        $verifyContent .= '</form>';
        $list_path = add_query_arg( 'pageid', $pageid, get_the_permalink());
        $verifyContent .= $button;

        $kkbContent .= $verifyContent;    
}

?>