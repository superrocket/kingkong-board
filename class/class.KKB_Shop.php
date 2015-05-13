<?php

  if(class_exists('srShop')){ return false; }

  class srShop {

    public $host = "http://superrocket.io/API/shop/";

    public function getResponse($type = null){
      $response = wp_remote_post( 
        $this->host, 
        array(
        'method' => 'POST',
        'body' => array( 
          'type' => $type
          )
        )
      );
      if(!is_wp_error($response)){
        if($response['response']['code'] == 200){
          $response = $response['body'];
          $response = json_decode($response, true);
          return $response;
        } else {
          return false;
        }
      } else {
        return false;
      }
    }

    public function getDetail($product_id){
      $response = wp_remote_post( 
        $this->host, 
        array(
        'method' => 'POST',
        'body' => array( 
          'product_id' => $product_id
          )
        )
      );
      if(!is_wp_error($response)){
        if($response['response']['code'] == 200){
          $response = $response['body'];
          $response = json_decode($response, true);
          return $response;
        } else {
          return false;
        }
      } else {
        return false;
      }
    }

  }

?>