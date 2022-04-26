<!DOCTYPE html>
<?php
session_start();
// include 'src/common/common_data.php';
include 'src/common/db_conn.php';
$user_id = $_SESSION['id'];
$property_id = $_REQUEST['p_id'];
$tenant_id = $_REQUEST['t_id'];
$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
if(!$property_id || !$tenant_id || !$user_id){
  header('Location: /');
}else{
  // get property
  $sql = "SELECT rp.*, st.name as state_name FROM rentre_property as rp, state as st WHERE rp.state_id = st.id AND rp.user_id = '$user_id' AND rp.id = '$property_id'";
  $property_sql = $conn->query($sql);
  $property = $property_sql->fetch_object();

  // get property
  $sql_t = "SELECT * FROM rentre_tenants WHERE user_id = '$user_id' AND id = '$tenant_id'";
  $tenant_sql = $conn->query($sql_t);
  $tenant = $tenant_sql->fetch_object();
}

$year =  (int)date("Y") -1 ;

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
                    Make Receipt for <?= $tenant->name ?>
                    <br />
                    <small><code>If dates are selected in duration then Rent amount will be calculated accordingly.</code></small>
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
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="tenant-name">Property Name
											</label>
                      <label class="col-form-label col-md-2 col-sm-2 label-align font-weight-bold text-left" for="tenant-name"><?= $property->name; ?>
                        <input type="hidden" name="property_id" value="<?= $property_id ?>" />
                        <input type="hidden" name="tenant_id" value="<?= $tenant_id ?>" />
                        <input type="hidden" name="property_name" value="<?= $property->name ?>" />
                        <input type="hidden" name="address" value="<?= $property->address_1 ?>" />
                        <input type="hidden" name="tenant_portion" value="<?= $tenant->portion ?>" />
                        <input type="hidden" name="city" value="<?= $property->city_name ?>" />
                        <input type="hidden" name="state" value="<?= $property->state_name ?>" />
                        <input type="hidden" name="tenant_name" value="<?= $tenant->name ?>" />
                        <input type="hidden" name="tenant_id" value="<?= $tenant->id ?>" />
                        <input type="hidden" name="tenant_aadhar" value="<?= $tenant->aadhar_no ?>" />
                        <input type="hidden" id="no_of_days" name="no_of_days" value="0" />
                      </label>
										</div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="p_address">Address
											</label>
                      <label class="col-form-label col-md-3 col-sm-3 label-align font-weight-bold text-left" for="p_address"><?= $property->address_1 .', '. $property->city_name .', '. $property->state_name; ?>
										</div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="p_address">Portion
											</label>
                      <label class="col-form-label col-md-3 col-sm-3 label-align font-weight-bold text-left" for="p_address"><?= $tenant->portion; ?>
										</div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="tenant-name">Tenant Name
											</label>
                      <label class="col-form-label col-md-2 col-sm-2 label-align font-weight-bold text-left" for="tenant-name"><?= $tenant->name; ?>
										</div>
										<!-- <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="aadhar">Aadhar No <span class="required">*</span>
											</label>
											<label class="col-form-label col-md-3 col-sm-2 label-align font-weight-bold text-left" for="tenant-name"><?= $tenant->aadhar_no; ?>
										</div> -->
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="tenant-name">Rent
											</label>
                      <?php
                        setlocale(LC_MONETARY, 'en_IN');
                        $amount = money_format('%!i', $tenant->amount);
                      ?>
                      <label id="rent_text" class="col-form-label col-md-3 col-sm-2 label-align font-weight-bold text-left" for="tenant-name">INR <?= $amount ?></label>
                      <input type="hidden" id="rent_value" name="rent" value="<?= $tenant->amount?>">
										</div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="tenant-name">Electricity (Charges)*
											</label>
                      <div class="col-md-2 col-sm-4 ">
                        <input type="number" id="elec_units" step=".01" name="elec_units" required="required" placeholder="Units" class="form-control" onblur="cal_elec_amount()">
                      </div>
                      <div class="col-md-2 col-sm-4 ">
                        <input type="number" id="elec_cost_p_u" step=".01" name="elec_cost_p_u" required="required" placeholder="Cost Per Unit" class="form-control" onblur="cal_elec_amount()">
                      </div>
                      <div class="col-md-5 col-sm-5">
                        <input type="number" id="elec_amount" step=".01" readonly="true" name="elec_amount" required="required" placeholder="Amount" class="form-control col-md-3">
                      </div>
										</div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="tenant-name">Water (Charges)
											</label>
                      <div class="col-md-2 col-sm-4 ">
                        <input type="number" name="water_amount" step=".01" placeholder="Amount" class="form-control">
                      </div>
										</div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="tenant-name">Extra (Charges) if any
											</label>
                      <div class="col-md-2 col-sm-4 ">
                        <input type="number" id="amount" step=".01" name="extra_amount" placeholder="Amount" class="form-control">
                      </div>
                      <div class="col-md-5 col-sm-4 ">
                        <input type="text" id="amount" name="extra_comment" placeholder="Comment" class="form-control">
                      </div>
										</div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="tenant-name">Corrections if any
											</label>
                      <div class="col-md-2 col-sm-4 ">
                        <input type="number" id="deduct_amount" step=".01" name="deduct_amount" placeholder="Amount" class="form-control">
                      </div>
                      <div class="col-md-5 col-sm-4 ">
                        <input type="text" id="deduct_comment" name="deduct_comment" placeholder="Explain the deductions" class="form-control">
                      </div>
										</div>
                    <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="amount">Duration<span class="required">*</span>
											</label>
                      <div class="col-md-2 col-sm-6 ">
                        <select class="form-control" name="month">
                          <option value="None"> Select Month </option>
                          <?php for ($i=0; $i < count($months) ; $i++) { ?>
                            <option value="<?= $months[$i]; ?>"> <?= $months[$i]; ?> </option>
                          <?php } ?>
                        </select>
											</div>
                      <div class="col-md-2 col-sm-6 ">
                        <select class="form-control" name="year">
                          <option value="None"> Select Year </option>
                          <?php for ($i=$year; $i < ($year + 5) ; $i++) { ?>
                            <option value="<?= $i; ?>"> <?= $i; ?> </option>
                          <?php } ?>
                        </select>
											</div>
                      <label class="col-form-label col-md-1 col-sm-6 text-center">OR</label>
                      <div class="col-md-2 col-sm-6 ">
                        <input id="start_date" name="start_date" class="date-picker form-control" placeholder="dd/mm/yyyy" type="text" type="text" onfocus="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)">
											</div>
                      <div class="col-md-2 col-sm-6 ">
                        <input id="end_date" name="end_date" class="date-picker form-control" placeholder="dd/mm/yyyy" type="text" type="text" onfocus="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)">
											</div>
										</div>
										<div class="ln_solid"></div>
										<div class="item form-group">
											<div class="col-md-6 col-sm-6 offset-md-3">
                        <button type="submit" class="btn btn-success">Continue</button>
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
<script>
$( document ).ready(function() {
  $('#property').on('change', function(){
    window.location.replace("/add_tenant.php?p_id="+this.value);
  });
});
function cal_elec_amount(){
  var elec_units = $('#elec_units').val();
  var elec_cost_p_u = $('#elec_cost_p_u').val();
  if(elec_cost_p_u && elec_units){
    $('#elec_amount').val(elec_units * elec_cost_p_u);
  }else{
    $('#elec_amount').val(0);
  }
}
function timeFunctionLong(input) {
  setTimeout(function() {
    var per_day_rent = '<?= $tenant->amount / 30 ?>';
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();
    if (start_date && end_date){
      // To set two dates to two variables
      var start_dt = new Date(start_date);
      var end_dt = new Date(end_date);
      // To calculate the time difference of two dates
      var Difference_In_Time = end_dt.getTime() - start_dt.getTime();
      // To calculate the no. of days between two dates
      var rent_days = (Difference_In_Time / (1000 * 3600 * 24) + 1);
      var calculated_rent = parseInt(per_day_rent * rent_days);
      $('#no_of_days').val(rent_days);
      $('#rent_value').val(calculated_rent);
      $('#rent_text').html('INR '+ calculated_rent + ' calculated for duration');
    }
    input.type = 'text';
  }, 600);
}
</script>
