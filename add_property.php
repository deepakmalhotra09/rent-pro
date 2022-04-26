<!DOCTYPE html>
<?php
session_start();
// include 'src/common/common_data.php';
include 'src/common/db_conn.php';
$user_id = $_SESSION['id'];
if(isset($_REQUEST['p_id'])){
  $property_id = $_REQUEST['p_id'];
  $sql = "SELECT * FROM rentre_property WHERE user_id = '$user_id' AND id = '$property_id'";
  $property_sql = $conn->query($sql);
  $property = $property_sql->fetch_object();
}
$sql = "SELECT * FROM state";
$state_result = $conn->query($sql);
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
									<h2>Add property
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
									<br />
									<form id="" data-parsley-validate class="form-horizontal form-label-left"
                  action="submit.php?type=add_property" method="post">
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="property-name">Property Name <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input name="property_name" value="<?= $property->name; ?>" type="text" id="property-name" required="required" class="form-control ">
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="address_1">Full Address <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="address_1" value="<?= $property->address_1; ?>" name="address_1" required="required" class="form-control">
											</div>
										</div>
                    <div class="item form-group">
											<label for="city" class="col-form-label col-md-3 col-sm-3 label-align">City <span class="required">*</span> </label>
											<div class="col-md-6 col-sm-6 ">
												<input id="city" value="<?= $property->city_name; ?>" class="form-control" type="text" name="city">
											</div>
										</div>
                    <div class="item form-group">
											<label for="state" class="col-form-label col-md-3 col-sm-3 label-align">State <span class="required">*</span> </label>
											<div class="col-md-6 col-sm-6 ">
												<select id="state" class="form-control"  name="state">
                          <option value="None">Select State</option>
                          <?php while ($data = $state_result->fetch_assoc()) {  ?>
                            <option value="<?= $data['id']; ?>" <?= $property->state_id == $data['id'] ? 'selected' : '' ?> "><?= $data['name']; ?></option>
                          <?php }  ?>
                        </select>
											</div>
										</div>
										<div class="ln_solid"></div>
										<div class="item form-group">
											<div class="col-md-6 col-sm-6 offset-md-3">
                        <button type="submit" class="btn btn-success">Add Property</button>
												<a class="btn btn-default" href="/">Cancel</a>
                        <?php if(isset($_REQUEST['error'])){ ?>
                        <code class="txt-danger">Please Try Again</code>
                      <?php } ?>
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
