<?php
/**
 * 킹콩보드 데이터 백업 및 복구
 * @link www.superrocket.io
 * @copyright Copyright 2015 SuperRocket. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl.html
 */

class KKB_Backup {

  public function __construct(){
    set_time_limit(0);
  }

  public function getTables(){
    global $wpdb;
    $tables = array();
    $tables_result = $wpdb->get_results('SHOW TABLES', ARRAY_N);
    foreach($tables_result as $table){
      if(stristr($table[0], $wpdb->prefix.'kingkongboard_')) $tables[] = $table[0];
    }
    return $tables;
  }

  public function getSql($table){
    global $wpdb;
    $result = $wpdb->get_results("SELECT * FROM `$table`", ARRAY_N);
    $sql = "TRUNCATE TABLE `$table`;\n";
    foreach($result as $row){
      $columns = count($row);
      $value   = array();
      $sql    .= "INSERT INTO `$table` VALUE (";
      for($i=0; $i<$columns; $i++){
        if($row[$i]) $value[] = "'$row[$i]'";
        else $value[] = "''";
      }
      $value = implode(',', $value);

      $sql  .= "$value);\n";
    }
    return $sql;
  }


  public function getXml($table){
    global $wpdb;
    $result = $wpdb->get_results("SELECT * FROM `$table`", ARRAY_A);
    $table  = str_replace($wpdb->prefix, '', $table);
    $xml = "<$table>\n";
    foreach($result as $row){
      $xml .= "\t<data>\n";
      $value = array();
      $attach_value = null;
      $secret_value = null;
      if($table == "kingkongboard_meta"){
        $board_id = $row['board_id'];
        $entry_id = $row['post_id'];
        $hits     = get_post_meta($entry_id, "kingkongboard_hits", true);
        $attached = get_post_meta($entry_id, "kingkongboard_attached", true);
        $password = get_post_meta($entry_id, "kingkongboard_entry_password", true);
        $secret   = get_post_meta($entry_id, "kingkongboard_secret", true);
        $thumb    = get_post_meta($entry_id, "_thumbnail_id", true);

        if($secret == "on"){
          $xml .= "\t\t<secret>";
          $xml .= "<![CDATA[".stripcslashes($secret)."]]>";
          $xml .= "</secret>\n";
        }

        if($thumb){
          $xml .= "\t\t<thumbnail>";
          $xml .= "<![CDATA[".stripcslashes($thumb)."]]>";
          $xml .= "</thumbnail>\n";
        }

        $xml .= "\t\t<hits>";
        $xml .= "<![CDATA[".stripslashes($hits)."]]>";
        $xml .= "</hits>\n";

        $xml .= "\t\t<attached>";
        $xml .= "<![CDATA[".stripslashes($attached)."]]>";
        $xml .= "</attached>\n";

      }
      foreach($row AS $key => $value){
        $xml .= "\t\t<$key>";
        $xml .= "<![CDATA[".stripslashes($value)."]]>";
        $xml .= "</$key>\n";
      }
      $xml .= "\t</data>\n";
    }
    $xml .= "</$table>\n";
   
    if($table == "kingkongboard_meta") {
      $Array_Boards = array();
      $Results      = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type = 'kkboard' ");
      if($Results){
        $post_xml   = "<kingkongboard_posts>\n";
        $board_meta_xml  = "<board_meta>\n";
        $board_xml  = "<board>\n";
        $comment_xml = "<comments>\n";
        foreach($Results as $Result){

          $board_xml .= "\t<data>\n";
          $value = array();
          foreach($Result as $key => $value){
            $board_xml .= "\t\t<$key>";
            $board_xml .= "<![CDATA[".stripslashes($value)."]]>";
            $board_xml .= "</$key>\n";
          }

          $board_xml .= "\t</data>\n";

          $Board = new KKB_Config($Result->ID);
          $board_meta_xml .= "\t<data>\n";

          $board_meta_xml .= "\t\t<board_id>";
          $board_meta_xml .= "<![CDATA[".$Result->ID."]]>";
          $board_meta_xml .= "</board_id>\n";

          $board_meta_xml .= "\t\t<title>";
          $board_meta_xml .= "<![CDATA[".$Board->board_title."]]>";
          $board_meta_xml .= "</title>\n";

          $board_meta_xml .= "\t\t<slug>";
          $board_meta_xml .= "<![CDATA[".$Board->board_slug."]]>";
          $board_meta_xml .= "</slug>\n";

          $board_meta_xml .= "\t\t<shortcode>";
          $board_meta_xml .= "<![CDATA[".$Board->board_shortcode."]]>";
          $board_meta_xml .= "</shortcode>\n";

          $board_meta_xml .= "\t\t<rows>";
          $board_meta_xml .= "<![CDATA[".$Board->board_rows."]]>";
          $board_meta_xml .= "</rows>\n";

          $board_meta_xml .= "\t\t<editor>";
          $board_meta_xml .= "<![CDATA[".$Board->board_editor."]]>";
          $board_meta_xml .= "</editor>\n";

          $board_meta_xml .= "\t\t<search_filter>";
          $board_meta_xml .= "<![CDATA[".$Board->search."]]>";
          $board_meta_xml .= "</search_filter>\n";

          $board_meta_xml .= "\t\t<thumbnail_dp>";
          $board_meta_xml .= "<![CDATA[".$Board->thumbnail_dp."]]>";
          $board_meta_xml .= "</thumbnail_dp>\n";

          $board_meta_xml .= "\t\t<thumbnail_input>";
          $board_meta_xml .= "<![CDATA[".$Board->thumbnail_input."]]>";
          $board_meta_xml .= "</thumbnail_input>\n";

          $board_meta_xml .= "\t\t<board_skin>";
          $board_meta_xml .= "<![CDATA[".$Board->board_skin."]]>";
          $board_meta_xml .= "</board_skin>\n";

          $board_meta_xml .= "\t\t<permission_read>";
          $board_meta_xml .= "<![CDATA[".$Board->permission_read."]]>";
          $board_meta_xml .= "</permission_read>\n";

          $board_meta_xml .= "\t\t<permission_write>";
          $board_meta_xml .= "<![CDATA[".$Board->permission_write."]]>";
          $board_meta_xml .= "</permission_write>\n";

          $board_meta_xml .= "\t\t<permission_delete>";
          $board_meta_xml .= "<![CDATA[".$Board->permission_delete."]]>";
          $board_meta_xml .= "</permission_delete>\n";

          $board_meta_xml .= "\t\t<board_comment>";
          $board_meta_xml .= "<![CDATA[".$Board->board_comment."]]>";
          $board_meta_xml .= "</board_comment>\n";

          $board_meta_xml .= "\t\t<notice_emails>";
          $board_meta_xml .= "<![CDATA[".$Board->notice_emails."]]>";
          $board_meta_xml .= "</notice_emails>\n";

          $board_meta_xml .= "\t\t<comment_options>";
          $board_meta_xml .= "<![CDATA[".$Board->comment_options."]]>";
          $board_meta_xml .= "</comment_options>\n";

          $board_meta_xml .= "\t\t<thumbnail_upload>";
          $board_meta_xml .= "<![CDATA[".$Board->thumbnail_upload."]]>";
          $board_meta_xml .= "</thumbnail_upload>\n";

          $board_meta_xml .= "\t\t<file_upload>";
          $board_meta_xml .= "<![CDATA[".$Board->file_upload."]]>";
          $board_meta_xml .= "</file_upload>\n";

          $board_meta_xml .= "\t\t<board_sections>";
          $board_meta_xml .= "<![CDATA[".$Board->board_sections."]]>";
          $board_meta_xml .= "</board_sections>\n";

          $board_meta_xml .= "\t\t<captcha_sitekey>";
          $board_meta_xml .= "<![CDATA[".$Board->captcha_sitekey."]]>";
          $board_meta_xml .= "</captcha_sitekey>\n";

          $board_meta_xml .= "\t\t<captcha_key>";
          $board_meta_xml .= "<![CDATA[".$Board->captcha_key."]]>";
          $board_meta_xml .= "</captcha_key>\n";

          $board_meta_xml .= "\t\t<captcha>";
          $board_meta_xml .= "<![CDATA[".$Board->board_captcha."]]>";
          $board_meta_xml .= "</captcha>\n";

          $board_meta_xml .= "\t\t<managers>";
          $board_meta_xml .= "<![CDATA[".$Board->board_managers."]]>";
          $board_meta_xml .= "</managers>\n";

          $board_meta_xml .= "\t\t<basic_form>";
          $board_meta_xml .= "<![CDATA[".$Board->basic_form."]]>";
          $board_meta_xml .= "</basic_form>\n";

          $board_meta_xml .= "\t\t<exclude_keyword>";
          $board_meta_xml .= "<![CDATA[".$Board->exclude_keyword."]]>";
          $board_meta_xml .= "</exclude_keyword>\n";

          $board_meta_xml .= "\t\t<reply_use>";
          $board_meta_xml .= "<![CDATA[".$Board->reply_use."]]>";
          $board_meta_xml .= "</reply_use>\n";

          $board_meta_xml .= "\t</data>\n";

          $posts    = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type = '".$Board->board_slug."' AND post_status = 'publish' ");
          foreach($posts as $each){
            $comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_post_ID = '".$each->ID."' ");
            if($comments){
              foreach($comments as $comment){
                $comment_xml .= "\t<data>\n";
                $value = array();
                foreach($comment as $cmt => $val){
                  $comment_xml .= "\t\t<$cmt>";
                  $comment_xml .= "<![CDATA[".stripslashes($val)."]]>";
                  $comment_xml .= "</$cmt>\n";
                }
                $comment_xml .= "\t</data>\n";
              }
            }

            $post_xml .= "\t<data>\n";
            $value = array();
            foreach($each as $key => $value){
              $post_xml .= "\t\t<$key>";
              $post_xml .= "<![CDATA[".stripslashes($value)."]]>";
              $post_xml .= "</$key>\n";
            }
              $post_xml .= "\t</data>\n";
          }
        }
        $post_xml .= "</kingkongboard_posts>\n";
        $board_meta_xml .= "</board_meta>\n";
        $board_xml .= "</board>\n";
        $comment_xml .= "</comments>\n";
      }  
    } else {
      $post_xml  = null;
      $board_xml = null;
      $board_meta_xml = null;
      $comment_xml = null;
    }   
    return $xml.$post_xml.$board_xml.$comment_xml.$board_meta_xml;
  }

