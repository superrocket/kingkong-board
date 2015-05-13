<?php

  class KKB_Comments {

    function __construct(){
      global $wpdb;
      $this->table = $wpdb->prefix."kingkongboard_comment_meta";
    }

    public function kkb_get_comment_list($entry_id){
      global $wpdb;
      $table = $this->table;
      $results = $wpdb->get_results('SELECT * FROM '.$table.' WHERE eid = '.$entry_id.' order by lnumber DESC');
      if($results){
        return apply_filters('kkb_get_comment_list_before', $results, $entry_id);
      } else {
        return false;
      }
    }

    public function kkb_get_comment_count($entry_id){
      global $wpdb;
      $table = $this->table;
      $count = $wpdb->get_var('SELECT COUNT(*) FROM '.$table.' WHERE eid = '.$entry_id.' order by lnumber DESC');
      return $count;
    }

    public function kkb_comment_save($data){

      $content        = kingkongboard_xssfilter(kingkongboard_htmlclear($data['content']));
      $entry_id       = kingkongboard_xssfilter(kingkongboard_htmlclear($data['entry_id']));
      $comment_parent = kingkongboard_xssfilter(kingkongboard_htmlclear($data['comment_parent']));

      if($comment_parent){
        $parent   = $comment_parent;
      } else {
        $parent   = 0;
      }

      if(is_user_logged_in()){
        global $current_user;
        get_currentuserinfo();
        $writer   = $current_user->display_name;
        $email    = $current_user->user_email;
        $user_id  = $current_user->ID;
      } else {
        $writer   = kingkongboard_xssfilter(kingkongboard_htmlclear($data['writer']));
        $email    = kingkongboard_xssfilter(kingkongboard_htmlclear($data['email']));
        $user_id  = 0;
      }

      if( !empty($data['comment_origin']) ){
        $origin = sanitize_text_field($data['comment_origin']);
      } else {
        $origin = 0;
      }

      if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
          $ip = $_SERVER['HTTP_CLIENT_IP'];
      } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
          $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
      } else {
          $ip = $_SERVER['REMOTE_ADDR'];
      }

      $time = current_time('mysql');

      $comment = array(
          'comment_post_ID' => $entry_id,
          'comment_author' => $writer,
          'comment_author_email' => $email,
          'comment_author_url' => '',
          'comment_content' => $content,
          'comment_type' => '',
          'comment_parent' => $parent,
          'user_id' => $user_id,
          'comment_author_IP' => $ip,
          'comment_agent' => $_SERVER['HTTP_USER_AGENT'],
          'comment_date' => $time,
          'comment_approved' => 1,
      );

      $comment_id = wp_insert_comment($comment);
      
      if(!is_wp_error($comment_id)){

        $parent_depth  = $this->kkb_get_comment_meta($comment_parent, 'depth');
        $parent_origin = $this->kkb_get_comment_meta($comment_parent, 'origin');

        if(!$parent_depth){
          $parent_depth = 0;
        }

        if($parent_origin){
          if( $parent_origin == $comment_parent ){
            $origin = $comment_parent;
          } else {
            $origin = $parent_origin;
          }
        } else {
          $origin = $comment_id;
        }

        $input_meta = array(
          'lnumber' => 1,
          'eid'     => $entry_id,
          'cid'     => $comment_id,
          'origin'  => $origin,
          'parent'  => $comment_parent,
          'depth'   => ($parent_depth + 1)
        );

        $this->kkb_update_comment_meta($input_meta);
        do_action('kingkongboard_save_comment_after', $entry_id, $comment_id, $content);
      }

    }

    public function kkb_get_comment_meta($comment_id, $key){
      if($comment_id && $key){
        global $wpdb;
        $table = $this->table;
        $result = $wpdb->get_row('SELECT '.$key.' FROM '.$table.' WHERE cid = '.$comment_id );
        if($result){
          return $result->$key;
        } else {
          return false;
        }
      } else {
        return false;
      }
    }

    public function kkb_update_comment_meta($data){
      global $wpdb;
      if($this->kkb_get_comment_meta($data['cid'], 'ID') == true){
        $wpdb->update(
          $this->table,
          array(
            'lnumber' => 1,
            'eid'     => $data['eid'],
            'cid'     => $data['cid'],
            'origin'  => $data['origin'],
            'parent'  => $data['parent'],
            'depth'   => $data['depth']
          ),
          array( 'ID' => $this->kkb_get_comment_meta($data['cid'], 'ID') ),
          array( '%d', '%d', '%d', '%d', '%d', '%d' ),
          array( '%d' )
        );
      } else {
        $wpdb->insert(
          $this->table,
          array(
            'lnumber' => 1,
            'eid'     => $data['eid'],
            'cid'     => $data['cid'],
            'origin'  => $data['origin'],
            'parent'  => $data['parent'],
            'depth'   => $data['depth']
          ),
          array( '%d', '%d', '%d', '%d', '%d', '%d' )
        );
        $this->kkb_comment_lnumber_changer($data['eid'], $data['parent'], $wpdb->insert_id);
      }
    }

    public function kkb_comment_lnumber_changer($entry_id, $parent, $ID){
      global $wpdb;
      $filters      = "WHERE eid = ".$entry_id." AND ID != ".$ID;
      $results      = $wpdb->get_results("SELECT * FROM ".$this->table." ".$filters);
      $lastRow      = "WHERE eid = ".$entry_id." AND ID = ".$ID;
      $lastRst      = $wpdb->get_row("SELECT * FROM ".$this->table." ".$lastRow);

      if($lastRst){
        if($lastRst->depth > 1){
          $pNumber = $this->kkb_get_comment_meta($lastRst->parent, 'lnumber');
          if($pNumber){
            $Upfilters = "WHERE eid = ".$entry_id." AND lnumber >= ".$pNumber;
            $Upresults = $wpdb->get_results("SELECT * FROM ".$this->table." ".$Upfilters);
            if($Upresults){
              foreach($Upresults as $Upresult){
                $this->kkb_comment_lnumber_update($Upresult->ID, ($Upresult->lnumber+1) );
              }
            }
            $ed_filters = "WHERE eid = ".$entry_id." AND parent = ".$lastRst->parent." AND depth = ".$lastRst->depth;
            $ed_results = $wpdb->get_results("SELECT * FROM ".$this->table." ".$ed_filters);
            if(count($ed_results) > 1){
              foreach($ed_results as $ed_result){
                if($ed_result->ID == $lastRst->ID){
                  $this->kkb_comment_lnumber_update($lastRst->ID, ($pNumber - (count($ed_results)-1)));
                } else {
                  $this->kkb_comment_lnumber_update($ed_result->ID, ($ed_result->lnumber + 1));
                }
              }
            } else {
              $this->kkb_comment_lnumber_update($lastRst->ID, ($pNumber));
            }
          }
        } else {
          if($results){
            foreach($results as $result){
              $this->kkb_comment_lnumber_update($result->ID, ($result->lnumber+1) );
            }
          }
        }
      }
    }

    public function kkb_comment_lnumber_update($ID, $number){
      global $wpdb;
      $wpdb->update(
        $this->table,
        array(
          'lnumber' => $number
        ),
        array( 'ID' => $ID ),
        array( '%d' ),
        array( '%d' )
      );        
    }

    public function kkb_comment_depth_padding($depth){

      $depth_padding = apply_filters("kingkongboard_comment_depth_padding", 15);

      switch($depth){
        case 1 :
          $padding = 0;
        break;
        case 2 :
          $padding = 1*$depth_padding;
        break;

        case 3 :
          $padding = 2*$depth_padding;
        break;

        case 4 :
          $padding = 3*$depth_padding;
        break;

        case 5 :
          $padding = 4*$depth_padding;
        break;

        default :
          $padding = 5*$depth_padding;
        break;
      }
      return $padding;
    }

    public function kkb_comment_display($entry_id, $comments){

      $board_id        = get_board_id_by_entry_id($entry_id);
      $comment_options = get_post_meta($board_id, 'kingkongboard_comment_options', true);
      $comment_options = maybe_unserialize($comment_options);
      $comment_result  = null;
      $depth_padding   = null;

      if($comments){
        foreach($comments as $cmmt){
          $depth   = $cmmt->depth;
          if($depth > 1){
            $depth_padding = "padding-left:".$this->kkb_comment_depth_padding($depth)."px";
            $depth_div     = '<div style="float:left"><img src="'.KINGKONGBOARD_PLUGINS_URL.'/assets/images/icon-comment-reply.png" style="height:16px; width:auto"></div>';
          } else {
            $depth_padding = null;
            $depth_div     = null;
          }
          $comment = get_comment($cmmt->cid);
          apply_filters('kingkongboard_comment_list_before', $board_id, $comment);
          if($comment->comment_approved == 1){
            $comment_result .= '<div id="comment-'.$comment->comment_ID.'" class="each-comment comment-'.$comment->comment_ID.'" style="'.$depth_padding.'">';
            $comment_result .= $depth_div;
            $comment_result .= '<div>';
            $comment_result .= '<div class="each-comment-author">';
            $comment_result .= '<table class="comment-author-table">';
            $comment_result .= '<tr>';
            if($comment_options['thumbnail'] == "T"){
              $comment_result .= '<td width="30px">';
              $comment_result .= get_avatar($comment->comment_author_email, '20');
              $comment_result .= '</td>';
            }
            $comment_result .= '<td style="font-weight:'.$comment_options['writer']['font_weight'].'; font-size:'.$comment_options['writer']['font_size'].'; color:'.$comment_options['writer']['color'].'">';
            $comment_result .= $comment->comment_author;
            $comment_result .= '</td>';
            $comment_result .= '<td class="comment-author-date" style="color:'.$comment_options['date']['color'].'">';
            $comment_result .= get_comment_date( $comment_options['date']['format'], $comment->comment_ID);
            $comment_result .= '</td>';
            $comment_result .= '<td style="position:relative">';
            $comment_result .= '<img src="'.KINGKONGBOARD_PLUGINS_URL.'/assets/images/icon-comment-reply.png" class="icon-comment-reply">';
            $comment_result .= '<a class="comment-reply-button" data-origin="'.$cmmt->origin.'" data="'.$comment->comment_ID.'">'.__('답글', 'kingkongboard').'</a>';
            $comment_result .= '</td>';
            $comment_result .= '</tr>';
            $comment_result .= '</table>';
            $comment_result .= '</div>';

            $comment_content_before = apply_filters('kingkongboard_comment_content_before', $entry_id, $comment->comment_ID);
            if($comment_content_before != $entry_id){
              $comment_result .= $comment_content_before;
            }
            $comment_result .= '<div class="each-comment-content" style="color:'.$comment_options['content']['color'].'">';
            $comment_result .= nl2br($comment->comment_content)."<br>";
            $comment_result .= '</div>';
            $comment_result .= '</div>';

            $comment_after = apply_filters('kingkongboard_comment_after', $board_id, $entry_id, $comment->comment_ID );
            if($comment_after != $board_id){
              $comment_result .= $comment_after;
            }

            $comment_result .= '</div>';
          }
        } // end foreach
        return apply_filters('kkb_comment_display_after', $comment_result, $entry_id, $comments);
      } else {
        return false;
      }    
    }

  }

?>