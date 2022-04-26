<!DOCTYPE html>
<?php
session_start();
// include 'src/common/common_data.php';
include 'src/common/db_conn.php';
$user_id = $_SESSION['id'];
$sql_u = "SELECT ru.*, r_u_d.name, r_u_d.bank_details, r_u_d.pan_no, r_u_d.signature FROM rentre_user as ru, rentre_user_details as r_u_d WHERE ru.id = r_u_d.user_id AND ru.id = '$user_id'";
$user_query = $conn->query($sql_u);
$user = $user_query->fetch_object();
$bank_name = $beneficiary_name = $ifsc_code = $upi_id = $account_no = '';
if ($user->bank_details){
  $bd = json_decode($user->bank_details);
  $bank_name = $bd->bank_name;
  $account_no = $bd->account_no;
  $beneficiary_name = $bd->beneficiary_name;
  $ifsc_code = $bd->ifsc_code;
  $upi_id = $bd->upi_id;
}

?>
<html lang="en">
<?php include 'src/common/template/header.php'; ?>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="/" class="site_title"> <span>RentBuzz!</span></a>
              <!-- <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella Alela!</span></a> -->
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
									<h2>
                    User Details
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
									<br />
									<form id="" data-parsley-validate class="form-horizontal form-label-left"
                  action="invoice.php" method="post">
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="tenant-name">Username
											</label>
                      <label class="col-form-label col-md-2 col-sm-2 label-align font-weight-bold text-left" for="tenant-name"><?= $_SESSION['username']; ?>
                      </label>
										</div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="p_address">Full Name
											</label>
                      <label class="col-form-label col-md-3 col-sm-3 label-align font-weight-bold text-left" for="p_address"><?= $user->name; ?>
										</div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="pan">PAN Number
											</label>
                      <label class="col-form-label col-md-3 col-sm-3 label-align font-weight-bold text-left" for="pan"><?= $user->pan_no; ?>
										</div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="tenant-name">Bank Name
											</label>
                      <label class="col-form-label col-md-2 col-sm-2 label-align font-weight-bold text-left" for="tenant-name"><?= $bank_name; ?>
										</div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="tenant-name">Account Number
											</label>
                      <label class="col-form-label col-md-2 col-sm-2 label-align font-weight-bold text-left" for="tenant-name"><?= $account_no; ?>
										</div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="tenant-name">Beneficiery Name
											</label>
                      <label class="col-form-label col-md-2 col-sm-2 label-align font-weight-bold text-left" for="tenant-name"><?= $beneficiary_name; ?>
										</div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="tenant-name">IFSC Code
											</label>
                      <label class="col-form-label col-md-2 col-sm-2 label-align font-weight-bold text-left" for="tenant-name"><?= $ifsc_code; ?>
										</div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="tenant-name">UPI Id
											</label>
                      <label class="col-form-label col-md-2 col-sm-2 label-align font-weight-bold text-left" for="tenant-name"><?= $upi_id; ?>
										</div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="tenant-name">Signature
											</label>
                      <div class="col-md-6 col-sm-6 ">
												<img src="<?= $user->signature ?>" />
											</div>
										</div>
										<div class="ln_solid"></div>
										<div class="item form-group">
											<div class="col-md-6 col-sm-6 offset-md-3">
                        <a type="button" href="/update_profile.php" class="btn btn-success">Update</a>
												<a class="btn btn-default" type="button" href="/">Cancel</a>
                        <!-- <code>Please make any changes regarding Property, Tenant and Rents in their Profile.*</code> -->
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
        </div>
      </div>
    </div>
    <!-- footer content -->
    <?php include 'src/common/template/footer.php'; ?>
    <!-- /footer content -->
  </body>
</html>
