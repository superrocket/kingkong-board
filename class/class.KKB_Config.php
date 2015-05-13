<?php
/**
 * 킹콩보드 워드프레스 게시판 관련 기본 세팅 값 클래스
 * @link www.superrocket.io
 * @copyright Copyright 2015 SuperRocket. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl.html
*/

class KKB_Config {

/**
 * 게시판 아이디를 넘겨 받아 해당 게시판의 기본 정보를 설정한다.
 * @param int $bid
*/
  function __construct($bid){
    global $wpdb;
    $this->meta_table         = $wpdb->prefix."kingkongboard_meta";
    $this->bid                = $bid;
    $this->pfx                = 'kkb_';
    $this->Oslug              = get_post_meta($this->bid, 'kingkongboard_slug', true);
    $this->board_slug         = $this->pfx.$this->Oslug;
    $this->board_rows         = get_post_meta($this->bid, 'kingkongboard_rows', true);
    $this->board_title        = get_post_meta($this->bid, 'kingkongboard_title', true);
    $this->board_shortcode    = get_post_meta($this->bid, 'kingkongboard_shortcode', true);
    $this->board_editor       = get_post_meta($this->bid, 'kingkongboard_editor', true);
    $this->search             = get_post_meta($this->bid, 'kingkongboard_search', true);
    $this->thumbnail_dp       = get_post_meta($this->bid, 'kingkongboard_thumbnail_dp', true);
    $this->thumbnail_input    = get_post_meta($this->bid, 'kingkongboard_thumbnail_input', true);
    $this->board_skin         = get_post_meta($this->bid, 'board_skin', true);
    $this->permission_read    = get_post_meta($this->bid, 'permission_read', true);
    $this->permission_write   = get_post_meta($this->bid, 'permission_write', true);
    $this->permission_delete  = get_post_meta($this->bid, 'permission_delete', true);
    $this->board_comment      = get_post_meta($this->bid, 'board_comment', true);
    $this->notice_emails      = get_post_meta($this->bid, 'kingkongboard_notice_emails', true);
    $this->comment_options    = get_post_meta($this->bid, 'kingkongboard_comment_options', true);
    $this->thumbnail_upload   = get_post_meta($this->bid, 'thumbnail_upload', true);
    $this->file_upload        = get_post_meta($this->bid, 'file_upload', true);
    $this->board_sections     = get_post_meta($this->bid, 'board_sections', true);
    $this->captcha_sitekey    = get_post_meta($this->bid, 'kkb_board_captcha_sitekey', true);
    $this->captcha_key        = get_post_meta($this->bid, 'board_captcha_key', true);
    $this->board_captcha      = get_post_meta($this->bid, 'board_captcha', true);
    $this->board_managers     = get_post_meta($this->bid, 'board_managers', true);
    $this->basic_form         = get_post_meta($this->bid, 'kkb_basic_form', true);
    $this->exclude_keyword    = get_post_meta($this->bid, 'kkb_exclude_keyword', true);
    $this->reply_use          = get_post_meta($this->bid, 'kkb_reply_use', true);
  }
  
}

?>