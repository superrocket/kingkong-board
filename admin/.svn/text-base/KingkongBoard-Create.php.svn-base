  <div class="head-area">
    <div style="float:left; position:relative; top:10px; margin-right:10px">
      <a href="?page=KingkongBoard"><img src="<?php echo KINGKONGBOARD_PLUGINS_URL;?>/assets/images/logo-kingkongboard.png" style="width:220px; height:auto"></a>
    </div>
    <div style="float:left; font-size:18px; margin-top:14px; margin-left:20px"><?php echo __('신규 게시판 생성', 'kingkongboard');?></div>
    <div style="float:right; position:relative; top:8px">
      <div class="fb-like" data-href="https://facebook.com/superrocketer" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true" style="position:relative; top:-10px; margin-right:10px"></div>
      <a href="http://superrocket.io" target="_blank"><img src="<?php echo KINGKONGBOARD_PLUGINS_URL;?>/assets/images/superrocket-symbol.png" style="height:34px; width:auto" class="superrocket-logo" alt="superrocket.io"></a>
      <a href="https://www.facebook.com/superrocketer" target="_blank"><img src="<?php echo KINGKONGBOARD_PLUGINS_URL;?>/assets/images/icon-facebook.png" style="height:34px; width:auto" class="superrocket-logo" alt="facebook"></a>
      <a href="https://instagram.com/superrocketer/" target="_blank"><img src="<?php echo KINGKONGBOARD_PLUGINS_URL;?>/assets/images/icon-instagram.png" style="height:34px; width:auto" class="superrocket-logo" alt="instagram"></a>
    </div>
  </div>
  <div class="content-area">
    <div style="padding:20px 10px">
      <div style="float:left; position:relative; top:0px; margin-right:10px">"킹콩마트가 오픈하였습니다. 보다 다양한 스킨과 익스텐션을 경험하세요! "</div> <a href="?page=srshop" class="button-kkb kkbred">킹콩마트 둘러보기</a>
    </div>
  </div>
  <div class="notice-toolbox-wrapper"></div>
  <form id="kkb-create-board-form">
    <input type="hidden" name="kkb_type" value="create">
    <input type="hidden" name="board_id">
    <div class="settings-panel">
      <div class="settings-panel-left">
        <div class="settings-title">Board Settings</div>
        <div class="settings-table-wrapper">
          <table>
            <tr>
              <th><?php echo __('게시판 명:', 'kingkongboard');?></th>
              <td>
                <input type="text" class="kkb-input" name="kkb_board_name"> <span class="kkb-required">*</span>
                <div class="description-container">
                  <span class="description"><?php echo __('보여질 게시판의 이름입니다. 예 : 공지사항', 'kingkongboard');?></span>
                </div>
              </td>
            </tr>
            <tr>
              <th><?php echo __('게시판 슬러그:', 'kingkongboard');?></th>
              <td>
                <input type="text" class="kkb-input" name="kkb_board_slug"> <span class="kkb-required">*</span>
                <div class="description-container">
                  <span class="description"><?php echo __('게시판 슬러그는 게시판을 붙여넣을 때 필요합니다. 영문으로 작성하시기 바랍니다. 예 : notice', 'kingkongboard');?></span>
                </div>
              </td>
            </tr>
            <tr>
              <th><?php echo __('게시판 숏코드:', 'kingkongboard');?></th>
              <td>
                <input type="text" class="kkb-input" name="kkb_board_shortcode">
                <div class="description-container">
                  <span class="description"><?php echo __('이 숏코드를 원하시는 Post 나 Page 에 붙여넣으면 노출 됩니다.', 'kingkongboard');?></span>
                </div>
              </td>
            </tr>
            <tr>
              <th><?php echo __('게시물 표시:', 'kingkongboard');?></th>
              <td>
                <input type="text" class="kkb-input" name="kkb_board_rows" value="10">
                <div class="description-container">
                  <span class="description"><?php echo __('한 페이지에 보여지는 게시물 숫자를 의미합니다.', 'kingkongboard');?></span>
                </div>
              </td>
            </tr>
            <tr>
              <th><?php echo __('글 작성 에디터:', 'kingkongboard');?></th>
              <td>
                <select class="kkb-input-select" name="kkb_board_editor">
                  <option value="textarea"><?php echo __('Textarea 사용', 'kingkongboard');?></option>
                  <option value="wp_editor"><?php echo __('WP 내장 에디터 사용', 'kingkongboard');?></option>
