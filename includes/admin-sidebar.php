<?php
    session_start();
    error_reporting(0);
    include('../includes/dbconn.php');

    if(strlen($_SESSION['usertype']) == 0){   
        header('location:index.php');
    } else {
?>
<nav>
    <ul class="metismenu" id="menu">
        <li class="<?php if($page=='dashboard') {echo 'active';} ?>"><a href="dashboard.php"><i class="ti-dashboard"></i> <span>Dashboard</span></a></li>
        <!-- Show the Employee Section for all users -->
        <li class="<?php if($page=='employee') {echo 'active';} ?>"><a href="employees.php"><i class="ti-id-badge"></i> <span>Employees</span></a></li>
        <li class="<?php if($page=='designation') {echo 'active';} ?>"><a href="designation.php"><i class="fa fa-th-large"></i> <span>Roles</span></a></li>
        <li class="<?php if($page=='payroll') {echo 'active';} ?>"><a href="payroll.php"><i class="fa  fa-money"></i> <span>Payrolls</span></a></li>
        
        <!-- Only show these sections for admin users -->
        <?php if ($_SESSION['usertype'] === 'Admin') { ?>
            <li class="<?php if($page=='site') {echo 'active';} ?>"><a href="site.php"><i class="fa fa-th-large"></i> <span>Sites</span></a></li>

            <li class="<?php if($page=='supplier') {echo 'active';} ?>"><a href="supplier.php"><i class="fa  fa-money"></i> <span>Suppliers</span></a></li>
            <li class="<?php if($page=='group') {echo 'active';} ?>"><a href="group.php"><i class="fa  fa-money"></i> <span>Groups</span></a></li>
            <li class="<?php if($page=='manage-admin') {echo 'active';} ?>"><a href="manage-admin.php"><i class="fa fa-lock"></i> <span>Manage Admin</span></a></li>
        
        <?php } elseif ($_SESSION['usertype'] === 'supervisor') { ?>
            <!-- Hide the Supplier Section for supervisors -->
            <!-- You can also add more conditions or customize the supervisor's view here -->
            <li class="<?php if($page=='group') {echo 'active';} ?>"><a href="group.php"><i class="fa  fa-money"></i> <span>Group Section</span></a></li>
            <li class="<?php if($page=='manage-admin') {echo 'active';} ?>"><a href="manage-admin.php"><i class="fa fa-lock"></i> <span>Manage Admin</span></a></li>
        <?php } ?>
    </ul>
</nav>
<?php }?>



