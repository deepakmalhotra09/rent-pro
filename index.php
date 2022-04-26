<!DOCTYPE html>
<?php
session_start();
include 'src/common/db_conn.php';
$user_id = $_SESSION['id'];

// Get count of properties
$sql = "SELECT count(*) as total_property FROM rentre_property WHERE user_id = '$user_id'";
$properties = $conn->query($sql);
$property_res = $properties->fetch_object();
$total_property = $property_res ? $property_res->total_property : 0;

// Get count of tenants
$sql_t = "SELECT count(*) as total_tenant FROM rentre_tenants WHERE user_id = '$user_id'";
$tenants = $conn->query($sql_t);
$tenant_res = $tenants->fetch_object();
$total_tenants = $tenant_res ? $tenant_res->total_tenant : 0;

// Get count of pending invoices
$s_p_i = "SELECT count(*) as total_p_i FROM rentre_invoice WHERE user_id = '$user_id' AND status = '1'";
$sql_p_i = $conn->query($s_p_i);
$p_i = $sql_p_i->fetch_object();
$total_p_i = $p_i ? $p_i->total_p_i : 0;

// Get count of paid invoices
$s_r_i = "SELECT count(*) as total_r_i FROM rentre_invoice WHERE user_id = '$user_id' AND status = '2'";
$sql_r_i = $conn->query($s_r_i);
$r_i = $sql_r_i->fetch_object();
$total_r_i = $r_i ? $r_i->total_r_i : 0;

// // Get count of cancelled invoices
// $s_c_i = "SELECT count(*) as total_c_i FROM rentre_invoice WHERE user_id = '$user_id' AND status = '3'";
// $sql_c_i = $conn->query($s_c_i);
// $c_i = $sql_c_i->fetch_object();
// $total_c_i = $c_i ? $c_i->total_c_i : 0;

?>
<html lang="en">
<?php include 'src/common/template/header.php'; ?>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <!-- <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella Alela!</span></a> -->
              <a href="/" class="site_title"> <span>RentBuzz!</span></a>
            </div>
            <div class="clearfix"></div>
            <!-- menu profile quick info -->
            <!-- <div class="profile clearfix">
            </div> -->
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
									<h2> <?= $_SESSION['username'] ?>'s Dashboard
                    <!-- <small>different form elements</small> -->
                  </h2>
									<div class="clearfix"></div>
								</div>
                <div class="x_content">
                  <div class="row">
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6  ">
                      <div class="tile-stats">
                        <div class="icon"><i class="fa fa-home text-primary"></i>
                        </div>
                        <div class="count"><?= $total_property ?></div>
                        <h3>
                          <a href="/add_property.php">Add</a> /
                          <a href="/properties.php">View</a>
                        </h3>
                        <p>Declared Properties</p>
                      </div>
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6  ">
                      <div class="tile-stats">
                        <div class="icon"><i class="fa fa-users"></i>
                        </div>
                        <div class="count"><?= $total_tenants ?></div>
                        <h3>
                          <a href="/add_tenant.php">Add</a> /
                          <a href="/tenants.php">View</a>
                        </h3>
                        <p>Declared Tenants</p>
                      </div>
                    </div>
        						</div>
        					</div>
                </div>
              </div>
            </div>
            <div class="row">
  						<div class="col-md-12 col-sm-12 ">
  							<div class="x_panel">
  								<div class="x_title">
  									<h2> Invoice Details
                      <!-- <small>different form elements</small> -->
                    </h2>
  									<div class="clearfix"></div>
  								</div>
                  <div class="x_content">
                    <div class="row">
                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6  ">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-book text-warning"></i>
                          </div>
                          <div class="count"><?= $total_p_i ?></div>
                          <h3>
                            <a href="/my_invoices.php?status=1">View</a>
                          </h3>
                          <p class="text-warning">Pending</p>
                        </div>
                      </div>
                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6  ">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-book text-success"></i>
                          </div>
                          <div class="count"><?= $total_r_i ?></div>
                          <h3>
                            <a href="/my_invoices.php?status=2">View</a>
                          </h3>
                          <p class="text-success">Received</p>
                        </div>
                      </div>
                      <!-- <div class="animated flipInY col-lg-3 col-md-3 col-sm-6  ">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-book text-danger"></i>
                          </div>
                          <div class="count"><?= $total_c_i ?></div>
                          <h3>
                            <a href="/my_invoices.php?status=3">View</a>
                          </h3>
                          <p class="text-danger">Cancelled</p>
                        </div>
                      </div> -->
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
    <!-- /footer content -->
  </body>
</html>
