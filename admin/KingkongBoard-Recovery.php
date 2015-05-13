  <div class="notice-toolbox-wrapper"></div>
  <div class="head-area">
    <div style="float:left; position:relative; top:10px; margin-right:10px">
      <img src="<?php echo KINGKONGBOARD_PLUGINS_URL;?>/assets/images/logo-kingkongboard.png" style="width:220px; height:auto">
    </div>
    <div style="float:left; font-size:18px; margin-top:14px; margin-left:20px"><?php echo __('백업 및 복구', 'kingkongboard');?></div>
    <div style="float:right; position:relative; top:8px">
      <div class="fb-like" data-href="https://facebook.com/superrocketer" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true" style="position:relative; top:-10px; margin-right:10px"></div>
      <a href="http://superrocket.io" target="_blank"><img src="<?php echo KINGKONGBOARD_PLUGINS_URL;?>/assets/images/superrocket-symbol.png" style="height:34px; width:auto" class="superrocket-logo" alt="superrocket.io"></a>
      <a href="https://www.facebook.com/superrocketer" target="_blank"><img src="<?php echo KINGKONGBOARD_PLUGINS_URL;?>/assets/images/icon-facebook.png" style="height:34px; width:auto" class="superrocket-logo" alt="facebook"></a>
      <a href="https://instagram.com/superrocketer/" target="_blank"><img src="<?php echo KINGKONGBOARD_PLUGINS_URL;?>/assets/images/icon-instagram.png" style="height:34px; width:auto" class="superrocket-logo" alt="instagram"></a>
    </div>
  </div>

  <div class="content-area">
    <div style="padding:20px 10px">
      <div style="float:left; position:relative; top:0px; margin-right:10px"><?php echo __('"킹콩보드는 오픈소스로 여러분들의 참여로 운영되고 있습니다. 지금 바로 기부에 참여하세요."', 'kingkongboard');?></div> <a href="http://superrocket.io/%EA%B8%B0%EB%B6%80/" target="_blank" class="button-kkb kkborange"><?php echo __('기부 자세히 알아보기', 'kingkongboard');?></a>
    </div>
  </div>

  <div class="content-area">
    <div class="title_line">킹콩보드의 모든 데이터를 백업하거나 복구하실 수 있습니다.</div>
    <div style="padding:10px">
      <form action="?page=KingkongBoard&view=recovery-upload" method="post" enctype="multipart/form-data" onsubmit="return check_kkb_xml_file();">
        <table style="width:100%">
          <tr>
            <td>백업파일 다운로드 : </td>
            <td>
              <a href="<?php echo KINGKONGBOARD_PLUGINS_URL;?>/data/backup.php" class="button">다운로드</a>
              <div class="description-container">
                <span class="description"><?php echo __('킹콩보드의 모든 데이터를 XML 파일로 다운로드 합니다.', 'kingkongboard');?></span>
              </div> 
            </td>
          </tr>
          <tr>
            <td colspan="2"><hr></td>
          </tr>
          <tr>
            <td>복구하기 : </td>
            <td>
              <input type="file" name="kkb_recovery_file"> <button type="submit" class="button button-primary">복구시작</button>
              <div class="description-container">
                <span class="description"><?php echo __('다운로드하신 XML 파일을 선택 해 주시고 복구시작 버튼을 누르면 복구가 진행됩니다. 현재까지의 데이터가 모두 삭제되고 복원데이터를 입력합니다.', 'kingkongboard');?></span>
              </div> 
            </td>
          </tr>
        </table>
      </form>
    </div>
  </div>