  public function download($data, $file='xml', $filename=''){
    if(!$filename) $filename = 'KingkongBoard-Backup-'.date("YmdHis").'.'.$file;
    header("Content-Type: application/xml");
    header("Content-Disposition: attachment; filename=\"".$filename."\"");
    header("Pragma: no-cache");
    Header("Expires: 0");
    if($file == 'xml'){
      echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
      echo "<kingkongboard>\n";
      echo $data;
      echo "</kingkongboard>";
    }
    else{
      echo $data;
    }
    exit;
  }

  public function importEntryMeta($data){
    $entry_id = $data['entry_id'];
    foreach($data AS $key => $row){
      if( $row != '' && $key != 'entry_id'){
        update_post_meta($entry_id, $key, $row);
      }
    }
    return true;
  }

  public function importBoardMeta($data){
    $board_id = $data['board_id'];
    foreach($data AS $key => $row){
      if($row != '' && $key != 'board_id'){
        update_post_meta($board_id, $key, $row);
      }
    }
    return true;
  }

  public function importCommentMeta($data){
    global $wpdb;
    $columns   = array();
    $value     = array();
    $table = $wpdb->prefix."kingkongboard_comment_meta";
    foreach($data AS $key => $row){
      $row_count = count($row);
      $columns[] = $key;
      $value[]   = "'".addslashes($row)."'";
    }
      $columns = implode(",", $columns);
      $value   = implode(",", $value);
      $results = $wpdb->query("INSERT INTO `$table` ($columns) VALUE ($value)");
      if(!is_wp_error($results)){
        return true;
      } else {
        return false;
      }       
  }

