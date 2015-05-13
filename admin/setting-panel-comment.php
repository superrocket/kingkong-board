<?php
  function KingkongBoard_Setting_Panel_Comment(){

    $thumbnail                = "";
    $background_color         = "";
    $background_border        = "";
    $background_border_color  = "";
    $writer_color             = "";
    $writer_font_weight       = "";
    $writer_font_size         = "";
    $date_format              = "";
    $date_color               = "";
    $date_font_size           = "";
    $content_color            = "";
    $comment_options          = null;
    if(isset($_GET['id'])){
      $board_id = $_GET['id'];
      $board_comment = get_post_meta($board_id, 'board_comment', true);
      $comment_options = get_post_meta($board_id, 'kingkongboard_comment_options', true);
      if($comment_options){
        $comment_options = unserialize($comment_options);
      }
    } else {
      $board_comment = "T";
    }

    if(!$comment_options){
      $comment_options = array(
        'thumbnail' => 'T',
        'background' => array(
          'color'         => '#f9f9f9',
          'border'        => '1px',
          'border_color'  => '#f1f1f1'
        ),
        'writer'     => array(
          'color'       => '#424242',
          'font_weight' => 'bold',
          'font_size'   => '12px'
        ),
        'date'       => array(
          'format'      => 'Y/m/d H:i',
          'color'       => '#666666',
          'font_size'   => '11px'
        ),
        'content'    => array(
          'color'       => '#424242'
        )
      );      
    }

    if($comment_options['thumbnail'] == "T"){
      $thumbnail = "checked";
    }

    if($comment_options['writer']['font_weight'] == "bold"){
      $writer_font_weight = "checked";
    } else {
      $writer_font_weight = "";
    }

    $comment_enable   = "";
    $comment_disable  = "";

    switch($board_comment){
      case "T" :
        $comment_enable = "checked";
      break;

      case "F" :
        $comment_disable = "checked";
      break;

      default :
        $comment_enable = "checked";
      break;
    }
?>

    <table>
      <?php do_action('kkb_admin_panel_comment_use_before'); ?>
      <tr>
        <th><?php echo __('댓글 사용', 'kingkongboard');?> :</th>
        <td>
          <input type="radio" name="board_comment" value="T" <?php echo $comment_enable;?>> <?php echo __('사용함', 'kingkongboard');?> <input type="radio" name="board_comment" value="F" <?php echo $comment_disable;?>> <?php echo __('사용안함', 'kingkongboard');?>
          <div class="description-container">
            <span class="description"><?php echo __('게시판에 댓글기능 사용 여부를 지정합니다.', 'kingkongboard');?></span>
          </div>                
        </td>
      </tr>
      <?php do_action('kkb_admin_panel_comment_use_after'); ?>
      <tr>
        <th colspan="2"><?php echo __('댓글 스타일 설정', 'kingkongboard');?>
          <div class="description-container">
            <span class="description"><?php echo __('댓글 영역의 스타일 옵션을 설정합니다.', 'kingkongboard');?></span>
          </div> 
        </th>
      </tr>
      <tr>
        <td colspan="2">
          <table>
            <tr>
              <th class="setting-pannel-comment-title"><?php echo __('프로필사진', 'kingkongboard');?></th>
              <td>
                <input type="checkbox" name="setting_comment_thumbnail" value="T" <?php echo $thumbnail;?>> <?php echo __('사용', 'kingkongboard');?>
                <div class="description-container">
                  <span class="description">
                    <?php echo __('작성자 왼쪽에 프로필 사진을 노출합니다.', 'kingkongboard');?><br>(<?php echo __('Gravatar 에 등록된 프로필 사진을 불러옵니다.', 'kingkongboard');?>)<br>
                    <a href="https://gravatar.com" target="_blank"><?php echo __('Gravatar 자세히 알아보기', 'kingkongboard');?></a>
                  </span>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2"><hr></td>
            </tr>
            <tr>
              <th class="setting-pannel-comment-title" style="vertical-align:middle"><?php echo __('배경', 'kingkongboard');?></th>
              <td style="vertical-align:top">
                <table>
                  <tr>
                    <td class="setting-pannel-comment-subtitle" style="vertical-align:middle"><?php echo __('색상', 'kingkongboard');?></td>
                    <td style="vertical-align:middle">
                      <input type="text" name="setting_comment_background_color" class="comment-list-background-color" value="<?php echo $comment_options['background']['color'];?>">
                      <div class="description-container">
                        <span class="description"><?php echo __('배경색상을 지정합니다.', 'kingkongboard');?></span>
                      </div> 
                    </td>
                  </tr>
                  <tr>
                    <td class="setting-pannel-comment-subtitle" style="vertical-align:middle"><?php echo __('Border 색상', 'kingkongboard');?></td>
                    <td>
                      <input type="text" name="setting_comment_background_border_color" class="comment-list-background-border-color" value="<?php echo $comment_options['background']['border_color'];?>">
                      <div class="description-container">
                        <span class="description"><?php echo __('배경 테두리(Border) 색상을 지정합니다.', 'kingkongboard');?></span>
                      </div>                       
                    </td>
                  </tr>
                  <tr>
                    <td class="setting-pannel-comment-subtitle" style="vertical-align:middle"><?php echo __('Border 두께', 'kingkongboard');?></td>
                    <td>
                      <input type="text" name="setting_comment_background_border" class="kkb-input" style="max-width:80px; width:100%" value="<?php echo $comment_options['background']['border'];?>">
                      <div class="description-container">
                        <span class="description"><?php echo __('배경 테두리(border) 두께를 지정합니다.', 'kingkongboard');?></span>
                      </div>                       
                    </td>
                  </tr> 
                </table>
              </td>
            </tr> 
            <tr>
              <td colspan="2"><hr></td>
            </tr>    
            <tr>
              <th class="setting-pannel-comment-title" style="vertical-align:middle"><?php echo __('작성자', 'kingkongboard');?></th>
              <td style="vertical-align:top">
                <table>
                  <tr>
                    <td class="setting-pannel-comment-subtitle" style="vertical-align:middle"><?php echo __('색상', 'kingkongboard');?></td>
                    <td>
                      <input type="text" name="setting_comment_writer_color" class="comment-list-writer-color" value="<?php echo $comment_options['writer']['color'];?>">
                      <div class="description-container">
                        <span class="description"><?php echo __('작성자 글씨 색상을 지정합니다.', 'kingkongboard');?></span>
                      </div>                       
                    </td>
                  </tr>
                  <tr>
                    <td class="setting-pannel-comment-subtitle" style="vertical-align:middle"><?php echo __('굵기', 'kingkongboard');?></td>
                    <td>
                      <input type="checkbox" name="setting_comment_writer_bold" value="bold" <?php echo $writer_font_weight;?>> <?php echo __('굵게', 'kingkongboard');?>
                      <div class="description-container">
                        <span class="description"><?php echo __('작성자 글씨의 굵기를 지정합니다. (체크시 bold)', 'kingkongboard');?></span>
                      </div>                       
                    </td>
                  </tr>
                  <tr>
                    <td class="setting-pannel-comment-subtitle" style="vertical-align:middle"><?php echo __('크기', 'kingkongboard');?></td>
                    <td>
                      <input type="text" name="setting_comment_writer_font_size" class="kkb-input" style="max-width:80px; width:100%" value="<?php echo $comment_options['writer']['font_size'];?>">
                      <div class="description-container">
                        <span class="description"><?php echo __('작성자 글씨의 크기를 지정합니다. (예시 : 12px, 단위까지 입력하셔야 합니다.)', 'kingkongboard');?></span>
                      </div>                       
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td colspan="2"><hr></td>
            </tr>
            <tr>
              <th class="setting-pannel-comment-title" style="vertical-align:middle"><?php echo __('작성일', 'kingkongboard');?></th>
              <td style="vertical-align:top">
                <table>
                  <tr>
                    <td class="setting-pannel-comment-subtitle" style="vertical-align:middle"><?php echo __('포맷', 'kingkongboard');?></td>
                    <td style="text-align:left">
                      <select name="setting_comment_date_format" class="kkb-input">
                        <option>Y/m/d H:i</option>
                        <option>Y/m/d H:i:s</option>
                        <option>Y-m-d H:i</option>
                        <option>Y-m-d H:i:s</option>
                        <option>Y.m.d H:i</option>
                        <option>Y.m.d H:i:s</option>
                      </select>
                      <div class="description-container">
                        <span class="description"><?php echo __('작성일 포맷타입을 지정합니다. (Y/m/d H:i 선택시', 'kingkongboard');?> <?php echo date("Y/m/d H:i");?>)</span>
                      </div> 
                    </td>
                  </tr>
                  <tr>
                    <td class="setting-pannel-comment-subtitle" style="vertical-align:middle"><?php echo __('색상', 'kingkongboard');?></td>
                    <td>
                      <input type="text" name="setting_comment_date_color" class="comment-list-date-color" value="<?php echo $comment_options['date']['color'];?>">
                      <div class="description-container">
                        <span class="description"><?php echo __('작성일 글씨 색상을 지정합니다.', 'kingkongboard');?></span>
                      </div>                       
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td colspan="2"><hr></td>
            </tr>
            <tr>
              <th class="setting-pannel-comment-title" style="vertical-align:middle"><?php echo __('본문', 'kingkongboard');?></th>
              <td style="vertical-align:top">
                <table>
                  <tr>
                    <td class="setting-pannel-comment-subtitle" style="vertical-align:middle"><?php echo __('색상', 'kingkongboard');?></td>
                    <td>
                      <input type="text" name="setting_comment_content_color" class="comment-list-content-color" value="<?php echo $comment_options['content']['color'];?>">
                      <div class="description-container">
                        <span class="description"><?php echo __('본문 글씨 색상을 지정합니다.', 'kingkongboard');?></span>
                      </div>                       
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
<script>
  jQuery(document).ready(function(){
    jQuery("[name=setting_comment_date_format]").val("<?php echo $comment_options['date']['format'];?>");
  });
</script>
<?php
  }
?>