<?php

  $path = TEMPLATEPATH."/kingkongboard/editor";
  $dirs = array_filter(glob($path . '/*' , GLOB_ONLYDIR), 'is_dir');
  foreach($dirs as $dir){
    if (file_exists($dir."/kingkongboard-editor.php")) {
      include($dir."/kingkongboard-editor.php");
      echo "<option value='".$Slug."'>".$EditorName."</option>";
    }
  } 

?>
                </select>
                <div class="description-container">
                  <span class="description"><?php echo __('본문 작성 에디터를 설정 합니다.', 'kingkongboard');?></span>
                </div>
              </td>
            </tr>
            <tr>
              <th><?php echo __('답글쓰기 사용', 'kingkongboard');?></th>
              <td>
                <input type="radio" name="kkb_reply_use" value="T" checked>사용 <input type="radio" name="kkb_reply_use" value="F">미사용
                <div class="description-container">
                  <span class="description"><?php echo __('답글쓰기 미사용 지정시 답글쓰기 버튼이 노출되지 않습니다. 사용으로 지정 후 권한설정의 쓰기 권한이 없다면 또한 노출 되지 않습니다.', 'kingkongboard');?></span>
                </div>                
              </td>
            </tr>
            <tr>
              <th><?php echo __('조건 설정', 'kingkongboard');?> :</th>
              <td>
                <input type="checkbox" name="kkb_must_secret" value="T"> <?php echo __('전체 게시글 비밀글로 설정', 'kingkongboard');?>
                <div class="description-container">
                  <span class="description"><?php echo __('비밀글 설정 여부에 상관없이 모든 글들이 비밀글로 등록 됩니다.', 'kingkongboard');?></span>
                </div>
                <input type="checkbox" name="kkb_must_thumbnail" value="T"> <?php echo __('썸네일 반드시 등록', 'kingkongboard');?>
                <div class="description-container">
                  <span class="description"><?php echo __('썸네일을 반드시 업로드 해야만 글이 등록 됩니다.', 'kingkongboard');?></span>
                </div> 
              </td>
            </tr>
            <tr>
              <td colspan="2"><hr></td>
            </tr>
            <tr>
              <th><?php echo __('자동글 방지', 'kingkongboard');?></th>
              <td>
                <table>
                  <tr>
                    <td colspan="2">
                      <input type="checkbox" name="kkb_board_captcha" value="T"> <?php echo __('자동글 방지(google reCAPTCHA)를 사용합니다.', 'kingkongboard');?>
                    <div class="description-container">
                      <span class="description"><?php echo __('사용하지 않으시려면 해제 하시면 됩니다.', 'kingkongboard');?></span>
                    </div> 
                    </td>
                  </tr>
                  <tr>
                    <td width="100px">Site Key</td>
                    <td><input type="text" class="kkb-input" name="kkb_board_captcha_sitekey"></td>
                  </tr>
                  <tr>
                    <td>Secret Key</td>
                    <td><input type="text" class="kkb-input" name="kkb_board_captcha_secretkey"></td>
                  </tr>
                </table>
                <div class="description-container">
                  <span class="description"><?php echo __('자동글 방지는 구글 reCAPTCHA API 를 사용합니다. 자동글 방지를 사용하기 위해서는 서버 클라이언트 URL 라이브러리(CURL)가 설치되어 있어야만 합니다. Site Key 와 Secret Key 를 생성하기 위해서는 구글 개발자 센터에서 등록하셔야 합니다.', 'kingkongboard');?> <a href="https://www.google.com/recaptcha/admin" target="_blank"><?php echo __('구글 reCAPTCHA API KEY 등록 바로가기', 'kingkongboard');?></a></span>
                </div>    
              </td>
            </tr>
            <tr>
              <th><?php echo __('썸네일', 'kingkongboard');?></th>
              <td>
                <input type="checkbox" name="kkb_board_thumbnail_display" value="display"> <?php echo __('리스트에 썸네일을 노출 합니다.', 'kingkongboard');?>
                <div class="description-container">
                  <span class="description"><?php echo __('게시판 리스트에 썸네일 노출 여부를 지정합니다.', 'kingkongboard');?></span>
                </div>                
              </td>
            </tr>
            <tr>
              <th><?php echo __('썸네일 본문', 'kingkongboard');?></th>
              <td>
                <input type="radio" name="kkb_board_thumbnail_input_content" value="T" checked> <?php echo __('본문포함', 'kingkongboard');?> <input type="radio" name="kkb_board_thumbnail_input_content" value="F"> <?php echo __('본문미포함', 'kingkongboard');?>
                <div class="description-container">
                  <span class="description"><?php echo __('본문포함을 체크할 경우 썸네일이 본문 상단에 자동으로 삽입 됩니다.', 'kingkongboard');?></span>
                </div>                
              </td>
            </tr>
            <tr>
              <th><?php echo __('검색 필터링:', 'kingkongboard');?></th>
              <td>
                <input type="radio" name="kkb_board_search_filter" value="T" checked><?php echo __('포함', 'kingkongboard');?> <input type="radio" name="kkb_board_search_filter" value="F"><?php echo __('미포함', 'kingkongboard');?>
                <div class="description-container">
                  <span class="description"><?php echo __('워드프레스 기본 검색 포함여부를 설정합니다.', 'kingkongboard');?></span>
                </div>
              </td>
            </tr>
            <tr>
              <th><?php echo __('첨부파일 설정:', 'kingkongboard');?></th>
              <td>
                <input type="checkbox" name="kkb_board_thumbnail_upload" value="T" checked><?php echo __('썸네일 업로드 사용', 'kingkongboard');?> <input type="checkbox" name="kkb_board_file_upload" value="T" checked><?php echo __('첨부파일 업로드 사용', 'kingkongboard');?>
                <div class="description-container">
                  <span class="description"><?php echo __('첨부파일 업로드 (썸네일 포함) 노출 여부를 지정합니다.', 'kingkongboard');?></span>
                </div>                
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <hr>
              </td>
            </tr>
            <tr>
              <th><?php echo __('기본양식설정', 'kingkongboard'); ?></th>
              <td>
                <?php 
                  $content = get_post_meta($board_id, "kkb_basic_form", true);
                  wp_editor($content, 'kkb_basic_form'); 
                ?>
                <div class="description-container">
                  <span class="description"><?php echo __('기본 글쓰기 시에 쓰일 양식을 지정합니다.', 'kingkongboard');?></span>
                </div>   
              </td>
            </tr>
            <tr>
              <th><?php echo __('금칙어 설정', 'kingkongboard');?></th>
              <td>
                <textarea rows="5" class="kkb-input" name="kkb_exclude_keyword" style="max-width:100%; width:100%; font-size:14px"></textarea>
                <div class="description-container">
                  <span class="description"><?php echo __('글쓰기시에 지정된 단어가 들어가 있으면 글이 등록되지 않습니다. 콤마(,)로 분리 합니다. 과도한 금칙어 설정과 일반적 단어 설정으로 인한 부작용에 주의하시기 바랍니다.', 'kingkongboard');?></span>
                </div>  
              </td>
            </tr>
          </table>
          <br><br>
          <button type="button" class="button-kkb kkbgreen button-kkb-create-board"><i class="kkb-icon kkb-icon-setting"></i><?php echo __('게시판 생성', 'kingkongboard');?></button>
          <a href="?page=KingkongBoard" class="button-kkb kkbred"><i class="kkb-icon kkb-icon-close" style="position:relative; top:5px"></i><?php echo __('취소', 'kingkongboard');?></a>
        </div>
      </div>
      <div class="settings-panel-right">
        <?php do_action('kingkong_board_columns'); ?>
      </div>
    </div>
  </form>


