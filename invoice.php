<!DOCTYPE html>
<?php
session_start();
include 'src/common/db_conn.php';
$user_id = $_SESSION['id'];
$user_id = $_SESSION['id'];
$sql_u = "SELECT ru.*, r_u_d.name, r_u_d.bank_details, r_u_d.pan_no, r_u_d.signature FROM rentre_user as ru, rentre_user_details as r_u_d WHERE ru.id = r_u_d.user_id AND ru.id = '$user_id'";
$user_query = $conn->query($sql_u);
$user = $user_query->fetch_object();
$bank_name = $beneficiary_name = $ifsc_code = $upi_id = $account_no = $upi_code = '';
if ($user->bank_details){
  $bd = json_decode($user->bank_details);
  $bank_name = $bd->bank_name;
  $account_no = $bd->account_no;
  $beneficiary_name = $bd->beneficiary_name;
  $ifsc_code = $bd->ifsc_code;
  $upi_id = $bd->upi_id;
  if ($upi_id){
    $upi_code = "https://upiqr.in/api/qr?name=".$beneficiary_name."&vpa=".$upi_id;
  }
}
// echo "<pre>";
// print_r($_REQUEST);
if(isset($_REQUEST['no_of_days']) && $_REQUEST['no_of_days'] > 0){
  $rent_duration =  date("d M Y", strtotime($_REQUEST['start_date'])).' - '.date("d M Y", strtotime($_REQUEST['end_date']));
}else{
  $rent_duration =  $_REQUEST['month'].' '.$_REQUEST['year'];
}
$bill_to_user = ($_REQUEST['rent'] + $_REQUEST['elec_amount'] + $_REQUEST['water_amount'] + $_REQUEST['extra_amount']) - $_REQUEST['deduct_amount'];
$receipt_id = 'RB'.time();
$current_date = date("F j, Y");
$due_date = date('F j, Y', strtotime($current_date. ' + 5 days'));
?>
<html lang="en">
<?php include 'src/common/template/header.php'; ?>
<style>
@media print
    {
        .top_nav { display: none !important; }
        .no-print {display: none !important;}
    }
