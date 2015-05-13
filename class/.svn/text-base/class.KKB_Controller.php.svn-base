<?php
/**
 * 킹콩보드 워드프레스 게시판 쓰기 및 수정 삭제 관련 컨트롤러
 * @link www.superrocket.io
 * @copyright Copyright 2015 SuperRocket. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl.html
*/

class KKB_Controller {

/**
 * 게시판 아이디를 넘겨 받아 config 클래스를 호출하여 해당 게시판의 기본 정보를 설정한다.
 * @param int $bid
*/
  function __construct($bid){
    $config            = new KKB_Config($bid);
    $entry_count       = count(get_posts( 'post_type='.$config->board_slug.'&posts_per_page=-1&post_status=publish' ));
    $this->config      = $config;
    $this->entry_count = $entry_count;
  }

  public function kkb_entry_count(){
    $entry_count = count(get_posts( 'post_type='.$this->config->board_slug.'&posts_per_page=-1&post_status=publish' ));
    return $entry_count;
  }

/**
 * data 값을 받아 글을 등록하는 함수
 * @param string $data
 * @return boolen
*/
  public function kkb_entry_write($data, $mode){
    $config         = $this->config;
    $entry_title    = $data['entry_title'];
    $entry_content  = $data['entry_content'];
    $entry_title    = kingkongboard_xssfilter(kingkongboard_htmlclear($entry_title));
    $entry_content  = kingkongboard_xssfilter(trim($entry_content));

    // 관리자 모드 글쓰기 등록이라면
    if( $mode == "admin" ){
      $post_date = $data['entry_ymd']." ".sprintf("%02d", $data['entry_h']).":".sprintf("%02d", $data['entry_i']).":".sprintf("%02d", $data['entry_s']);
      $entry = array(
        'post_title'    => $entry_title,
        'post_content'  => $entry_content,
        'post_date'     => $post_date,
        'post_status'   => 'publish',
        'post_type'     => $config->board_slug
      ); 
    } else {
      $entry = array(
        'post_title'    => $entry_title,
        'post_content'  => $entry_content,
        'post_status'   => 'publish',
        'post_type'     => $config->board_slug
      );
    }
    $entry_id = wp_insert_post($entry);

    if(!is_wp_error($entry_id)){
      // 포스트 메타 정보와 킹콩보드 메타 테이블에 정보 삽입
      $this->mode = $mode;
      $this->kkb_entry_write_meta($data, $entry_id);

      if( ! function_exists('wp_super_cache_clear_cache') ){
        $this->clear_cache();
      }
      // 게시글 저장 후 동작하는 액션 훅
      do_action('kingkongboard_entry_save_after', $config->bid, $entry_id);
      return $entry_id;
    }
  }

/**
 * 캐시 플러그인의 캐시를 삭제한다.
 * @return boolen
*/

  public function clear_cache(){
    global $cache_path;
    // WP-SUPER-CACHE
    if ( function_exists('prune_super_cache') ){
      prune_super_cache( $cache_path . 'supercache/', true);
      prune_super_cache( $cache_path, true);
    }
  }


/**
 * data 값을 받아 글을 수정하는 함수
 * @param string $data
 * @return boolen
*/

