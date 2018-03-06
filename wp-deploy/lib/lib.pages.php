<?php

/*** Adminメニュー追加 ***/
function WPDE_admin_menu()
{
    global $WPDE_dirname, $WPDE_dirurl;
    if(current_user_can('activate_plugins')){
		add_menu_page('WP-Deploy', 'Deploy WP', 'administrator', 'wp-deploy', 'deploy_page', $WPDE_dirurl.'style/man.png');

                wp_enqueue_style("wp-deploy",plugins_url('../style/options.css',__FILE__));
	}
	unset($WPDE_dirname);
	unset($WPDE_dirurl);
}

/*** WP-Deploy FrontPage閲覧 ***/
function deploy_page(){
	global $WPDE_dirname, $WPDE_root, $WPDE_dirurl, $WPDE_version;

	require $WPDE_root.'views/view-wp-deploy.php';
        #include_once('../views/view-wp-deploy.php');
        #wp_enqueue_style("wp-deploy",plugins_url($WPDE_root.'style/options.css',__FILE__));
}


/*** サブメニュー用 ***/
function WPDE_add_page($page_title, $menu_title, $access_level, $file, $function = '')
{
	global $WPDE_dirname;
	add_submenu_page($WPDE_dirname, $page_title, $menu_title, $access_level, $file, $function);

	unset($WPDE_dirname);
	unset($page_title);
	unset($menu_title);
	unset($access_level);
	unset($file);
	unset($function);
}
