<!DOCTYPE html>
<?php
session_start();
if(isset($_SESSION['username'])){
  header('Location: /');
}
$year = date("Y");

?>
<html lang="en">
<?php include 'src/common/template/header.php'; ?>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>
      <p></p>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form class="user" action="submit.php?type=check_login" method="post">
              <h1>Login</h1>
              <div>
                <input name="email" type="text" class="form-control" placeholder="Email" required="" />
              </div>
              <div>
                <input name="password" type="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
              <?php if($_SESSION['login_error']){ ?>
                <div class="alert alert-danger" role="alert">
                    Wrong Information
                </div>
                <?php } ?>
                <button type="submit" class="btn btn-success">Login</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">New to site?
                  <a href="/register.php" class="to_register"> Create Account </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                <h1> WhatsRent!</h1>
                  <p>©<?= $year ?> All Rights Reserved. WhatsRent</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
