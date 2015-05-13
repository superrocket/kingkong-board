<?php
  function srshop(){
    $srShop   = new srShop;
    $items    = $srShop->getResponse();
?>
  <div class="srshop-modal-wrapper" style="display:none; position:fixed; top:0; left:0; z-index:9999; width:100%; height:100%">
    <div class="srshop-modal-background" style="background:#000; opacity:0.7; z-index:999; width:100%; height:100%;"></div>
    <div class="srshop-modal-loading" style="position:fixed; z-index:9999; top:50%"><img src="<?php echo KINGKONGBOARD_PLUGINS_URL;?>/assets/images/ajax-loader2.gif"></div>
    <div class="srshop-modal-content" style="max-width:80%; width:800px; height:70%; min-height:500px; position:fixed; top:15%; z-index:9999; background:#fff; padding:10px 10px; overflow-y:auto; overflow-x:hidden">
      <div class="srshop-detail-wrapper">
        <table>
          <tr>
            <td class="detail-thumbnail"></td>
            <td class="detail-info">
              <div class="detail-info-title"></div>
              <div class="detail-info-description"></div>
              <div class="detail-info-version"></div>
              <div class="detail-info-price"></div>
              <div class="detail-info-button"></div>
            </td>
          </tr>
          <tr>
            <td colspan="2"><hr></td>
          </tr>
          <tr>
            <td colspan="2" class="detail-content"></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <div class="KingkongBoard-Wrap" style="padding-bottom:0px">
    <div class="notice-toolbox-wrapper"></div>
    <div class="head-area">
      <div style="float:left; position:relative; top:-10px; margin-right:10px">
        <h2>킹콩마트</h2>
        <small style="position:relative; top:-13px">킹콩보드의 기능을 보다 다양하게 확장 할 수 있습니다. 다양한 익스텐션을 만나보세요~! 줄줄이 출시 됩니다~!</small>
      </div>
      <div style="float:right; position:relative; top:8px">
        <div class="fb-like" data-href="https://facebook.com/superrocketer" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true" style="position:relative; top:-10px; margin-right:10px"></div>
        <a href="http://superrocket.io" target="_blank"><img src="<?php echo KINGKONGBOARD_PLUGINS_URL;?>/assets/images/superrocket-symbol.png" style="height:34px; width:auto" class="superrocket-logo" alt="superrocket.io"></a>
        <a href="https://www.facebook.com/superrocketer" target="_blank"><img src="<?php echo KINGKONGBOARD_PLUGINS_URL;?>/assets/images/icon-facebook.png" style="height:34px; width:auto" class="superrocket-logo" alt="facebook"></a>
        <a href="https://instagram.com/superrocketer/" target="_blank"><img src="<?php echo KINGKONGBOARD_PLUGINS_URL;?>/assets/images/icon-instagram.png" style="height:34px; width:auto" class="superrocket-logo" alt="instagram"></a>
      </div>
    </div>
<!--
    <div class="head-area" style="margin-top:5px; min-height:inherit">
      <ul class="kingkongmart-menu">
        <li>전체</li>
        <li>킹콩보드 스킨</li>
        <li>댓글 스킨</li>
        <li>확장기능</li>
        <li>테마</li>
        <li>플러그인</li>
      </ul>
    </div>
  </div>
-->
  <div id="srshop-wrapper">
    <div class="srshop-list">
      <ul>
<?php
  foreach($items as $item){
?>
        <li>
          <div class="srshop-item">
            <div class="item-thumbnail"><a href="<?php echo $item['link'];?>" target="_blank"><img src="<?php echo $item['thumbnail_url'];?>" style="width:100%; height:auto"></a></div>
            <div class="item-title"><?php echo $item['title'];?></div>
            <div class="item-description"><?php echo $item['description'];?></div>
            <div class="item-price">
              <div class="price"><?php echo number_format($item['price']);?><span style="color:#424242; font-weight:normal"><?php echo __('원', 'kingkongboard');?></span></div>
              <div class="controller"><a class="button srshop-button-detail" data-id="<?php echo $item['product_id'];?>">자세히보기</a> <a href="<?php echo $item['link'];?>" target="_blank" class="button button-primary"><?php echo __('다운로드', 'kingkongboard');?></a></div>
            </div>
          </div>
        </li>
<?php
  }
?>
      </ul>
    </div>
  </div>
<?php
  }
?>