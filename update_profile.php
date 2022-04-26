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
<head>
  <style>
    #sig-canvas {
      border: 2px dotted #CCCCCC;
      border-radius: 15px;
      cursor: crosshair;
    }
  </style>
</head>
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
									<form id="hide-sign-cont" data-parsley-validate class="form-horizontal form-label-left"
                  action="/submit.php?type=update_profile" method="post">
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="tenant-name">Username
											</label>
                      <label class="col-form-label col-md-2 col-sm-2 label-align font-weight-bold text-left" for="tenant-name"><?= $_SESSION['username']; ?>
                      </label>
										</div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="p_address">Full Name *
											</label>
                      <div class="col-md-6 col-sm-6 ">
												<input type="text" name="full_name" required="required" value="<?= $user->name ?>" class="form-control">
											</div>
										</div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="pan_no">PAN Number *
											</label>
                      <div class="col-md-6 col-sm-6 ">
												<input type="text" name="pan_no" for="pan_no" required="required" value="<?= $user->pan_no ?>" class="form-control">
											</div>
										</div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="tenant-name">Bank Name
											</label>
                      <div class="col-md-6 col-sm-6 ">
												<input type="text" name="bank_name" class="form-control" value="<?= $bank_name ?>" placeholder="for eg: HDFC, AXIS, ICICI etc.">
											</div>
										</div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="tenant-name">Account No
											</label>
                      <div class="col-md-6 col-sm-6 ">
												<input type="text" name="account_no" class="form-control" value="<?= $account_no ?>">
											</div>
										</div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="tenant-name">Beneficiary Name
											</label>
                      <div class="col-md-6 col-sm-6 ">
												<input type="text" name="beneficiary_name" class="form-control" value="<?= $beneficiary_name ?>" placeholder="Please Enter Beneficiary Name of Account holder">
											</div>
										</div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="tenant-name">IFSC Code
											</label>
                      <div class="col-md-6 col-sm-6 ">
												<input type="text" name="ifsc_code" class="form-control" value="<?= $ifsc_code ?>" placeholder="for eg: HDFC0000111">
											</div>
										</div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="tenant-name">UPI Id
											</label>
                      <div class="col-md-6 col-sm-6 ">
												<input type="text" name="upi_id" placeholder="for eg: abc@icici" value="<?= $upi_id ?>" class="form-control">
											</div>
										</div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="tenant-name">Signature
											</label>
                      <div class="col-md-6 col-sm-6 ">
												<img src="<?= $user->signature ?>" />
											</div>
										</div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="tenant-name">
											</label>
                      <div class="col-md-6 col-sm-6 ">
												<a href="#uploadsign" id="new-signature" data-rel="popup" data-position-to="window" data-role="button" data-inline="true" >Upload New Signature</a>
											</div>
										</div>
										<div class="ln_solid"></div>
										<div class="item form-group">
											<div class="col-md-6 col-sm-6 offset-md-3">
                        <button type="submit" class="btn btn-success">Submit</button>
												<a class="btn btn-default" type="button" href="/profile.php">Cancel</a>
                      </br>Note: <small>We are collecting bank information only to show on Rent Receipt and it's Optional.</small>
                        <!-- <code>Please make any changes regarding Property, Tenant and Rents in their Profile.*</code> -->
											</div>
										</div>
									</form>
                  <form class="d-none" id="new-sign-cont" action="/submit.php?type=update_signature" method="post">
                    <input type="hidden" name="signature" value="<?= $user->signature ?>" class="form-control new_signature_input">
                    <div class="col-md-6 col-sm-6">
                      <div class="container">
                        <div class="row">
                          <div class="col-md-12">
                            <canvas id="sig-canvas" width="420" height="150">
                              Get a better browser, bro.
                            </canvas>
                          </div>
                        </div>
                      </br>
                        <div class="row">
                          <div class="col-md-12">
                            <a class="btn btn-success text-light" type="button" id="sig-submitBtn">Submit</a>
                            <a class="btn btn-warning text-light" type="button" id="sig-clearBtn">Clear</a>
                            <a class="btn btn-danger text-light" type="button" id="sig-clearBtn" onClick="window.location.reload();">Cancel</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <div class="row">
                        <div class="col-md-12">
                          <img src="" id="sig-image" />
                        </div>
                      </div>
                      <div class="row d-none" id="upload-sign-btn">
                        <div class="col-md-12">
                          <button class="btn btn-success" type="submit">Upload</button>
                        </div>
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
  <script>
    (function() {
    window.requestAnimFrame = (function(callback) {
      return window.requestAnimationFrame ||
        window.webkitRequestAnimationFrame ||
        window.mozRequestAnimationFrame ||
        window.oRequestAnimationFrame ||
        window.msRequestAnimaitonFrame ||
        function(callback) {
          window.setTimeout(callback, 1000 / 60);
        };
    })();

    var canvas = document.getElementById("sig-canvas");
    var ctx = canvas.getContext("2d");
    ctx.strokeStyle = "#222222";
    ctx.lineWidth = 4;

    var drawing = false;
    var mousePos = {
      x: 0,
      y: 0
    };
    var lastPos = mousePos;

    canvas.addEventListener("mousedown", function(e) {
      drawing = true;
      lastPos = getMousePos(canvas, e);
    }, false);

    canvas.addEventListener("mouseup", function(e) {
      drawing = false;
    }, false);

    canvas.addEventListener("mousemove", function(e) {
      mousePos = getMousePos(canvas, e);
    }, false);

    // Add touch event support for mobile
    canvas.addEventListener("touchstart", function(e) {

    }, false);

    canvas.addEventListener("touchmove", function(e) {
      var touch = e.touches[0];
      var me = new MouseEvent("mousemove", {
        clientX: touch.clientX,
        clientY: touch.clientY
      });
      canvas.dispatchEvent(me);
    }, false);

    canvas.addEventListener("touchstart", function(e) {
      mousePos = getTouchPos(canvas, e);
      var touch = e.touches[0];
      var me = new MouseEvent("mousedown", {
        clientX: touch.clientX,
        clientY: touch.clientY
      });
      canvas.dispatchEvent(me);
    }, false);

    canvas.addEventListener("touchend", function(e) {
      var me = new MouseEvent("mouseup", {});
      canvas.dispatchEvent(me);
    }, false);

    function getMousePos(canvasDom, mouseEvent) {
      var rect = canvasDom.getBoundingClientRect();
      return {
        x: mouseEvent.clientX - rect.left,
        y: mouseEvent.clientY - rect.top
      }
    }

    function getTouchPos(canvasDom, touchEvent) {
      var rect = canvasDom.getBoundingClientRect();
      return {
        x: touchEvent.touches[0].clientX - rect.left,
        y: touchEvent.touches[0].clientY - rect.top
      }
    }

    function renderCanvas() {
      if (drawing) {
        ctx.moveTo(lastPos.x, lastPos.y);
        ctx.lineTo(mousePos.x, mousePos.y);
        ctx.stroke();
        lastPos = mousePos;
      }
    }

    // Prevent scrolling when touching the canvas
    document.body.addEventListener("touchstart", function(e) {
      if (e.target == canvas) {
        e.preventDefault();
      }
    }, false);
    document.body.addEventListener("touchend", function(e) {
      if (e.target == canvas) {
        e.preventDefault();
      }
    }, false);
    document.body.addEventListener("touchmove", function(e) {
      if (e.target == canvas) {
        e.preventDefault();
      }
    }, false);

    (function drawLoop() {
      requestAnimFrame(drawLoop);
      renderCanvas();
    })();

    function clearCanvas() {
      canvas.width = canvas.width;
    }

    // Set up the UI
    var sigText = document.getElementById("sig-dataUrl");
    var sigImage = document.getElementById("sig-image");
    var clearBtn = document.getElementById("sig-clearBtn");
    var submitBtn = document.getElementById("sig-submitBtn");
    var newSignBtn = document.getElementById("new-signature");
    var signCont = document.getElementById("new-sign-cont");
    var uploadSignBtn = document.getElementById("upload-sign-btn");
    newSignBtn.addEventListener("click", function(e) {
      $("#hide-sign-cont").addClass('d-none');
      $('#new-sign-cont').removeClass('d-none');
    }, false);
    clearBtn.addEventListener("click", function(e) {
      clearCanvas();
      $("#upload-sign-btn").addClass('d-none');
      sigImage.setAttribute("src", "");
    }, false);
    submitBtn.addEventListener("click", function(e) {
      var dataUrl = canvas.toDataURL();
      if(dataUrl != ''){
          $('.new_signature_input').val(dataUrl);
          $("#upload-sign-btn").removeClass('d-none');
      }
      sigImage.setAttribute("src", dataUrl);
    }, false);

  })();
</script>
</html>
