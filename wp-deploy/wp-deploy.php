<?php 
/*
   Plugin Name: wp-deploy
   Plugin URI: https://rhems-japan.co.jp
   Description: stage deploy production
   Version: 1.0
   Author: kenji iwanami
   License: GPL2
*/

/* Copyright 2018 kenji (email : iwanami@rhems-japan.co.jp)
    
   This program is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License, version 2, as
   published by the Free Software Foundation.
   
   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.
   
   You should have received a copy of the GNU General Public License
   along with this program; if not, write to the Free Software
   Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*** 管理者オンリー ***/

if (!defined('ABSPATH')) die('You do not have sufficient permissions to access this file.');


/*** 基本設定 ***/
if(!is_admin()){
   return;
}else{
	$WPDE_version = '1.0.0';

	if(!defined('WP_CONTENT_URL')){
		if(!defined('WP_SITEURL')){
			define('WP_SITEURL', get_option('url').'/');
		}
		define('WP_CONTENT_URL', WP_SITEURL.'wp-content');
	}
	if(!defined('WP_PLUGIN_URL')){
		define('WP_PLUGIN_URL', WP_CONTENT_URL.'/plugins');
	}

	$WPDE_root = str_replace('\\', '/', dirname(__FILE__)).'/';
	$WPDE_lib = $WPDE_root.'lib/';
	$WPDE_dirname = str_replace('\\', '/', dirname(plugin_basename(__FILE__)));
	$WPDE_dirurl = WP_PLUGIN_URL.'/'.$WPDE_dirname.'/';

	$WPDE_Locale = get_locale();
	if(!empty($WPDE_Locale))
	{
		$WPDE_moFile = dirname(__FILE__) . '/lang/'.$WPDE_Locale.'.mo';
		if(@file_exists($WPDE_moFile) && is_readable($WPDE_moFile))
		{
			load_textdomain('wphe', $WPDE_moFile);
		}
		unset($WPDE_moFile);
	}
	unset($WPDE_Locale);


	/*** 各ライブラリ読み込み ***/

	if(file_exists($WPDE_lib.'lib.wp-files.php')){
		require $WPDE_lib.'lib.wp-files.php';
	}else{ wp_die(__('Fatal error: Plugin <strong>WP-Deploy</strong> is Broken lib.wp-file', 'wphe')); }

	if(file_exists($WPDE_lib.'lib.functions.php')){
		require $WPDE_lib.'lib.functions.php';
        }else{ wp_die(__('Fatal error: Plugin <strong>WP-Deploy</strong> is Broken lib.func', 'wphe')); }

	if(file_exists($WPDE_lib.'lib.pages.php')){
		require $WPDE_lib.'lib.pages.php';
        }else{ wp_die(__('Fatal error: Plugin <strong>WP-Deploy</strong> is Broken lib.page', 'wphe')); }

        if(file_exists($WPDE_lib.'cfg.php')){
                require $WPDE_lib.'cfg.php';
        }else{ wp_die(__('Fatal error: Plugin <strong>WP-Deploy</strong> is Broken lib.cfg', 'wphe')); }

	/*** メニュー追加 ***/
	if(function_exists('add_action')){
		add_action('admin_menu', 'WPDE_admin_menu');
	}else{
		unset($WPDE_root);
		unset($WPDE_lib);
		unset($WPDE_plugin);
		unset($WPDE_dirname);
		unset($WPDE_dirurl);
		return;
	}
}

?>