  public function importComments($data){
    global $wpdb;
    $columns   = array();
    $value     = array();
    $table = $wpdb->prefix."comments";
    foreach($data AS $key => $row){
      $row_count = count($row);
      $columns[] = $key;
      $value[]   = "'".addslashes($row)."'";
    }
      $columns = implode(",", $columns);
      $value   = implode(",", $value);
      $results = $wpdb->query("INSERT INTO `$table` ($columns) VALUE ($value)");
      if(!is_wp_error($results)){
        return true;
      } else {
        return false;
      }    
  }

  public function importPosts($data){
    global $wpdb;
    $columns   = array();
    $value     = array();
    $table = $wpdb->prefix."posts";
    foreach($data AS $key => $row){
      $row_count = count($row);
      $columns[] = $key;
      $value[]   = "'".addslashes($row)."'";
    }
      $columns = implode(",", $columns);
      $value   = implode(",", $value);
      $results = $wpdb->query("INSERT INTO `$table` ($columns) VALUE ($value)");
      if(!is_wp_error($results)){
        return true;
      } else {
        return false;
      }
  }

  public function importKKBMeta($data){
    global $wpdb;
    $table = $wpdb->prefix."kingkongboard_meta";
    $columns   = array();
    $value     = array();
    foreach($data AS $key => $row){
      $columns[] = $key;
      $value[]   = "'".addslashes($row)."'";
    }
    $columns = implode(",", $columns);
    $value   = implode(",", $value);
    $results = $wpdb->query("INSERT INTO `$table` ($columns) VALUE ($value)");
    if(!is_wp_error($results)){
      return true;
    } else {
      return false;
    }
  }


