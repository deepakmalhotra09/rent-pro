<!DOCTYPE html>
<?php
session_start();
// include 'src/common/common_data.php';
include 'src/common/db_conn.php';
$user_id = $_SESSION['id'];
$add_tenant = isset($_REQUEST['p_id']) ? 1 : 0;
$property_id = $_REQUEST['p_id'];
$tenant_id = $_REQUEST['t_id'];
if(!$tenant_id){
  if(!$add_tenant){
    $sql = "SELECT * FROM rentre_property WHERE user_id = '$user_id'";
    $properties = $conn->query($sql);
  }else{
    $sql = "SELECT * FROM rentre_property WHERE user_id = '$user_id' AND id = '$property_id'";
    $property_sql = $conn->query($sql);
    $property = $property_sql->fetch_object();
  }
}else{
  $e_sql = "AND rt.property_id = $property_id";
  $sql = "SELECT rt.*, rp.address_1 as property_address, rp.city_name as city_name, rp.name as property_name, rp.id as p_id
   FROM rentre_property as rp, rentre_tenants as rt WHERE rt.property_id = rp.id AND rt.id = '$tenant_id' AND rt.user_id = '$user_id' $e_sql";
  $tenant_sql = $conn->query($sql);
  $tenant = $tenant_sql->fetch_object();
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
              <!-- <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella Alela!</span></a> -->
              <a href="/" class="site_title"> <span>WhatsRent!</span></a>
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
									<h2>
                    <?= $add_tenant ? 'Add Tenant' : 'Select Property to add Tenant'; ?>
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
                  <?php if($add_tenant){ ?>
									<form id="" data-parsley-validate class="form-horizontal form-label-left"
                  action="<?= $tenant_id ? 'submit.php?type=update_tenant' : 'submit.php?type=add_tenant' ?>" method="post">
                    <input type="hidden" value="<?= $tenant->id ?>" name="tenant_id" />
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="property-name">Property Name
											</label>
                      <label class="col-form-label col-md-2 col-sm-2 float-left font-weight-bold" for="property-name"><?= $tenant_id ? $tenant->property_name : $property->name; ?>
                        <input type="hidden" name="property_id" value="<?= $property_id ?>" />
                      </label>
										</div>
                    <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align floa" for="property-address">Property Address
											</label>
                      <label class="col-form-label col-md-4 float-left col-sm-2 font-weight-bold" for="property-address"><?= $tenant_id ? $tenant->property_address.', '.$tenant->city_name : $property->address_1.', '. $property->city_name; ?>
                      </label>
										</div>
                    <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="tenant-name">Portion (if any)
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input name="tenant_portion" value="<?= $tenant->portion; ?>" type="text" id="tenan-portion" class="form-control" placeholder="for eg: First Floor/ Second Floor .. etc">
											</div>
										</div>
                    <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="tenant-name">Tenant Name <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input name="tenant_name" type="text" value="<?= $tenant->name; ?>" id="tenan-name" required="required" class="form-control ">
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="aadhar">Aadhar No <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="number" id="aadhar" value="<?= $tenant->aadhar_no; ?>" name="aadhar" required="required" class="form-control">
											</div>
										</div>
                    <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="amount">Monthly Rent <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="number" id="amount" value="<?= $tenant->amount; ?>" name="amount" required="required" class="form-control">
											</div>
										</div>
                    <div class="item form-group">
											<label for="city" class="col-form-label col-md-3 col-sm-3 label-align">Rent Starts From <span class="required">*</span> </label>
											<div class="col-md-6 col-sm-6 ">
                        <input id="start_date" name="start_date" value="<?= $tenant->start_date; ?>" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" required="required" type="text" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)">
												<script>
													function timeFunctionLong(input) {
														setTimeout(function() {
															input.type = 'text';
														}, 60000);
													}
												</script>
											</div>
										</div>
										<div class="ln_solid"></div>
										<div class="item form-group">
											<div class="col-md-6 col-sm-6 offset-md-3">
                        <button type="submit" class="btn btn-success"><?= $tenant_id ? 'Update' : 'Add Tenant' ?></button>
												<a class="btn btn-default" type="button" href="/">Cancel</a>
                        <?php if(isset($_REQUEST['error'])){ ?>
                        <code class="txt-danger">Please Try Again</code>
                      <?php } ?>
											</div>
										</div>
									</form>
                <?php } else {?>
                  <div class="item form-group">
                    <label for="property" class="col-form-label col-md-3 col-sm-3 label-align">Property <span class="required">*</span> </label>
                    <div class="col-md-6 col-sm-6 ">
                      <select id="property" class="form-control"  name="property">
                        <option value="0">Select Property</option>
                        <?php while ($data = $properties->fetch_assoc()) {  ?>
                          <option value="<?= $data['id']; ?>"><?= $data['name']; ?></option>
                        <?php }  ?>
                      </select>
                    </div>
                  </div>
                <?php } ?>
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
<script>
$( document ).ready(function() {
  $('#property').on('change', function(){
    window.location.replace("/add_tenant.php?p_id="+this.value);
  });
});
</script>
