<?php
/**
 * 킹콩보드 워드프레스 게시판 보안 함수
 * @link www.superrocket.io
 * @copyright Copyright 2015 SuperRocket. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl.html
 */
	// HTMLPurifier 클래스를 불러온다.
	if(!class_exists('HTMLPurifier')){
		require_once(KINGKONGBOARD_ABSPATH.'htmlpurifier/HTMLPurifier.standalone.php');
	}

/**
 * XSS 공격을 방어하기 위해서 위험 문자열을 제거한다.
 * @param string $data
 */
function kingkongboard_xssfilter($data){
	if(is_array($data)) return array_map('kingkongboard_xssfilter', $data);
		$HTMLPurifier_Config = HTMLPurifier_Config::createDefault();
		$HTMLPurifier_Config->set('HTML.SafeIframe', true);
		$HTMLPurifier_Config->set('URI.SafeIframeRegexp', '(.*)');
		$HTMLPurifier_Config->set('HTML.TidyLevel', 'light');
		$HTMLPurifier_Config->set('HTML.SafeObject', true);
		$HTMLPurifier_Config->set('HTML.SafeEmbed', true);
		$HTMLPurifier_Config->set('Attr.AllowedFrameTargets', array('_blank'));
		$HTMLPurifier_Config->set('Output.FlashCompat', true);
		$HTMLPurifier_Config->set('Cache.SerializerPath', WP_CONTENT_DIR.'/uploads');
		$GLOBALS['KINGKONGBOARD']['HTMLPurifier_Config'] = $HTMLPurifier_Config;
		$GLOBALS['KINGKONGBOARD']['HTMLPurifier'] = HTMLPurifier::getInstance();
		unset($HTMLPurifier_Config);

		$data = $GLOBALS['KINGKONGBOARD']['HTMLPurifier']->purify(stripslashes($data), $GLOBALS['KINGKONGBOARD']['HTMLPurifier_Config']);
		return kingkongboard_safeiframe($data);
}

/**
 * 허용된 도메인의 아이프레임만 남기고 모두 제거.
 * @param string $data
 * @return string
 */
function kingkongboard_safeiframe($data){
	/*
	 * 허가된 도메인 호스트 (화이트 리스트)
	 */
	$whilelist[] = 'youtube.com';
	$whilelist[] = 'www.youtube.com';
	$whilelist[] = 'maps.google.com';
	$whilelist[] = 'maps.google.co.kr';
	$whilelist[] = 'serviceapi.nmv.naver.com';
	$whilelist[] = 'serviceapi.rmcnmv.naver.com';
	$whilelist[] = 'videofarm.daum.net';
	$whilelist[] = 'player.vimeo.com';
	$whilelist[] = 'w.soundcloud.com';
	$whilelist[] = 'slideshare.net';
	$whilelist[] = 'www.slideshare.net';
	
	$re = preg_match_all('/<iframe.+?src="(.+?)".+?[^>]*+>/is', $data, $matches);
	$iframe = $matches[0];
	$domain = $matches[1];
	
	foreach($domain AS $key => $value){
		$value = 'http://' . preg_replace('/^(http:\/\/|https:\/\/|\/\/)/i', '', $value);
		$url = parse_url($value);
		if(!in_array($url['host'], $whilelist)){
			$data = str_replace($iframe[$key].'</iframe>', '', $data);
			$data = str_replace($iframe[$key], '', $data);
		}
	}
	return $data;
}

/**
 * 모든 html 제거
 * @param object $data
 */
function kingkongboard_htmlclear($data){
	if(is_array($data)) return array_map('kingkongboard_htmlclear', $data);
	return htmlspecialchars(strip_tags($data));
}
?>