  public function kkb_entry_modify($data, $mode){
    $config         = $this->config;
    $entry_id       = kingkongboard_xssfilter(kingkongboard_htmlclear($data['entry_id']));
    $entry_title    = $data['entry_title'];
    $entry_content  = $data['entry_content'];
    $entry_title    = kingkongboard_xssfilter(kingkongboard_htmlclear($entry_title));
    $entry_content  = kingkongboard_xssfilter(trim($entry_content));
    $entry = array(
      'ID'            => $entry_id,
      'post_title'    => $entry_title,
      'post_content'  => $entry_content
    );

    $callback = wp_update_post( $entry );

    if(!is_wp_error($callback)){
      global $wpdb;
      if(isset($data['entry_notice'])){ 
        switch($data['entry_notice']){
          case "notice" :
            $wpdb->update(
              $config->meta_table,
              array( 'type'     => 1, 'section'  => $data['entry_section'] ),
              array( 'board_id' => $config->bid, 'post_id'  => $entry_id ),
              array( '%d', '%s' ),
              array( '%d', '%d' )
            );
          break;

          default :
            $wpdb->update(
              $config->meta_table,
              array( 'type'     => 0, 'section'  => $data['entry_section'] ),
              array( 'board_id' => $config->bid, 'post_id'  => $entry_id ),
              array( '%d', '%s' ),
              array( '%d', '%d' )
            );
          break;
        }
      } else {
        $wpdb->update(
          $config->meta_table,
          array( 'type'     => 0, 'section'  => $data['entry_section'] ),
          array( 'board_id' => $config->bid, 'post_id'  => $entry_id ),
          array( '%d', '%s' ),
          array( '%d', '%d' )
        );          
      }
      if(isset($data['entry_secret'])){
        update_post_meta($entry_id, 'kingkongboard_secret', 'on');
      } else {
        update_post_meta($entry_id, 'kingkongboard_secret', null);
      }

      $result = $entry_id;
    } else {
      $result = false;
    }
    
    if( ! function_exists('wp_super_cache_clear_cache') ){
      $this->clear_cache();
    }

    return $result;
  }
 

/**
 * entry_id 를 받아 해당 글을 삭제하고 반영한다.
 * @param int $entry_id
*/
  public function kkb_entry_delete($entry_id){
    $entry_id = kingkongboard_xssfilter(kingkongboard_htmlclear($entry_id));
    wp_delete_post($entry_id);
    $this->kkb_entry_remove_changer($entry_id);
  }

/**
 * 업로드시 파일명을 변경한다.
 * @param string $file
*/
  public function kkb_upload_filter($file){
    $random = rand(1000, 999);
    $filetype = wp_check_Filetype($file['name']);
    $file['name'] = 'kkb-'.date('YmdHis').$random.'.'.$filetype['ext'];
    return $file;
  }

/**
 * entry_id, $_FILES 를 받아 첨부파일을 업로드 한다.
 * @param int $entry_id, array $data
 * @return boolen
*/
  public function kkb_entry_attach_upload($entry_id, $data, $files){
      
      $config   = $this->config;
      $board_id = $config->bid;
 
      if( ! function_exists( 'wp_handle_upload' ) ){ require_once( ABSPATH . 'wp-admin/includes/file.php' ); }
      
      require_once( ABSPATH . 'wp-admin/includes/image.php' );

      add_filter( 'wp_handle_upload_prefilter', array(&$this, 'kkb_upload_filter'), 2);

      if($files['thumbnail_file']){
        do_action('kingkongboard_thumbnail_save_before', $board_id );
        $thumbnail = kingkongboard_reArrayFiles(kingkongboard_xssfilter($files['thumbnail_file']));
        for ($i=0; $i < count($thumbnail); $i++) { 
          if($thumbnail[$i]['name']){
            $uploadedfile = $thumbnail[$i];
            $upload_overrides = array( 'test_form' => false );
            $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
            if( $movefile ){
              $filename       = $movefile['file'];
              $parent_post_id = $entry_id;
              $filetype       = wp_check_filetype( basename($filename), null );
              $wp_upload_dir  = wp_upload_dir();
              $attachment     = array(
                'guid'            => $wp_upload_dir['url'] . '/' . basename( $filename ),
                'post_mime_type'  => $filetype['type'],
                'post_title'      => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
                'post_content'   => '',
                'post_status'    => 'inherit'
              );

              $thumbnail_id      = wp_insert_attachment( $attachment, $filename, $parent_post_id );
              // Generate the metadata for the attachment, and update the database record.
              if($thumbnail_id != 0){
                $attach_data = wp_generate_attachment_metadata( $thumbnail_id, $filename );
                wp_update_attachment_metadata( $thumbnail_id, $attach_data );
                set_post_thumbnail( $entry_id, $thumbnail_id);

                $term = term_exists($config->board_title, 'kkb_media_cat');
                if($term === 0 or $term === null){
                  $tag = wp_insert_term( $config->board_title, 'kkb_media_cat', array( 'slug' => $config->board_slug ) );
                  $term_id = array( $tag['term_id'] );
                  wp_set_post_terms($thumbnail_id, $term_id, 'kkb_media_cat');
                } else {
                  $term_id = array( $term['term_id'] );
                  wp_set_post_terms($thumbnail_id, $term_id, 'kkb_media_cat');
                }

              } else {
                // failed, make log file                
              }
            }
          }
        }
        if( !isset($data['entry_each_thumbnail']) && !$thumbnail_id ){
          delete_post_thumbnail($entry_id);
        }
      }

      if($files['entry_file']){
        add_filter('intermediate_image_sizes_advanced', array($this, 'kkb_upload_crop_remove') );
        $Files = kingkongboard_reArrayFiles(kingkongboard_xssfilter($files['entry_file']));
        $attached = array();

        for ($i=0; $i < count($Files); $i++) { 
          if($Files[$i]['name']){
            $uploadedfile = $Files[$i];
            $upload_overrides = array( 'test_form' => false );
            $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
            if( $movefile ){
              $filename       = $movefile['file'];
              $parent_post_id = $entry_id;
              $filetype       = wp_check_filetype( basename($filename), null );
              $wp_upload_dir  = wp_upload_dir();
              $attachment     = array(
                'guid'            => $wp_upload_dir['url'] . '/' . basename( $filename ),
                'post_mime_type'  => $filetype['type'],
                'post_title'      => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
                'post_content'   => '',
                'post_status'    => 'inherit'
              );

              $attach_id      = wp_insert_attachment( $attachment, $filename, $parent_post_id );
              // Generate the metadata for the attachment, and update the database record.
              $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
              wp_update_attachment_metadata( $attach_id, $attach_data );

              if(!is_wp_error($attach_id) && $attach_id != ""){

                $term = term_exists($config->board_title, 'kkb_media_cat');
                if($term === 0 or $term === null){
                  $tag = wp_insert_term( $config->board_title, 'kkb_media_cat', array( 'slug' => $config->board_slug ) );
                  $term_id = array( $tag['term_id'] );
                  wp_set_post_terms($attach_id, $term_id, 'kkb_media_cat');
                } else {
                  $term_id = array( $term['term_id'] );
                  wp_set_post_terms($attach_id, $term_id, 'kkb_media_cat');
                }

                $attached[]     = $attach_id;
              }
            }
          }
        }

        if( !isset($data['entry_each_attached_id']) && !$attach_id ){
          delete_post_meta($entry_id, 'kingkongboard_attached');
        } else {
          if(isset($data['entry_each_attached_id'])){
            $prevAttached = $data['entry_each_attached_id'];
            foreach($prevAttached as $eattach){
              $attached[] = $eattach;
            }
            update_post_meta($entry_id, 'kingkongboard_attached', serialize($attached) );
          } else {
            if($attach_id != ""){
              update_post_meta($entry_id, 'kingkongboard_attached', serialize($attached) );
            } else {
              delete_post_meta($entry_id, 'kingkongboard_attached');
            }
          }
        }
      } else {
        delete_post_meta($entry_id, 'kingkongboard_attached');
      }
  }

/**
 * 디폴트 크롭 이미지를 삭제한다.
 * @param string $data
 * @return boolen
*/
  public function kkb_upload_crop_remove( $sizes ){
    unset( $sizes['thumbnail']);
    unset( $sizes['medium']);
    unset( $sizes['large']);
    return $sizes;
  }

/**
 * entry_id (post_id) 를 받아 해당 글을 삭제한다.
 * @param string $data
 * @return boolen
*/
  public function kkb_entry_remove($entry_id){
    wp_delete_post($entry_id);
    $this->kkb_entry_remove_changer($entry_id);
  }

/**
 * data, entry_id 값을 받아 포스트 메타 정보를 업데이트 한다.
 * @param string $data, $entry_id
*/
  public function kkb_entry_write_meta($data, $entry_id){
    if($data && $entry_id){
      if(isset($data['entry_attachment'])){
        $entry_attachments = serialize($data['entry_attachment']);
        update_post_meta($entry_id, 'kingkongboard_attached', $entry_attachments);
      }
      if(isset($data['entry_password'])){
        $entry_secret = $data['entry_password'];
        $entry_secret = md5($entry_secret);
        update_post_meta($entry_id, 'kingkongboard_entry_password', $entry_secret);
      }
      if(isset($data['entry_secret'])){
        update_post_meta($entry_id, 'kingkongboard_secret', 'on');
      }
      $this->kkb_entry_write_kkbtable($data, $entry_id);
    } else {
      return kingkongboard_error_message("kkb_entry_write_meta");
    }
  }

/**
 * data, entry_id 값을 받아 킹콩보드 메타 테이블에 레코드를 삽입한다.
 * @param string $entry_id
 * @return boolen
*/
  public function kkb_entry_write_kkbtable($data, $entry_id){
    if($data && $entry_id){
      global $wpdb, $current_user;
      if(is_user_logged_in()){
        $user_id = $current_user->ID;
        $writer  = $current_user->display_name;
        if(isset($data['entry_writer'])){
          $writer  = $data['entry_writer'];
        }
      } else {
        $user_id = 0;
        $writer  = $data['entry_writer'];
      }
      $config = $this->config;
      $mktime = $this->kkb_entry_timetoMK($entry_id);
      $writer = kingkongboard_xssfilter(kingkongboard_htmlclear($writer));
      
      if( $this->mode == "admin" ){
        $guid = $data['entry_guid'];
      } else {
        $guid = $data['page_id'];
      }
      if(!isset($data['parent'])){
        $data['parent'] = $entry_id;
      }
      if(!isset($data['origin'])){
        $data['origin'] = $entry_id;
      }
      if(isset($data['entry_section'])){
        $entry_section = $data['entry_section'];
      } else {
        $entry_section = null;
      }

      $depth      = $this->get_kkb_entry_depth($data['origin']);
      $listNumber = 1;

      if(isset($data['entry_notice'])){
        switch($data['entry_notice']){
          case "notice" :
            $entry_type = 1;
          break;

          default :
            $entry_type = 0;
          break;
        }
      } else {
        $entry_type = 0;
      }

      $status = $wpdb->insert(
        $config->meta_table,
        array(
          'post_id'     => $entry_id,
          'section'     => $entry_section,
          'board_id'    => $config->bid,
          'related_id'  => $data['parent'],
          'list_number' => $listNumber,
          'depth'       => $depth,
          'parent'      => $data['origin'],
          'type'        => $entry_type,
          'date'        => $mktime,
          'guid'        => $guid,
          'login_id'    => $user_id,
          'writer'      => $writer
        ), 
        array( '%d','%s','%d','%d','%d','%d','%d','%d','%d','%d','%d','%s')
      );
      if(!is_wp_error($status)){
        $this->kkb_entry_list_changer($wpdb->insert_id, $data['origin']);
      }
    } else {
      return kingkongboard_error_message("kkb_entry_write_kkbtable");
    }
  }

/**
 * 올바른 글의 순서를 위해 등록글의 번호와 부모글의 리스팅 번호를 비교해 업데이트 해준다.
 * @param string $post_id, $parent
*/
  public function kkb_entry_list_changer($post_id, $parent){
    global $wpdb;
    $config       = $this->config;
    $filters      = "WHERE board_id = $config->bid AND ID != $post_id order by date ASC";
    $results      = $this->get_kkb_meta_multiple($filters);
    $parentDepth  = $this->get_kkb_entry_depth($parent);
    $lastRow      = "WHERE board_id = $config->bid AND ID = $post_id";
    $lastRst      = $this->get_kkb_meta_row($lastRow);

    if($lastRst){
      if($lastRst->depth > 1){
        $pNumber = $this->get_kkb_meta_list_number($lastRst->parent);
        $Upfilters = "WHERE board_id = $config->bid AND list_number > $pNumber";
        $Upresults = $this->get_kkb_meta_multiple($Upfilters);
        if($Upresults){
          foreach($Upresults as $Upresult){
            $this->update_kkb_meta_list_number($Upresult->ID, ($Upresult->list_number+1) );
          }
        }
        $this->update_kkb_meta_list_number($lastRst->ID, ($pNumber+1));
      } else {
        if($results){
          foreach($results as $result){
            $this->update_kkb_meta_list_number($result->ID, ($result->list_number+1) );
          }
        }
      }
    }
  }

/**
 * 킹콩보드 메타테이블의 해당글을 지움 처리 한다. (type 99)
 * @param $entry_id
*/
  public function kkb_entry_remove_changer($entry_id){
    global $wpdb;
    $config = $this->config;
    $wpdb->update(
      $config->meta_table,
      array( 'type' => 99 ),
      array( 'board_id' => $config->bid, 'post_id'  => $entry_id ),
      array( '%d' ),
      array( '%d','%d' )
    );
  }

/**
 * 킹콩보드 게시글 리스팅 넘버를 업데이트 한다.
 * @param int $id, $listNumber
*/
  public function update_kkb_meta_list_number($id, $listNumber){
    global $wpdb; 
    $config = $this->config;
    $wpdb->update(
      $config->meta_table,
      array( 'list_number' => $listNumber ),
      array( 'ID' => $id ),
      array( '%d' ),
      array( '%d' )
    );
  }

/**
 * 킹콩보드 리스팅 넘버를 불러온다.
 * @param int $post_id
 * @return $listNum
*/
  public function get_kkb_meta_list_number($post_id){
    global $wpdb;
    $filters = "WHERE post_id = '".$post_id."' ";
    $results = $this->get_kkb_meta_row($filters);
    if($results){
      $listNum = $results->list_number;
    }
    wp_reset_query();
    return $listNum;
  }

/**
 * 킹콩보드 메타테이블에서 filter 조건에 맞는 레코드를 불러온다. (복수)
 * @param string $filter
 * @return $mktime
*/
  public function get_kkb_meta_multiple($filter){
    global $wpdb;
    $config   = $this->config;
    $results  = null;
    $db_table = $config->meta_table;
    $results  = $wpdb->get_results("SELECT * FROM $db_table ".$filter);
    wp_reset_query();
    return $results;   
  }

/**
 * 킹콩보드 메타테이블에서 filter 조건에 맞는 레코드를 불러온다. (단수)
 * @param string $filter
 * @return $mktime
*/
  public function get_kkb_meta_row($filter){
    global $wpdb;
    $config   = $this->config;
    $results  = null;
    $db_table = $config->meta_table;
    $results  = $wpdb->get_row("SELECT * FROM $db_table ".$filter);
    wp_reset_query();
    return $results;      
  }

/**
 * 답변글이라면 origin 은 부모 글을 지칭하고 신규 글이라면 해당 글의 entry_id 가 된다.
 * @param string $origin
 * @return $mktime
*/
  public function get_kkb_entry_depth($origin){
    $filters = "WHERE post_id = '".$origin."'";
    $results = $this->get_kkb_meta_row($filters);
    if($results){
      $returnCount = ($results->depth)+1;
    } else {
      $returnCount = 1;
    }
    return $returnCount;    
  }

/**
 * entry_id 값을 받아 등록된 포스트의 작성일자를 MKTIME 으로 변환하여 반환한다.
 * @param string $entry_id
 * @return $mktime
*/
  public function kkb_entry_timetoMK($entry_id){
    if($entry_id){
      $WriteTimeH = get_the_date("H", $entry_id);
      $WriteTimei = get_the_date("i", $entry_id);
      $WriteTimes = get_the_date("s", $entry_id);
      $WriteTimen = get_the_date("n", $entry_id);
      $WriteTimej = get_the_date("j", $entry_id);
      $WriteTimeY = get_the_date("Y", $entry_id);
      $TimetoMk   = mktime($WriteTimeH, $WriteTimei, $WriteTimes, $WriteTimen, $WriteTimej, $WriteTimeY);
      return $TimetoMk;
    } else {
      return false;
    }
  }
}

?>