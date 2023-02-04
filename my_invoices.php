<!DOCTYPE html>
<?php
session_start();
include 'src/common/db_conn.php';
include 'src/common/common_data.php';
$user_id = $_SESSION['id'];
if(isset($_REQUEST['t_id'])){
  $tenant_id = $_REQUEST['t_id'];
  $e_sql = "status != '0' AND tenant_id = $tenant_id";
}else if(isset($_REQUEST['p_id'])){
  $property_id = $_REQUEST['p_id'];
  $e_sql = "status != '0' AND property_id = $property_id";
}else if(isset($_REQUEST['status'])){
  $status = $_REQUEST['status'] + 1; // TODO: don't know why  did this, but need to check
  $e_sql = "status = $status";
}
else{
  $e_sql = "status != '0'";
}
$sql = "SELECT * FROM rentre_invoice WHERE user_id = '$user_id' AND $e_sql ORDER BY created_time desc";
// echo $sql;
$invoices = $conn->query($sql);
?>
<html lang="en">
<?php include 'src/common/template/header.php'; ?>
  <style>
    .txt-clr-1{
      color: rgba(243,156,18,0.88);
    }
    .txt-clr-2{
      color: rgba(38,185,154,0.88);
    }
    .txt-clr-3{
      color: rgba(231,76,60,0.88);
    }
  </style>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <!-- <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella Alela!</span></a> -->
              <a href="/" class="site_title"> <span>WhatsRent!</span></a>
            </div>
            <div class="clearfix"></div>
            <!-- /menu profile quick info -->
            <br />
            <!-- sidebar menu -->
            <?php include 'src/common/template/sidebar_menu.php'; ?>
            <!-- /sidebar menu -->
            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>
        <!-- top navigation -->
        <?php include 'src/common/template/top_navigation.php'; ?>
        <!-- /top navigation -->
        <!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
          <div class="row">
						<div class="col-md-12 col-sm-12 ">
							<div class="x_panel">
								<div class="x_title">
									<h2>Invoices
                    <!-- <small>different form elements</small> -->
                  </h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
										</li>
										<li><a class="close-link"><i class="fa fa-close"></i></a>
										</li>
									</ul>
									<div class="clearfix"></div>
								</div>
                <div class="x_content">
                  <div class="row">
                      <div class="col-sm-12">
                        <div class="card-box table-responsive">
                          <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                              <tr>
                                <th>Receipt Id </th>
                                <th>Tenant Name </th>
                                <th>Duration</th>
                                <th>Total Amount </th>
                                <th>Status </th>
                                <th>Update Status </th>
                                <th>Actions </th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php while($row = $invoices->fetch_assoc()){
                                // echo "<pre>";print_r($row);
                                $t_id = $row['tenant_id'];
                                $sql_t = "SELECT * FROM rentre_tenants WHERE id = $t_id";
                                $tenant_sql = $conn->query($sql_t);
                                $tenant = $tenant_sql->fetch_object();
                                ?>
                              <tr>
                                <td>#<?= $row['receipt_id']; ?></td>
                                <td><?= $tenant->name; ?></td>
                                <td><?= $row['rent_duration']; ?></td>
                                <td><i class="fa fa-rupee"></i> <?= number_format($row['total_amount']); ?></td>
                                <td class="txt-clr-<?= $row['status'] ?>"><b><?= $receipt_status_array[$row['status']]; ?></b></td>
                                <td>
                                  <?php if ($row['status'] == 1) {
                                     foreach ($receipt_status_array as $status => $status_text) {
                                    if($row['status'] != $status){ ?>
                                    <a href="/submit.php?type=update_invoice_status&r_id=<?= $row['receipt_id']; ?>&status=<?= $status ?>">
                                      <b><?= $receipt_status_array[$status]; ?></b>
                                    </a> /
                                  <?php } } } ?>
                                </td>
                                <td><a href="/preview_invoice.php?r_id=<?= substr($row['receipt_id'], 2); ?>">View Invoice</a>
                                    /
                                    <a href="/submit.php?type=delete_entry&id=<?= $row['id']; ?>&table_name=rentre_invoice">Delete</a>
                                </td>
                              </tr>
                            <?php } ?>
                            </tbody>
                          </table>
                        </div>
        							</div>
        						</div>
        					</div>
                </div>
              </div>
            </div>
          </div>
    <!-- footer content -->
    <?php include 'src/common/template/footer.php'; ?>
    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <!-- /footer content -->
  </body>
</html>
