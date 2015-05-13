<?php

  class KingkongBoard {

    function __construct($BasicSettings){
      $this->board_name                 = $BasicSettings['board_name'];
      $this->board_slug                 = $BasicSettings['board_slug'];
      $this->board_shortcode            = $BasicSettings['board_shortcode'];
      $this->board_rows                 = $BasicSettings['board_rows'];
      $this->board_editor               = $BasicSettings['board_editor'];
      $this->board_search               = $BasicSettings['board_search'];
      $this->board_thumbnail_display    = $BasicSettings['board_thumbnail_display'];
      $this->board_thumbnail_input      = $BasicSettings['board_thumbnail_input'];

      add_action( 'init', array($this, 'Create_Board_Post_Type') );
    }

    public function CreateBoard(){
      $result           = array();

      if(!$this->board_name or !$this->board_slug){
        $result['status']   = 'error';
        $result['message']  = __('게시판 명과 슬러그는 반드시 기입하셔야 합니다.', 'kingkongboard');
      } else {

        if(preg_match('/[^a-z_]/', $this->board_slug)){
          $result['status']   = 'error';
          $result['message']  = __('슬러그는 영문 소문자와 언더바(_) 만 허용됩니다.', 'kingkongboard');
        } else {
          /* 커스텀 DB 를 집어넣는다. */
          $Board_ID = $this->KingkongBoard_Insert();

          if(is_wp_error($Board_ID)){
            $result['status']     = 'error';
            $result['message']    = __('게시판 신규 생성에 오류가 발생하였습니다.', 'kingkongboard');
          } else {

            update_post_meta( $Board_ID, 'kingkongboard_title', $this->board_name );
            update_post_meta( $Board_ID, 'kingkongboard_slug', $this->board_slug );
            update_post_meta( $Board_ID, 'kingkongboard_shortcode', $this->board_shortcode );
            update_post_meta( $Board_ID, 'kingkongboard_rows', $this->board_rows );
            update_post_meta( $Board_ID, 'kingkongboard_editor', $this->board_editor );
            update_post_meta( $Board_ID, 'kingkongboard_search', $this->board_search );
            update_post_meta( $Board_ID, 'kingkongboard_thumbnail_dp', $this->board_thumbnail_display );
            update_post_meta( $Board_ID, 'kingkongboard_thumbnail_input', $this->board_thumbnail_input );

            $origin_slugs = get_option("kingkongboard_slugs", true);

            $result['status']     = 'success';
            $result['message']    = __('정상적으로 등록 되었습니다.', 'kingkongboard');
            $result['board_id']   = $Board_ID;
            $this->board_id = $Board_ID;

          }
        }
      }

    return $result;

    }

    public function ModifyBoard($id){
      $result           = array();

      /* 커스텀 DB 를 집어넣는다. */
      $Board_ID = $this->KingkongBoard_Modify($id);

      if(is_wp_error($Board_ID)){
        $result['status']     = 'error';
        $result['message']    = __('게시판 수정에 오류가 발생하였습니다.', 'kingkongboard');
      } else {
        update_post_meta( $Board_ID, 'kingkongboard_title', $this->board_name );
        update_post_meta( $Board_ID, 'kingkongboard_rows', $this->board_rows );
        update_post_meta( $Board_ID, 'kingkongboard_editor', $this->board_editor );
        update_post_meta( $Board_ID, 'kingkongboard_search', $this->board_search );
        update_post_meta( $Board_ID, 'kingkongboard_thumbnail_dp', $this->board_thumbnail_display );
        update_post_meta( $Board_ID, 'kingkongboard_thumbnail_input', $this->board_thumbnail_input );
        $result['status']     = 'success';
        $result['message']    = __('정상적으로 수정 되었습니다.', 'kingkongboard');
      }
      $this->board_id = $Board_ID;
      return $result;
    }

    public function Create_Board_Post_Type(){
      if( !post_type_exists( "kkboard" ) ){
        register_post_type( "kkboard",
            array(
                'labels' => array(
                    'name' => $this->board_name
                ),
            'public' => false,
            'show_ui' => false,
            'show_in_menu' => false
            )
        );
      }
    }

    public function KingkongBoard_Modify($board_id){
        $Board = array();
        $Board = array(
          'ID'            => $board_id,
          'post_title'    => $this->board_name
        );

        $Board_Status = wp_update_post( $Board );

        return $Board_Status;
    }

    public function KingkongBoard_Insert(){
        $Board = array();
        $Board = array(
          'post_title'    => $this->board_name,
          'post_content'  => '',
          'post_status'   => 'publish',
          'post_type'     => 'kkboard',
          'post_author'   => 1
        );
        $Board_Status = wp_insert_post( $Board );

        do_action('kingkongboard_create_board_after', $Board_Status);
        
        return $Board_Status;
    }

    public function KingkongBoard_Slug($board_id){
      return $board_id;
    }

  }

?>