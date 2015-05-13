<?php
list($path) = explode(DIRECTORY_SEPARATOR.'wp-content', dirname(__FILE__).DIRECTORY_SEPARATOR);
include $path.DIRECTORY_SEPARATOR.'wp-load.php';

$referer = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
$host = isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'';

//header("Content-Type: text/html; charset=UTF-8");
if(!stristr($referer, $host)) wp_die('KINGKONG BOARD : '.__('지금 페이지는 외부 접근이 차단되어 있습니다.', 'kingkongboard'));
if(!current_user_can('activate_plugins')) wp_die('KINGKONG BOARD : '.__('백업할 권한이 없습니다.', 'kingkongboard'));

include KINGKONGBOARD_ABSPATH.'/class/class.KKB_Backup.php';
$backup = new KKB_Backup();

$tables = $backup->getTables();
$data = '';
foreach($tables AS $key => $value){
  $data .= $backup->getXml($value);
}

$backup->download($data, 'xml');
?>