<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion sss " id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= BASEPATH ?>">
        <div class="sidebar-brand-text mx-3 logoWebsite">
            <div class="title">Productive</div>
            <div class="subtitle">Anywhere</div>
        </div>
    </a>
    <hr class="sidebar-divider my-0" />
    <!-- <li class="nav-item menu-item aaa" data-menu="<?= BASEPATH ?>home">
        <a class="nav-link" href="<?= BASEPATH ?>home">
            <i class="bi bi-house-door"></i>
            <span>Home</span></a>
    </li> -->
    <li class="nav-item menu-item" data-menu="<?= BASEPATH ?>addwork">
        <a class="nav-link" href="<?= BASEPATH ?>addwork">
            <i class="bi bi-clipboard-plus-fill"></i>
            <span>Add Work</span></a>
    </li>
    <!-- <li class="nav-item menu-item" data-menu="<?= BASEPATH ?>Calendar">
        <a class="nav-link" href="<?= BASEPATH ?>Calendar">
            <i class="bi bi-calendar"></i>
            <span>Calendar</span></a>
    </li>  -->

    <li class="nav-item menu-item aaa" data-menu="<?= BASEPATH ?>RequestWFH">
        <a class="nav-link" href="<?= BASEPATH ?>RequestWFH">
            <i class="bi bi-send-plus"></i>
            <span>Request</span></a>
    </li>
    <li class="nav-item menu-item aaa" data-menu="<?= BASEPATH ?>HistoryRequest">
        <a class="nav-link" href="<?= BASEPATH ?>HistoryRequest">
            <i class="bi bi-clock-history"></i>
            <span>My History</span></a>
    </li>

    <?php
    if ($_SESSION['emp']['emp_walroles'] == 3) {
    ?>
        <li class="nav-item menu-item aaa" data-menu="<?= BASEPATH ?>EmployeeRequest">
            <a class="nav-link" href="<?= BASEPATH ?>EmployeeRequest">
                <i class="bi bi-person-fill-check"></i>
                <span>Approval </span></a>
        </li>
    <?php }
    ?>

    <!-- <li class="nav-item menu-item aaa" data-menu="<?= BASEPATH ?>EmployeeRequest">
        <a class="nav-link" href="<?= BASEPATH ?>EmployeeRequest2">
            <i class="bi bi-chat-right"></i>
            <span>Employee Request Calendar</i></span></a> -->
    <!-- </li> -->
    <!-- <li class="nav-item menu-item" data-menu="<?= BASEPATH ?>Myteam">
        <a class="nav-link" href="<?= BASEPATH ?>Myteam">
            <i class="bi bi-person-video3"></i>
            <span>Myteam </span></a>
    </li> -->
    <?php
    if ($_SESSION['emp']['emp_walroles'] == 2 || $_SESSION['emp']['emp_walroles'] == 4 || $_SESSION['emp']['emp_walroles'] == 5) { ?>
        <li class="nav-item menu-item aaa" data-menu="<?= BASEPATH ?>HistoryAll">
            <a class="nav-link" href="<?= BASEPATH ?>HistoryAll">
                <i class="bi bi-chat-right"></i>
                <span>History All</span></a>
        </li>
        <li class="nav-item menu-item aaa" data-menu="<?= BASEPATH ?>EmployeeHr">
            <a class="nav-link" href="<?= BASEPATH ?>EmployeeHr">
                <i class="bi bi-file-earmark-excel"></i>
                <span>Reports</span></a>
        </li>

    <?php } ?>
    <!-- <li class="nav-item menu-item aaa" data-menu="<?= BASEPATH ?>Myteam2">
        <a class="nav-link" href="<?= BASEPATH ?>Myteam2">
            <i class="bi bi-person-video3"></i>
            <span>Myteam </span></a>
    </li> -->
  
    <hr class="sidebar-divider d-none d-md-block" />
    <li class="nav-item aaa" style="position: absolute; bottom: 0">
        <a class="nav-link btn-signout" href="#">
            <i class="bi bi-box-arrow-left"></i>
            <span>Logout</span>
        </a>
    </li>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button type="button" id="sidebarToggle">
            <!-- <i class="fas fa-chevron-left"></i> -->
        </button>
    </div>

    <!-- Sidebar Message -->
</ul>