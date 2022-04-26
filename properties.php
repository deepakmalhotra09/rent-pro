<!DOCTYPE html>
<?php
session_start();
// include 'src/common/common_data.php';
include 'src/common/db_conn.php';
$user_id = $_SESSION['id'];
$sql = "SELECT rp.*, s.name as state_name FROM rentre_property as rp, state as s WHERE s.id = rp.state_id AND rp.user_id = '$user_id'";
$properties = $conn->query($sql);
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
              <div class="profile_info">
                <span><?=  $_SESSION['username']; ?></span>
              </div>
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
									<h2><?= $_SESSION['username']; ?>'s Properties
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
                                <th>Property Id </th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php while($row = $properties->fetch_assoc()){ ?>
                              <tr>
                                <td><?= $row['id']; ?></td>
                                <td><?= $row['name']; ?></td>
                                <td><?= $row['address_1']; ?></td>
                                <td><?= $row['city_name']; ?></td>
                                <td><?= $row['state_name']; ?></td>
                                <td>
                                  <a href="/add_property.php?p_id=<?= $row['id']; ?>">Edit</a> /
                                  <a href="/add_tenant.php?p_id=<?= $row['id']; ?>">Add Tenant</a> /
                                  <a href="/tenants.php?p_id=<?= $row['id']; ?>">View Tenant</a> /
                                  <a href="/my_invoices.php?p_id=<?= $row['id']; ?>">Check Invoices</a> /
                                  <a href="/my_income.php?p_id=<?= $row['id']; ?>">Income</a>
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
