<?
// include('config.php');
if ($_SESSION['ADVANTAGE_username']) {
    
    
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>';

// ;


    $id = $_SESSION['ADVANTAGE_userid'];

    
    $user = "select * from user where userid=" . $id;
    $usersql = mysqli_query($con, $user);
    $usersql_result = mysqli_fetch_assoc($usersql);
    
    $level = $usersql_result['level'];
    $permission = $usersql_result['permission'];
    $permission = explode(',', $permission);
    sort($permission);

    $cpermission = json_encode($permission);
    $cpermission = str_replace(array('[', ']', '"'), '', $cpermission);
    $cpermission = explode(',', $cpermission);
    $cpermission = "'" . implode("', '", $cpermission) . "'";
    $mainmenu = [];
    foreach ($permission as $key => $val) {
        $sub_menu_sql = mysqli_query($con, "select * from sub_menu where id='" . $val . "' and status=1");

        if (mysqli_num_rows($sub_menu_sql) > 0) {
            $sub_menu_sql_result = mysqli_fetch_assoc($sub_menu_sql);
            $mainmenu[] = $sub_menu_sql_result['main_menu'];
        }
    }
    $mainmenu = array_unique($mainmenu);
    sort($mainmenu);




    

    ?>

    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
            <a class="sidebar-brand brand-logo" href="<? $_SERVER["DOCUMENT_ROOT"]; ?>/corona/index.php"
                style="color:white;">
                 <img src="http://clarity.advantagesb.com/assets/1601680170_capture.jpg" alt="logo" />
             
             
            </a>
            <a class="sidebar-brand brand-logo-mini" href="index.php"><img src="assets/images/logo-mini.svg"
                    alt="logo" /></a>
        </div>


        <ul class="nav">
            <!-- <li class="nav-item profile">
                <div class="profile-desc">
                    <div class="profile-pic">
                        <div class="count-indicator">
                            <img class="img-xs rounded-circle "
                                src="<? $_SERVER["DOCUMENT_ROOT"]; ?>/corona/assets/images/faces/face15.jpg" alt="">
                            <span class="count bg-success"></span>
                        </div>
                        <div class="profile-name">
                            <h5 class="mb-0 font-weight-normal">
                                
                            </h5>

                        </div>
                    </div>
                    <a href="#" id="profile-dropdown" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
                    <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list"
                        aria-labelledby="profile-dropdown">
                        <a href="#" class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-dark rounded-circle">
                                    <i class="mdi mdi-settings text-primary"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-dark rounded-circle">
                                    <i class="mdi mdi-onepassword  text-info"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-dark rounded-circle">
                                    <i class="mdi mdi-calendar-today text-success"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <p class="preview-subject ellipsis mb-1 text-small">To-do list</p>
                            </div>
                        </a>
                    </div>
                </div>
            </li> -->
            <li class="nav-item nav-category">
                <span class="nav-link">Navigation</span>
            </li>





            <?
            foreach ($mainmenu as $menu => $menu_id) {
                $menu_sql = mysqli_query($con, "select * from main_menu where id='" . $menu_id . "' and status=1");
                $menu_sql_result = mysqli_fetch_assoc($menu_sql);
                $main_name = $menu_sql_result['name'];
                $targetDiv = str_replace(' ', '', $main_name);
                $icon = $menu_sql_result['icon'];
                ?>

                <li class="nav-item menu-items">
                    <a class="nav-link" data-bs-toggle="collapse" href="#<?= $targetDiv; ?>" aria-expanded="false"
                        aria-controls="<?= $targetDiv; ?>">
                        <span class="menu-icon">
                            <i class="mdi mdi-laptop"></i>
                        </span>
                        <span class="menu-title">
                            <? echo $main_name; ?>
                        </span>
                        <i class="menu-arrow"></i>
                    </a>

                    <div class="collapse" id="<?= $targetDiv; ?>">
                        <ul class="nav flex-column sub-menu">
                            <?
                            $submenu_sql = mysqli_query($con, "select * from sub_menu where main_menu = '" . $menu_id . "' and id in ($cpermission) and status=1 order by sub_menu asc");
                            while ($submenu_sql_result = mysqli_fetch_assoc($submenu_sql)) {
                                $page = $submenu_sql_result['page'];
                                $submenu_name = $submenu_sql_result['sub_menu'];
                                $folder = $submenu_sql_result['folder'];

                                if (basename($_SERVER['PHP_SELF'], PATHINFO_BASENAME) == $page) {
                                    $className = 'active';
                                } else {
                                    $className = '';
                                }
                                ?>
                                <li class="nav-item <? echo $className; ?>">
                                    <a class="nav-link" href="<?= $base_url . $folder . '/' . $page; ?>">
                                        <? echo $submenu_name; ?>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </li>

            <? } ?>



            <li class="nav-item menu-items">
                <a class="nav-link" href="<?= $base_url; ?>/logout.php">
                    <span class="menu-icon">
                        <i class="mdi mdi-playlist-play"></i>
                    </span>
                    <span class="menu-title">Logout</span>
                </a>
            </li>


        </ul>
    </nav>

<? } ?>