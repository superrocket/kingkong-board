<?php

	class KKB_List extends KKB_Controller{
    function __construct($bid){
      $this->config      = new KKB_Config($bid);
      $this->entry_count = $this->kkb_get_list_count('all');
    }

    public function kkb_get_basic_list($page){
      $config = $this->config;
      if(empty($page)){
        $page == 1;
      }
      if($page == 1){
        $Limit = "LIMIT 0, ".$config->board_rows;
      } else {
        $Limit = "LIMIT ".(($page * $config->board_rows) - $config->board_rows ).", ".$config->board_rows;
      }
      $where   = apply_filters('kkb_get_basic_list_where', null, $config->bid);
      $filters = apply_filters('kkb_get_basic_list_filter', "WHERE board_id = '".$config->bid."' AND type = 0 ".$where." order by list_number ASC ".$Limit, $config->bid);
      $results = parent::get_kkb_meta_multiple($filters);
      return $results;
    }

    public function kkb_get_notice_list(){
      $config  = $this->config;
      $filters = "WHERE board_id = '".$config->bid."' AND type = 1";
      $results = parent::get_kkb_meta_multiple($filters);
      return $results;      
    }

    public function kkb_entry_delete($entry_id){
      return parent::kkb_entry_delete($entry_id);
    }

/**
 * 해당 게시판 게시글 수 
 * @param $type
 * @return $results
*/
    public function kkb_get_list_count($type){
      $config = $this->config;
      switch($type){
        case 'basic' :
          $filters = "WHERE board_id = '".$config->bid."' and type = 0 and type != 99";
        break;
        case 'notice' :
          $filters = "WHERE board_id = '".$config->bid."' and type = 1 and type != 99";
        break;
        case 'all' :
        default :
          $filters = "WHERE board_id = '".$config->bid."' and type != 99";
        break;
      }
      $config  = $this->config;
      $results = count(parent::get_kkb_meta_multiple($filters));
      return $results;
    }

    public function kkb_pagination(){
      $config = $this->config;
      $where  = apply_filters('kkb_pagination_where', null, $config->bid);
      $filters = "WHERE board_id = '".$config->bid."' and (type != 1  and type != 99) ".$where;
      $total   = count(parent::get_kkb_meta_multiple($filters));
      if($total > 0){
        $pages   = $total / $config->board_rows;
        $pages   = ceil($pages);
      } else {
        $pages   = 0;
      }
      return $pages;
    }

    public function kkb_get_search_list($post, $page){
      global $wpdb;
      $config = $this->config;
      if(!$page){
        $page = 1;
      }
      if($page == 1){
        $Limit = "LIMIT 0, ".$config->board_rows;
      } else {
        $Limit = "LIMIT ".(($page * $config->board_rows) - $config->board_rows ).", ".$config->board_rows;
      }

      $where  = apply_filters('kkb_search_list_where', null, $config->bid);

      if(isset($post['kkb_search_keyword'])){
        $keyword = kingkongboard_xssfilter(kingkongboard_htmlclear($post['kkb_search_keyword']));
        $results    = $wpdb->get_results("SELECT ID FROM ".$wpdb->posts." WHERE (post_type = '".$config->board_slug."' AND post_status = 'publish') AND (post_title like '%".$keyword."%' or post_content like '%".$keyword."%')");
        $search_id  = array();
        foreach($results as $result){
          $search_id[] = $result->ID;
        }

        if(count($results) > 0 ){
          $search_array = join(',',$search_id);

          if(isset($post['kkb_search_section'])){
            $section = kingkongboard_xssfilter(kingkongboard_htmlclear($post['kkb_search_section']));
            if($post['kkb_search_section'] != "all"){
              $filters = "WHERE board_id = '".$config->bid."' AND type = 0 AND section = '".$section."' AND post_id IN (".$search_array.") order by list_number ASC ".$Limit;
            } else {
              $filters = "WHERE board_id = '".$config->bid."' AND type = 0 ".$where." AND post_id IN (".$search_array.") order by list_number ASC ".$Limit;          
            }
          } else {
            $filters = "WHERE board_id = '".$config->bid."' AND type = 0 ".$where." AND post_id IN (".$search_array.") order by list_number ASC ".$Limit;          
          }
          $values = parent::get_kkb_meta_multiple($filters);
        } else {
          $values = null;
        }
      } else {
        if(isset($post['kkb_search_section'])){
          $section = kingkongboard_xssfilter(kingkongboard_htmlclear($post['kkb_search_section']));
          if($post['kkb_search_section'] != "all"){
            $filters = "WHERE board_id = '".$config->bid."' AND type = 0 AND section = '".$section."' order by list_number ASC ".$Limit;
          } else {
            $filters = "WHERE board_id = '".$config->bid."' ".$where." AND type = 0 order by list_number ASC ".$Limit;        
          }
        } else {
          $filters = "WHERE board_id = '".$config->bid."' ".$where." AND type = 0 order by list_number ASC ".$Limit;   
        }
        $values = parent::get_kkb_meta_multiple($filters);
      }
      return $values;  
    }

    public function kkb_get_search_count($post){
      global $wpdb;
      $config = $this->config;
      if(isset($post['kkb_search_keyword'])){
        $keyword = kingkongboard_xssfilter(kingkongboard_htmlclear($post['kkb_search_keyword']));
        $results    = $wpdb->get_results("SELECT ID FROM ".$wpdb->posts." WHERE post_type = '".$config->board_slug."' AND (post_title like '%".$keyword."%' or post_content like '%".$keyword."%')");
        $search_id  = array();
        foreach($results as $result){
          $search_id[] = $result->ID;
        }

        
        if($results){
          $search_array = join(',',$search_id);
          if(isset($post['kkb_search_section'])){
            $section = kingkongboard_xssfilter(kingkongboard_htmlclear($post['kkb_search_section']));
            if($post['kkb_search_section'] != "all"){
              $filters = "WHERE board_id = '".$config->bid."' AND type = 0 AND section = '".$section."' AND post_id IN ($search_array) order by list_number ASC";
            } else {
              $filters = "WHERE board_id = '".$config->bid."' AND type = 0 AND post_id IN ($search_array) order by list_number ASC ";          
            }
          } else {
            $filters = "WHERE board_id = '".$config->bid."' AND type = 0 AND post_id IN ($search_array) order by list_number ASC ";  
          }
          $values = parent::get_kkb_meta_multiple($filters);
        } else {
          $values = 0;
        }
      } else {

        if(isset($post['kkb_search_section'])){
          $section = kingkongboard_xssfilter(kingkongboard_htmlclear($post['kkb_search_section']));
          if($post['kkb_search_section'] != "all"){
            $filters = "WHERE board_id = '".$config->bid."' AND type = 0 AND section = '".$section."' order by list_number ASC ";
          } else {
            $filters = "WHERE board_id = '".$config->bid."' AND type = 0 order by list_number ASC ";        
          }
        } else {
          $filters = "WHERE board_id = '".$config->bid."' AND type = 0 order by list_number ASC ";        
        }
        $values = parent::get_kkb_meta_multiple($filters);
      }   
      return count($values);      
    }

    public function kkb_search_pagination($post){
      $config  = $this->config;
      $total   = $this->kkb_get_search_count($post);
      if($total > 0){
        $pages = $total / $config->board_rows;
        $pages = ceil($pages);
      } else {
        $pages = 0;
      }
      return $pages;
    }

	}

?>