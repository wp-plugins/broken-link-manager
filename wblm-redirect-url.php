<?php
global $WblmListTable;
$WblmListTable->prepare_items($_GET['s']);
?>
<div id="wrapper" class="wblm_tables">
	<!-- Navigation -->
	<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
		<div class="navbar-header">
			<a class="navbar-brand" href="<?php echo admin_url('admin.php?page=wblm-dashboard'); ?>">
			<?php echo WBLM_NAME; ?> <span> Ver <?php echo WBLM_VERSION; ?></span>
			</a>
		</div>
	</nav>
	<div id="page-wrapper">
		<div class="row">
			<div class="col-lg-12">
				<h3 class="page-header"><?php _e('Redirected URLs', 'wblm') ?></h3>
				<?php include WBLM_CONFIG_PATH . 'topnavi.php'; ?>
			</div>
			<!-- /.col-lg-12 -->
		</div>            
		<!-- /.row -->
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<?php _e('Redirected URLs', 'wblm') ?>
						<form method="get">
					    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
					    <?php $WblmListTable->search_box( 'search', 'search_id' ); ?>
						</form>
					</div>
					<!-- /.panel-heading -->
					<div class="panel-body">
						<div class="table-responsive">
						<?php $WblmListTable->display(); ?> 
						</div>
						<!-- /.table-responsive -->
					</div>
					<!-- /.panel-body -->
				</div>
				<!-- /.panel -->
			</div>
			<!-- /.col-lg-12 -->
		</div>            
	</div>
	<!-- /#page-wrapper -->
	<?php include WBLM_CONFIG_PATH . 'footer.php'; ?>
</div>