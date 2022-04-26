<?php
session_start();
if(!isset($_SESSION['username'])){
  header('Location: /login.php');
}
?>
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard </a></li>
                  <li><a><i class="fa fa-home"></i> My Properties <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="/add_property.php">Add New Property</a></li>
                      <li><a href="/properties.php">Property List</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-users"></i> Tenants <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="/add_tenant.php">Add New Tenant</a></li>
                      <li><a href="/tenants.php">See All Tenants</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-book"></i> Invoices <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="/my_invoices.php">View All</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
              <div class="menu_section">
                <h3>Income</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-money"></i> Income <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="/my_income.php">View</a></li>
                    </ul>
                  </li>
                </ul>
              </div>

            </div>

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