  public function delete_all_kkb_posts(){
    global $wpdb;
    $error = array();
    $boards = $wpdb->get_results("SELECT ID from {$wpdb->prefix}posts WHERE post_type = 'kkboard' ");
    if($boards){
      foreach($boards as $board){
        $config = new KKB_Config($board->ID);
        $entry_post_type = $config->board_slug;
        $entries = $wpdb->get_results("SELECT ID from {$wpdb->prefix}posts WHERE post_type = '".$entry_post_type."' ");
        if($entries){
          foreach($entries as $entry){
            $this->delete_kkb_comments($entry->ID);
            $remove_status = wp_delete_post($entry->ID);
            if(is_wp_error($remove_status)){
              $error[] = $entry->ID;
            }
          }
        }
        $remove_status = wp_delete_post($board->ID);
        if(is_wp_error($remove_status)){
          $error[] = $board->ID;
        }
      }
    }
    if(count($error) > 0){
      return 1;
    } else {
      return 0;
    }
  }

  public function delete_all_kkb_meta(){
    global $wpdb;
    $meta_table     = $wpdb->prefix."kingkongboard_meta";   
    $result = $wpdb->query("TRUNCATE TABLE `$meta_table`");
    if(!is_wp_error($result)){
      return true;
    } else {
      return false;
    }
  }

  public function delete_all_kkb_comment_meta(){
    global $wpdb;
    $comment_table  = $wpdb->prefix."kingkongboard_comment_meta";
    $result = $wpdb->query("TRUNCATE TABLE `$comment_table`");
    if(!is_wp_error($result)){
      return true;
    } else {
      return false;
    }
  }

  public function delete_kkb_comments($entry_id){
    global $wpdb;
    $comments = $wpdb->get_results("SELECT comment_ID FROM {$wpdb->prefix}comments WHERE comment_post_ID = '".$entry_id."' ");
    if($comments){
      foreach($comments as $comment){
        wp_delete_comment($comment->comment_ID);
      }
    }
  }

}



?>