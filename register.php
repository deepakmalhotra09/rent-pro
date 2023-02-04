<!DOCTYPE html>
<?php
session_start();
if(isset($_SESSION['username'])){
  header('Location: /');
}

?>
<html lang="en">
<?php include 'src/common/template/header.php'; ?>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
        <section class="login_content">
            <form class="user" action="submit.php?type=register" method="post">
              <h1>Create Account</h1>
              <div>
                <input name="username" type="text" class="form-control" placeholder="Username" required="" />
              </div>
              <div>
                <input name="email" type="email" class="form-control" placeholder="Email" required="" />
              </div>
              <div>
                <input name="password" type="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <input name="re-password" type="password" class="form-control" placeholder="Retype Password" required="" />
              </div>
              <div>
              <button type="submit" class="btn btn-success">Register</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="/login.php" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1> WhatsRent!</h1>
                  <p>©2021 All Rights Reserved. WhatsRent</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
