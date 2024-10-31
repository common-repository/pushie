<?php

/*
	Plugin Name: Pushie
	Plugin URI: http://wolfiezero.com/wordpress/pushie/
	Version: 0.3.1
	Description: Push notifcations to your mobile on certain events. Only supports Boxcar (http://boxcar.io/) currently.
	Author: Neil 'WolfieZero' Sweeney
	Author URI: http://wolfiezero.com/
	License: GPLv3
*/

#  pushie.php
#
#  Created by Neil Sweeney on 06-03-2011.
#  Copyright 2011, Neil Sweeney. All rights reserved.
#
#  This program is free software: you can redistribute it and/or modify
#  it under the terms of the GNU General Public License as published by
#  the Free Software Foundation, either version 3 of the License, or
#  (at your option) any later version.
#
#  You may obtain a copy of the License at:
#  http://www.gnu.org/licenses/gpl-3.0.txt
#
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU General Public License for more details.


add_action('admin_menu', 'pushieSettings');

if(get_option('pushie_notification_onComment') == '1') {
	add_action('comment_post', 'pushieComment', 10, 1);
}

if(get_option('pushie_notification_onPingback') == '1') {
	add_action('pingback_post', 'pushiePingback', 10, 1);
}


/**
* Push a comment notification
* 
* @param int $intCommentID
*/
function pushieComment($intCommentID) {
	
	$objComment = get_comment($intCommentID);
	$objPost	= get_post($objComment->comment_post_ID);
	
	if($objPost->post_title){
		$strMessage = $objComment->comment_author.' commented on '.$objPost->post_title;
	} else {
		$strMessage = $objComment->comment_author.' commeted on post ID  '.$objComment->comment_post_ID;
	}
	
	pushieBoxcar(array(
		'message'	=> $strMessage
	));
}


/**
* Push a pingback notification
* 
* @param int $intCommentID
*/
function pushiePingback($intCommentID) {
	
	$objComment = get_comment($intCommentID);
	$objPost	= get_post($objComment->comment_post_ID);
	
	$strMessage = $objPost->post_title.' has recieved a pingback';
	
	pushieBoxcar(array(
		'message'	=> $strMessage
	));
}


/**
 * Pushes a notifcation to Boxcar on trigger
 *
 * @param array $args
 *
 * @return bool TRUE
 */
function pushieBoxcar($args) {
	// You're not punk, and I'm telling everyone
	
	$a = shortcode_atts(array(
		'from'		=> null,
		'message'	=> null
	), $args);
	
	// [PROVIDER NAME] - [FROM] - [MESSAGE]
	
	$apiEmail	= md5(get_option('pushie_boxcar_email'));
	$apiKey		= get_option('pushie_boxcar_apiKey');
	$apiSecret 	= get_option('pushie_boxcar_apiSecret');

	$arrData = array(
		'token'								=> $apiKey,
		'secret'							=> $apiSecret,
		'email'								=> $apiEmail,
		'notification[message]'				=> "\n".$a['message']
	);
	if($a['from']) {
		$arrData['notification[from_screen_name]'] = $a['from'];
	}
	
	$arrFields = array();
	
	foreach ($arrData as $strKey => $strValue) {
		array_push($arrFields, $strKey.'='.$strValue);
	}
	$strFields = implode('&', $arrFields);
	
	$curl = curl_init();

	// set URL and other appropriate options
	curl_setopt($curl, CURLOPT_URL, 'http://boxcar.io/devices/providers/'.$apiKey.'/notifications');
	curl_setopt($curl, CURLOPT_USERAGENT, 'Pushie_Boxcar_Client [http://bit.ly/pushie]');
	curl_setopt($curl, CURLOPT_POST, TRUE);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $strFields);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, FALSE);
	curl_setopt($curl, CURLOPT_TIMEOUT, 5);

	curl_exec($curl);
	curl_close($curl);
	
	return TRUE;
}

/**
* Display the settings page in admin
* 
*/
function pushieSettings() {
	if(function_exists('add_options_page')) {
		add_options_page('Pushie Settings', 'Pushie', 'manage_options', 'pushie/settings.php', '');
	}
}

?>
