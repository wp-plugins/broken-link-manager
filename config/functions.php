<?php
function wpslSettingsSave(){
$send_email = isset($_POST['send_email']) ? 'on' : null;
$save_broken_urls = isset($_POST['save_broken_urls']) ? 'on' : null;
$save_url_stats = isset($_POST['save_url_stats']) ? 'on' : null;
$save_url_log = isset($_POST['save_url_log']) ? 'on' : null;
$redirect_default_url = isset($_POST['redirect_default_url']) ? 'on' : null;

$from_email = sanitize_email($_POST['from_email']);
$to_email = sanitize_email($_POST['to_email']);
$cc_email = sanitize_email($_POST['cc_email']);
$bcc_email = sanitize_email($_POST['bcc_email']);
$default_url= sanitize_url($_POST['default_url']);

update_option( wblm_send_email, $send_email );
update_option( wblm_save_broken_urls, $save_broken_urls );
update_option( wblm_save_url_stats, $save_url_stats );
update_option( wblm_save_url_log, $save_url_log );
update_option( wblm_redirect_default_url, $redirect_default_url );

update_option( wblm_from_email, $from_email );
update_option( wblm_to_email, $to_email );
update_option( wblm_cc_email, $cc_email );
update_option( wblm_bcc_email, $bcc_email );

update_option( wblm_default_url, $default_url );

_e('Updated ', 'wblm');

echo '<script type="text/javascript">
window.location="'. admin_url("admin.php?page=wblm-settings"). '";
</script>';
}

function wpslEditURL(){
$old_url  = isset($_POST['old_url']) ? sanitize_url($_POST['old_url']) : null;
$new_url  = isset($_POST['new_url']) ? sanitize_url($_POST['new_url']) : null;
$url  = isset($_POST['url']) ? (int) intval($_POST['url']) : null;
$type  = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : null;

if(is_numeric($url) && $url!=null){
	global $wpdb;
		if($type == 'old'){
			$wpdb->query($wpdb->prepare("UPDATE " . TABLE_WBLM . " SET `new_url` = '%s', `active` = '1' WHERE id = '%d'", $new_url, $url));
		}else{
			$wpdb->query($wpdb->prepare("UPDATE " . TABLE_WBLM . " SET old_url = '%s', `new_url` = '%s', `active` = '1' WHERE id = '%d'", $old_url,$new_url, $url));
		}
	}
	_e('Updated ', 'wblm');
}

function wpslAddURL(){
	$old_url  = isset($_POST['old_url']) ? sanitize_url($_POST['old_url']) : null;
	$new_url  = isset($_POST['new_url']) ? sanitize_url($_POST['new_url']) : null;	

	global $wpdb;
	$wpdb->query($wpdb->prepare("INSERT INTO " . TABLE_WBLM . " (`old_url`, `new_url`, `hit`, `active`)  VALUES ('%s', '%s', '0', '1')", $old_url,$new_url));	
	$page = 'wblm-redirect';
	
	_e('added ', 'wblm');
	
	echo '<script type="text/javascript">
	window.location="'. admin_url("admin.php?page=wblm-redirect") . '";
	</script>';
}
	
function wpslDelURL(){
	$url  = isset($_GET['url']) ? (int) intval($_GET['url']) : null;
	$page  = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : null;
	
	if(is_numeric($url) && $url!=null){
	global $wpdb;
	$wpdb->query($wpdb->prepare("DELETE FROM " . TABLE_WBLM . " WHERE id = %d", $url));
	$wpdb->query($wpdb->prepare("DELETE FROM " . TABLE_WBLM_LOG . " WHERE id = %d", $url));
	}
	
	if($page=='wblm-broken' || $page=='wblm-redirect'){
		echo '<script type="text/javascript">
	window.location="'. admin_url("admin.php?page=$page") . '";
	</script>';
	}
}

function wpslLogStatu($redirect, $broken){
	if ($redirect){
		$statu = '<span class="text-success"> 301 </span>';
	}elseif($broken){
		$statu = '<span class="text-danger"> 404 </span>';
	}else{
		$statu = '<span class="text-warning"> Unknown </span>';
	}
	echo $statu;
}

function get_wblmFooter(){
	echo '<div class="navbar navbar-default" id="footer" role="footer">&copy; All rights reserved, <a target="_blank" href="http://k-78.de">K78 Let`s do more</a> and <a target="_blank" href="http://beqo.de">BEQO</a>   ver. '. WBLM_VERSION .'</div>';
}

function get_wblmTopNavi(){
	$topNavi ='
	<ul class="nav navbar-top-links navbar-right">
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i></a>
				<ul class="dropdown-menu dropdown-user">
					<li><a href="%s"><div><i class="fa fa-area-chart fa-fw"></i> Dashboard</div></a></li>
					<li class="divider"></li>
					<li><a href="%s"><div><i class="fa fa-link  fa-fw"></i> Redirect URLs</div></a></li>
					<li class="divider"></li>
					<li><a href="%s"><div><i class="fa fa-unlink fa-fw"></i> Broken URLs</div></a></li>
					<li class="divider"></li>
					<li><a href="%s"><div><i class="fa fa-plus fa-fw"></i> Add URLs</div></a></li>
					<li class="divider"></li>
					<li><a href="%s"><div><i class="fa fa-list-alt fa-fw"></i> Log</div></a></li>
					<li class="divider"></li>
					<li><a class="text-center" href="%s"><i class="fa fa-cogs "></i>
					<strong>Settings</strong></a></li>
				</ul>
		</li>
	</ul>';
	printf($topNavi, admin_url("admin.php?page=wblm-dashboard"), admin_url("admin.php?page=wblm-redirect"), admin_url("admin.php?page=wblm-broken"), admin_url("admin.php?page=wblm-add-url"), admin_url("admin.php?page=wblm-log"), admin_url("admin.php?page=wblm-settings"));
}
function get_bulkEdit($page, $buttonText){
	$bulkEdit =  '
	<div class="alert alert-info alert-dismissable" id="bulkEditBox">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<form action="admin.php?page=%s" method="post">';     
		foreach($_POST['url'] as $url) {
			$bulkEdit .= '<input type="hidden" name="urls[]" value="'.sanitize_url($url).'" />';
		}
		$bulkEdit .= '<label>
				<span class="title">URL</span>
				<span><input type="text" class="wblm-table-add-field" value="" name="new_url" placeholder="http://"></span>
			</label>
		<button class="button-primary save alignright" type="submit" name="urlAddBulk" value="OK">%s</button>
		</form></div>';
	printf($bulkEdit, $page, $buttonText);
}
function wpslEmptyLOG($statu){
	global $wpdb;
	if($statu == 404){
		$wpdb->query("DELETE FROM " . TABLE_WBLM_LOG . ' WHERE http_statu = 404');
	}elseif($statu == 301){
		$wpdb->query("DELETE FROM " . TABLE_WBLM_LOG . ' WHERE http_statu = 301');
	}else{
		$wpdb->query("DELETE FROM " . TABLE_WBLM_LOG);
	}	
}
function wpslEmptyBrokenUrls(){
	global $wpdb;
	$wpdb->query("DELETE FROM " . TABLE_WBLM . " WHERE active = 0");
}
if($settingsSaveFunc){ wpslSettingsSave(); }
if($editURLFunc){ wpslEditURL(); }
if($addURLFunc){ wpslAddURL(); }
if($delURLFunc){ wpslDelURL(); }
if($emptyLOGFunc){ wpslEmptyLOG($emptyLOGStatu); }
if($emptyBrokenUrlsFunc){ wpslEmptyBrokenUrls(); }
?>