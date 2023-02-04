  <!DOCTYPE html>
<?php
session_start();
include 'src/common/db_conn.php';
$user_id = $_SESSION['id'];
$r_id = 'RB'.$_REQUEST['r_id'];
$sql_invoice = "SELECT ri.*, rud.* FROM rentre_invoice as ri, rentre_user_details as rud WHERE ri.user_id = rud.user_id AND ri.receipt_id = '$r_id' AND ri.user_id = '$user_id'";
$invoice_details_query = $conn->query($sql_invoice);
$invoice_details = $invoice_details_query->fetch_object();
$sql_tenant = "SELECT rt.*, rp.address_1, rp.city_name, state.name as state_name FROM rentre_tenants as rt, rentre_property as rp, state WHERE rt.property_id = rp.id AND state.id = rp.state_id AND rt.id = '$invoice_details->tenant_id'";
$tenant_details_query = $conn->query($sql_tenant);
$tenant_details = $tenant_details_query->fetch_object();

$bill_to_user = ($invoice_details->rent + $invoice_details->elec_amount + $invoice_details->water_amount + $invoice_details->extra_amount) - $invoice_details->deduct_amount;
$bank_name = $beneficiary_name = $ifsc_code = $upi_id = $account_no = $upi_code = '';
if ($invoice_details->bank_details){
  $bd = json_decode($invoice_details->bank_details);
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
// print_r($invoice_details);die;
$d=strtotime($invoice_details->created_time);
$invoice_details_date = date("F j, Y", $d);
$due_date = date('F j, Y', strtotime($invoice_details_date. ' + 5 days'));
?>
<html lang="en">
<?php include 'src/common/template/header.php'; ?>
<style>
@media print
    {
        .top_nav { display: none !important;}
        .no-print, footer, button, .left_col {display: none !important;}
    }
    /* footer, .right_col, .top_nav{
      margin: 0 auto !important;
    } */
    /* .preview_invoice .right_col{
      padding: 10px 100px;
    } */
</style>
  <body class="nav-sm">
    <div class="container body preview_invoice">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="/" class="site_title"> <span>WhatsRent!</span></a>
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
          <div class="">
            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <!-- <div class="x_title">
                    <h2>Invoice Design <small>Sample user invoice design</small></h2>
                    <div class="clearfix"></div>
                  </div> -->
                  <div class="x_content">
                    <section class="content invoice">
                      <!-- title row -->
                      <div class="<?= $upi_code ? 'col-md-9' : 'col-md-12' ?>">
                        <div class="row">
                          <div class="  invoice-header">
                            <h1>
                                <i class="fa fa-home"></i> Rent Receipt
                                <?php if($invoice_details->status == '2'){ ?>
                                  (<small class="text-success">Paid</small>)
                                <?php } ?>
                                </br>
                                <small>
                                  <?= $invoice_details->rent_duration; ?>
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
                              <strong><?= ucfirst($invoice_details->name ? $invoice_details->name : $invoice_details->username); ?></strong></br>
                            </address>
                            PAN: <strong><?= $invoice_details->pan_no ?></strong></br>
                            Date: <strong><?= $invoice_details_date ?></strong></br>
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-4 invoice-col">
                            To
                            <address>
                                <strong><?= ucfirst($tenant_details->name) ?></strong>
                                <?php if($tenant_details->portion) { ?>
                                  <br>(<?= $tenant_details->portion; ?>)
                                <?php } ?>
                                <br>Address: <b><?= $tenant_details->address_1.', '.$tenant_details->city_name.', '.$tenant_details->state_name; ?></b>
                            </address>
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-4 invoice-col">
                            <b>Receipt Id: #<?= $invoice_details->receipt_id;; ?></b>
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
                      <div class="col-md-12" style="padding-top: 20px;">
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
                                  <td><i class="fa fa-rupee"></i> <strong><?= number_format($invoice_details->rent) ?></strong>
                                    <?php if($invoice_details->no_of_days){ echo " (Calculated rent for <strong>".$invoice_details->no_of_days."</strong> days.)"; } ?>
                                  </td>
                                  <td class="text-success"><i class="fa fa-rupee"></i> <?= number_format($invoice_details->rent) ?></td>
                                </tr>
                                <tr>
                                  <td>2</td>
                                  <td>Electricity</td>
                                  <td><i class="fa fa-rupee"></i> <strong><?= number_format($invoice_details->elec_amount) ?></strong>
                                    (<strong><?= $invoice_details->elec_units ?></strong> Units consumed x <strong><i class="fa fa-rupee"></i> <?= $invoice_details->elec_cost_p_u ?></strong> Per Unit Cost) </td>
                                  <td class="text-success"><i class="fa fa-rupee"></i> <?= number_format($invoice_details->elec_amount) ?></td>
                                </tr>
                                <tr>
                                  <td>3</td>
                                  <td>Water</td>
                                  <td><i class="fa fa-rupee"></i> <strong><?= number_format($invoice_details->water_amount) ?></strong></td>
                                  <td class="text-success"><i class="fa fa-rupee"></i> <?= number_format($invoice_details->water_amount) ?></td>
                                </tr>
                                <?php if($invoice_details->extra_amount){?>
                                  <tr>
                                    <td>4</td>
                                    <td>Extra Charges</td>
                                    <td><strong><?= $invoice_details->extra_comment; ?></strong></td>
                                    <td class="text-success"><i class="fa fa-rupee"></i> <?= number_format($invoice_details->extra_amount) ?></td>
                                  </tr>
                                <?php } ?>
                                <?php if($invoice_details->deduct_amount){?>
                                  <tr>
                                    <td><?= $invoice_details->extra_amount ? '5' : '4' ?></td>
                                    <td>Deductions</td>
                                    <td><strong><?= $invoice_details->deduct_comment; ?></strong></td>
                                    <td class="text-danger"><i class="fa fa-rupee"></i> <?= number_format($invoice_details->deduct_amount) ?></td>
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
                            <?php if ($invoice_details->status != '2') { ?>
                              <p class="lead">Due By: <?= $due_date; ?></p>
                            <?php } else { echo "<p class='lead'>&nbsp;</p>"; } ?>
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
                                    <?php if ($invoice_details->status == '2') { ?>
                                      <td style="border-top: none;"><img src="build/images/paid.png" height="64" width="80"/></td>
                                    <?php } ?>
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
                              <button class="btn btn-primary" onclick="window.print();"> Print</button>
                              <a class="btn btn-default" href="/"> Cancel</a>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <?php if($invoice_details->signature) { ?>
                            <table>
                              <th><div class="">Signature:</div></th>
                              <th>&nbsp;&nbsp;&nbsp;</th>
                              <th><img class="" height="150px" width="300px" src="<?= $invoice_details->signature ?>" /></th>
                            </table>
                          <?php }?>
                        </div>
                      </div>
                      <!-- this row will not appear when printing -->
                    </section>
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
  <script type="text/javascript">
    $('#bcPaint').bcPaint();
  </script>
</html>
