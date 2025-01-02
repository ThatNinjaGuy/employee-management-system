<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <div class="logo" style="float: left; margin-right: 15px; display: flex; align-items: center;">
                    <a href="dashboard.php">
                        <img src="../assets/images/icon/ar2.jpeg" alt="logo" style="width: 30px; height: auto;">
                    </a>
                </div>
                <h4 class="page-title pull-left"><?php echo $pageTitle; ?></h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="<?php echo $homeLink; ?>"><?php echo $homeText; ?></a></li>
                    <li><span><?php echo $breadcrumb; ?></span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            <div class="user-profile pull-right">
                <i class="fa fa-user-circle fa-2x" data-toggle="dropdown" style="cursor: pointer;"></i>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="settings.php">Settings</a>
                    <a class="dropdown-item" href="designation.php">Manage Roles</a>
                    <a class="dropdown-item" href="logout.php">Log Out</a>
                </div>
            </div>
        </div>
    </div>
</div> 