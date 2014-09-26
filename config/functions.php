<?php
function wpslSettingsSave(){
$send_email = $_POST['send_email'];
$save_broken_urls = $_POST['save_broken_urls'];
$save_url_stats = $_POST['save_url_stats'];
$save_url_log = $_POST['save_url_log'];
$redirect_default_url = $_POST['redirect_default_url'];

$from_email = $_POST['from_email'];
$to_email = $_POST['to_email'];
$cc_email = $_POST['cc_email'];
$bcc_email = $_POST['bcc_email'];

$default_url= $_POST['default_url'];

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
$old_url = $_POST['old_url'];
$new_url = $_POST['new_url'];
$url = $_POST['url'];
$type = $_POST['type'];
global $wpdb;

if($type == 'old'){
	$wpdb->query("UPDATE " . TABLE_WBLM . " SET `new_url` = '$new_url', `active` = '1' WHERE id = '$url'");
	$page = $_POST['rpage'];
}else{
	$wpdb->query("UPDATE " . TABLE_WBLM . " SET old_url = '$old_url', new_url = '$new_url' WHERE id = $url");
	$page = 'wblm-redirect';
}

_e('Updated ', 'wblm');

echo '<script type="text/javascript">
window.location="'. admin_url("admin.php?$page"). '";
</script>';
}

function wpslAddURL(){
$old_url = $_POST['old_url'];
$new_url = $_POST['new_url'];

global $wpdb;
$wpdb->query("INSERT INTO " . TABLE_WBLM . " (`old_url`, `new_url`, `hit`, `active`) VALUES ('$old_url', '$new_url', '0', '1')");
$page = 'wblm-redirect';


_e('added ', 'wblm');

echo '<script type="text/javascript">
window.location="'. admin_url("admin.php?page=$page") . '";
</script>';
}


function wpslDelURL(){
$url = $_GET['url'];
$page = $_GET['page'];

global $wpdb;
$wpdb->query("DELETE FROM " . TABLE_WBLM . " WHERE id = $url");
$wpdb->query("DELETE FROM " . TABLE_WBLM_LOG . " WHERE url = $url");

echo '<script type="text/javascript">
window.location="'. admin_url("admin.php?page=$page") . '";
</script>';
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


if($settingsSaveFunc){ wpslSettingsSave(); }
if($editURLFunc){ wpslEditURL(); }
if($addURLFunc){ wpslAddURL(); }
if($delURLFunc){ wpslDelURL(); }

?>