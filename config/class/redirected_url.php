<?php
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class wblm_List_Table extends WP_List_Table {

var $url_data = array();        
        
    function __construct(){
    global $status, $page, $wpdb;

        parent::__construct( array(
            'singular'  => __( 'url', 'wblm' ),     //singular name of the listed records
            'plural'    => __( 'urls', 'wblm' ),   //plural name of the listed records
            'ajax'      => false        //does this table support ajax?

    ) );
    add_action( 'admin_head', array( &$this, 'admin_header' ) );            

    }

  function admin_header() {
    $page = ( isset($_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : false;
    if( 'wblm-redirect' != $page )
    return;
    echo '<style type="text/css">';
    echo '.wp-list-table .column-id { width: 30px; }';
    echo '.wp-list-table .column-old_url { width: auto; }';
    echo '.wp-list-table .column-new_url { width: auto; }';
    echo '.wp-list-table .column-hit { width: 70px;}';
    echo '</style>';
  }

  function no_items() {
    _e( 'No urls found, dude.' );
  }

  function column_default( $item, $column_name ) {
    switch( $column_name ) { 
    	case 'id':
        case 'old_url':
        case 'new_url':
        case 'hit':
            return $item[ $column_name ];
        default:
            return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
    }
  }

function get_sortable_columns() {
  $sortable_columns = array(
  	'id'  => array('id',false),
    'old_url'  => array('old_url',false),
    'new_url' => array('new_url',false),
    'hit'   => array('hit',false)
  );
  return $sortable_columns;
}

function get_columns(){
        $columns = array(
            'cb'        => '<input type="checkbox" />',
            'old_url' => __( 'Broken URLs', 'wblm' ),
            'new_url'    => __( 'Redirected URLs', 'wblm' ),
            'hit'      => __( 'HIT', 'wblm' )
        );
         return $columns;
    }

function usort_reorder( $a, $b ) {
  // If no sort, default to title
  $orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : 'old_url';
  // If no order, default to asc
  $order = ( ! empty($_GET['order'] ) ) ? $_GET['order'] : 'asc';
  // Determine sort order
  $result = strcmp( $a[$orderby], $b[$orderby] );
  // Send final sort direction to usort
  return ( $order === 'asc' ) ? $result : -$result;
}

function column_old_url($item){
  $actions = array(
          'edit'    => sprintf('<a href="'. admin_url("admin.php?page=%s&url=%s") .'">Edit</a>','wblm-edit-url',$item['id']),  
		  'delete'    => sprintf('<a href="'. admin_url("admin.php?page=%s&delURL=%s&url=%s") .'" onClick="return confirm(\'Are you sure you want to delete?\');">Delete</a>',$_REQUEST['page'],'on',$item['id']),
		  'log'    => sprintf('<a href="'. admin_url("admin.php?page=%s&url=%s") .'">Log</a>','wblm-log',$item['id']), 
		  'Waybackmachine'    => sprintf('<a href="http://web.archive.org/web/*/%s" target="_blank">Waybackmachine</a>',$item['old_url']), 

        );

  return sprintf('%1$s %2$s', $item['old_url'], $this->row_actions($actions) );
}

function get_bulk_actions() {
  $actions = array(
    'delete'    => 'Delete'
  );
  return $actions;
}

function column_cb($item) {
        return sprintf(
            '<input type="checkbox" name="url[]" value="%s" />', $item['ID']
        );    
}

function prepare_items($search=''){
global $wpdb;
 
$table_name = $wpdb->prefix . 'wblm';
$per_page = 20;
$columns = $this->get_columns();
$hidden = array();
$sortable = $this->get_sortable_columns();
 
$this->_column_headers = array($columns, $hidden, $sortable);
 
$paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
$orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'hit';
$order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';

if($search){    
$search = trim($search);
    
	$total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_name where `active` = '1' and old_url like '%$search%'");      
	$this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE `active` = '1' and (`old_url` LIKE '%%%s%%' OR `new_url` LIKE '%%%s%%') ", $search, $search), ARRAY_A);     
}else{
	$total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_name where `active` = '1' $search_filter");
	$this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name where `active` = '1' $search_filter ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
}

$this->set_pagination_args(array(
'total_items' => $total_items,
'per_page' => $per_page,
'total_pages' => ceil($total_items / $per_page),
));
}


} //class

?>
