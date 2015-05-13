<?php

  class KKB_Latest extends KKB_List {

    function __construct($bid){
      $this->config      = new KKB_Config($bid);
      $this->entry_count = parent::kkb_get_list_count('all');
    }

    public function kkb_get_latest_list($number){
      $config  = $this->config;
      $Limit   = $number;
      $filters = "WHERE board_id = '".$config->bid."' AND type != 99 order by list_number ASC LIMIT ".$Limit;
      $results = KKB_Controller::get_kkb_meta_multiple($filters);
      return apply_filters('kingkongboard_latest_list_after', $results, $config, $number);
    }

  }

?>