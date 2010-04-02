<?php
/* 
Plugin Name: Unicornify
Plugin URI: http://ottopress.com/wordpress-plugins/unicornify
Description: Unicorn Avatars!
Author: Otto
Version: 0.1
Author URI: http://ottodestruct.com
License: GPL2

    Copyright 2010  Samuel Wood  (email : otto@ottodestruct.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2, 
    as published by the Free Software Foundation. 
    
    You may NOT assume that you can use any other version of the GPL.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    
    The license for this software can likely be found here: 
    http://www.gnu.org/licenses/gpl-2.0.html
*/

// generate facebook avatar code for FB user comments
add_filter('get_avatar','unicorn_avatar', 10, 5);
function unicorn_avatar($avatar, $id_or_email, $size = '96', $default = '', $alt = false) {
	$email = '';
	if ( is_numeric($id_or_email) ) {
		$id = (int) $id_or_email;
		$user = get_userdata($id);
		if ( $user )
			$email = $user->user_email;
	} elseif ( is_object($id_or_email) ) {
		if ( !empty($id_or_email->user_id) ) {
			$id = (int) $id_or_email->user_id;
			$user = get_userdata($id);
			if ( $user)
				$email = $user->user_email;
		} elseif ( !empty($id_or_email->comment_author_email) ) {
			$email = $id_or_email->comment_author_email;
		}
	} else {
		$email = $id_or_email;
	}

	if ( !empty($email) )
		$email_hash = md5( strtolower( $email ) );

	$host = 'http://unicornify.appspot.com';

	if ( !empty($email) ) {
		$out = "$host/avatar/";
		$out .= $email_hash;
		$out .= '?s='.$size;
		$avatar = "<img alt='{$alt}' src='{$out}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
	}

	return $avatar;
}