</style>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="/" class="site_title"> <span>RentBuzz!</span></a>
            </div>
            <div class="clearfix"></div>
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
          <div class="">
            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <!-- <div class="x_title">
                    <h2>Invoice Design <small>Sample user invoice design</small></h2>
                    <div class="clearfix"></div>
                  </div> -->
                  <div class="x_content">
                      <form action="submit.php?type=save_receipt" method="POST">
                      <input type="hidden" name="r_id" = value="<?= $receipt_id ?>" />
                      <input type="hidden" name="tenant_id" = value="<?= $_REQUEST['tenant_id'] ?>" />
                      <input type="hidden" name="property_id" = value="<?= $_REQUEST['property_id'] ?>" />
                      <input type="hidden" name="rent" = value="<?= $_REQUEST['rent'] ?>" />
                      <input type="hidden" name="total_amount" = value="<?= $bill_to_user ?>" />
                      <input type="hidden" name="rent_duration" = value="<?= $rent_duration ?>" />
                      <input type="hidden" name="no_of_days" = value="<?= $_REQUEST['no_of_days'] ?>" />
                      <input type="hidden" name="elec_amount" = value="<?= $_REQUEST['elec_amount'] ?>" />
                      <input type="hidden" name="elec_units" = value="<?= $_REQUEST['elec_units'] ?>" />
                      <input type="hidden" name="elec_cost_p_u" = value="<?= $_REQUEST['elec_cost_p_u'] ?>" />
                      <input type="hidden" name="water_amount" = value="<?= $_REQUEST['water_amount'] ?>" />
                      <input type="hidden" name="extra_amount" = value="<?= $_REQUEST['extra_amount'] ?>" />
                      <input type="hidden" name="extra_comment" = value="<?= $_REQUEST['extra_comment'] ?>" />
                      <input type="hidden" name="deduct_amount" = value="<?= $_REQUEST['deduct_amount'] ?>" />
                      <input type="hidden" name="deduct_comment" = value="<?= $_REQUEST['deduct_comment'] ?>" />
                      <input type="hidden" name="bank_details[bank_name]" = value="<?= $bank_name ?>" />
                      <input type="hidden" name="bank_details[account_no]" = value="<?= $account_no ?>" />
                      <input type="hidden" name="bank_details[beneficiary_name]" = value="<?= $beneficiary_name ?>" />
                      <input type="hidden" name="bank_details[ifsc_code]" = value="<?= $ifsc_code ?>" />
                      <input type="hidden" name="bank_details[upi_id]" = value="<?= $upi_id ?>" />
                      <input type="hidden" name="upi_code" = value="<?= $upi_code ?>" />

                      <section class="content invoice">
                        <!-- title row -->
                        <div class="<?= $upi_code ? 'col-md-9' : 'col-md-12' ?>">
                          <div class="row">
                            <div class="  invoice-header">
                              <h1>
                                  <i class="fa fa-home"></i> Rent Receipt</br>
                                  <small>
                                    <?= $rent_duration ?>
                                  </small>
                              </h1>
                            </div>
                            <!-- /.col -->
                          </div>
                          <!-- info row -->
                          <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                              From
                              <address>
                                  <strong><?= ucfirst($user->name ? $user->name : $user->username); ?></strong>
                              </address>
                              PAN: <strong><?= $user->pan_no ?></strong></br>
                              Date: <strong><?= date("F j, Y"); ?></strong></br>
                              <!-- Due Date: <strong><?= date("F j, Y"); ?></strong> -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                              To
                              <address>
                                  <strong><?= ucfirst($_REQUEST['tenant_name']) ?></strong>
                                  <?php if($_REQUEST['tenant_portion']) { ?>
                                    <br>(<?= $_REQUEST['tenant_portion']; ?>)
                                  <?php } ?>
                                  <br>Address: <b><?= $_REQUEST['address'].', '.$_REQUEST['city'].', '.$_REQUEST['state']; ?></b>
                              </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                              <b>Receipt Id: #<?= $receipt_id; ?></b>
                              <br><br>
                              <?php if($upi_code){ ?>
                                <b>Scan Using UPI <i class="fa fa-long-arrow-right"></i></b>
                              <?php } ?>
                            </div>
                            <!-- /.col -->
                          </div>
                        </div>
                        <?php if($upi_code){ ?>
                          <div class="col-sm-3">
                            <div class="text-center"><strong><?= $beneficiary_name ?></strong></div>
                            <div><img src="<?= $upi_code; ?>" height="250px" width="250px" class="float-right"/></div>
                            <div class="text-center"><strong><?= $upi_id ?></strong></div>
                          </div>
                        <?php }?>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="col-md-12">
                          <div class="row">
                            <div class="  table">
                              <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th>Sr.</th>
                                    <th>Type</th>
                                    <th style="width: 59%">Description</th>
                                    <th>Subtotal</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>1</td>
                                    <td>House Rent</td>
                                    <td><i class="fa fa-rupee"></i> <strong><?= number_format($_REQUEST['rent']) ?></strong>
                                      <?php if($_REQUEST['no_of_days']){ echo " (Calculated rent for <strong>".$_REQUEST['no_of_days']."</strong> days.)"; } ?>
                                    </td>
                                    <td class="text-success"><i class="fa fa-rupee"></i> <?= number_format($_REQUEST['rent']) ?></td>
                                  </tr>
                                  <tr>
                                    <td>2</td>
                                    <td>Electricity</td>
                                    <td><i class="fa fa-rupee"></i> <strong><?= number_format($_REQUEST['elec_amount']) ?></strong>
                                      (<strong><?= $_REQUEST['elec_units'] ?></strong> Units consumed x <strong><i class="fa fa-rupee"></i> <?= $_REQUEST['elec_cost_p_u'] ?></strong> Per Unit Cost) </td>
                                    <td class="text-success"><i class="fa fa-rupee"></i> <?= number_format($_REQUEST['elec_amount']) ?></td>
                                  </tr>
                                  <tr>
                                    <td>3</td>
                                    <td>Water</td>
                                    <td><i class="fa fa-rupee"></i> <strong><?= number_format($_REQUEST['water_amount']) ?></strong></td>
                                    <td class="text-success"><i class="fa fa-rupee"></i> <?= number_format($_REQUEST['water_amount']) ?></td>
                                  </tr>
                                  <?php if($_REQUEST['extra_amount']){?>
                                    <tr>
                                      <td>4</td>
                                      <td>Extra Charges</td>
                                      <td><strong><?= $_REQUEST['extra_comment']; ?></strong></td>
                                      <td class="text-success"><i class="fa fa-rupee"></i> <?= number_format($_REQUEST['extra_amount']) ?></td>
                                    </tr>
                                  <?php } ?>
                                  <?php if($_REQUEST['deduct_amount']){?>
                                    <tr>
                                      <td><?= $_REQUEST['extra_amount'] ? '5' : '4' ?></td>
                                      <td>Deductions</td>
                                      <td><strong><?= $_REQUEST['deduct_comment']; ?></strong></td>
                                      <td class="text-danger"><i class="fa fa-rupee"></i> <?= number_format($_REQUEST['deduct_amount']) ?></td>
                                    </tr>
                                  <?php } ?>
                                  <tr>
                                    <td></td>
                                    <td></td>
                                    <td><span class="float-right">Total Amount: </span></td>
                                    <td><strong><i class="fa fa-rupee"></i> <?= number_format($bill_to_user) ?></strong></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <!-- /.col -->
                          </div>
                        </div>
                        <!-- /.row -->
                        <div class="col-md-12">
                          <div class="row">
                            <!-- accepted payments column -->
                            <?php if(isset($bd)){ ?>
                            <div class="col-md-6">
                              <p class="lead"><i class="fa fa-bank"></i> Bank Account:</p>
                              <?php if($bank_name && $beneficiary_name && $ifsc_code){ ?>
                              <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                Bank Name: <?= $bank_name ?></br>
                                Account No: <?= $account_no ?></br>
                                Beneficiary Name: <?= $beneficiary_name ?></br>
                                IFSC Code: <?= $ifsc_code?>
                              </p>
                              <?php } ?>
                            </div>
                          <?php }?>
                            <!-- /.col -->
                            <div class="col-md-6">
                              <p class="lead">Due By: <?= $due_date ?> </p>
                              <div class="table-responsive">
                                <table class="table">
                                  <tbody>
                                    <tr>
                                      <th style="width:50%">Subtotal:</th>
                                      <td><i class="fa fa-rupee"></i> <?= number_format($bill_to_user) ?></td>
                                    </tr>
                                    <tr>
                                      <th>Miscellaneous Charges:</th>
                                      <td><i class="fa fa-rupee"></i> 0</td>
                                    </tr>
                                    <tr>
                                      <th>Total:</th>
                                      <td><i class="fa fa-rupee"></i> <?= number_format($bill_to_user) ?></td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <!-- /.col -->
                          </div>
                        </div>
                        <!-- /.row -->
                          <div class="col-md-12">
                            <div class="col-md-6">
                              <div class="row no-print">
                                <div class="">
                                  <button class="btn btn-primary" type="submit"> Save & Preview</button>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <?php if($user->signature) { ?>
                                <table>
                                  <th><div class="">Signature:</div></th>
                                  <th>&nbsp;&nbsp;&nbsp;</th>
                                  <th><img class="" height="150px" width="300px" src="<?= $user->signature ?>" /></th>
                                </table>
                              <?php }?>
                            </div>
                          </div>
                        <!-- this row will not appear when printing -->
                      </section>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
      </div>
    </div>
    <!-- footer content -->
    <?php include 'src/common/template/footer.php'; ?>
    <!-- /footer content -->
  </body>
</html>
