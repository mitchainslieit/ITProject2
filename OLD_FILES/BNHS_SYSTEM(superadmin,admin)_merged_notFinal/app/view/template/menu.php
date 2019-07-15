<?php
$page = explode("-", str_replace('url=', '', $_SERVER['QUERY_STRING']));

switch($page[0]) {
case 'superadmin' :
	echo '<li '.$this->helpers->isActiveMenu("superadmin-dashboard").'><a href="'.URL.'"><i class="fas fa-home fnt"></i>Dashboard</a></li>';
	echo '<li '.$this->helpers->isActiveMenu("superadmin-calendar").'><a href="'.URL.'superadmin-calendar"><i class="fas fa-calendar-alt fnt"></i>Calendar</a></li>';
	echo '<li>';
	echo '<a href="'.' '.'" target="soa-submenu" class="submenu-title"><span><i class="fas fa-money-bill fnt"></i>Statement Of Accounts<i class="fa fa-angle-left pull-right"></i></span></a>';
	echo '<ul class="sidebar-submenu" id="soa-submenu">';
	echo '<li '.$this->helpers->isActiveMenu("superadmin-feetype").'><a href="'.URL.'superadmin-feetype"><i class="fas fa-money-check fnt"></i>Fee Type</a><span class="notification_sa_1">'.$_SESSION['sanotif_1'].'</span></li>';
	echo '<li '.$this->helpers->isActiveMenu("superadmin-balstatus").'><a href="'.URL.'superadmin-balstatus"><i class="fas fa-sync fnt"></i>Student Payment Status</a></li>';
	echo '<li '.$this->helpers->isActiveMenu("superadmin-previous_paymenthistory").'><a href="'.URL.'superadmin-previous_paymenthistory"><i class="fas fa-history fnt"></i>History of Payments</a></li>';
	echo '<li '.$this->helpers->isActiveMenu("superadmin-previous_feetypehistory").'><a href="'.URL.'superadmin-previous_feetypehistory"><i class="fas fa-archive fnt"></i>History of Fee Type</a></li>';
	echo '</ul>';
	echo '</li>';
	echo '<li '.$this->helpers->isActiveMenu("superadmin-subjects").'><a href="'.URL.'superadmin-subjects"><i class="fas fa-book-reader fnt"></i>Curriculum </a><span class="notificationCurriculum">'.$_SESSION['curriculumNotif'].'</span></li>';
	echo '<li>';
	echo '<li '.$this->helpers->isActiveMenu("superadmin-section").'><a href="'.URL.'superadmin-section"><i class="fas fa-book-open fnt"></i>Section</a><span class="notification_sa_2">'.$_SESSION['sanotif_2'].'</span></li>';
	
	echo '<li>';
	echo '<a href="'.' '.'" target="class-submenu" class="submenu-title"><span><i class="fas fa-chalkboard-teacher fnt"></i>Class <i class="fa fa-angle-left pull-right"></i><span></a>';
	echo '<ul class="sidebar-submenu" id="class-submenu">';
	echo '<li '.$this->helpers->isActiveMenu("superadmin-classes").'><a href="'.URL.'superadmin-classes"><i class="fas fa-book-open fnt"></i>Class List</a><span class="classNotification">'.$_SESSION['classNotif'].'</span></li>';
	echo '<li '.$this->helpers->isActiveMenu("superadmin-classschedule").'><a href="'.URL.'superadmin-classschedule"><i class="fas fa-clipboard-list fnt"></i>Class Schedule</a></li>';
	echo '<li '.$this->helpers->isActiveMenu("superadmin-classedit").'><a href="'.URL.'superadmin-classedit"><i class="far fa-clipboard fnt"></i>Schedule Request</a></li>';
	echo '<li class="transferCont hidden"'.$this->helpers->isActiveMenu("superadmin-transfer").'><a href="'.URL.'superadmin-transfer"><i class="fas fa-bell fnt"></i>Transfer Student Req</a><span class="notificationTransfer">'.$_SESSION['transferNotif'].'</span></li>';
	echo '</ul>';
	echo '</li>';
	echo '<li '.$this->helpers->isActiveMenu("superadmin-grades").'><a href="'.URL.'superadmin-grades"><i class="fas fa-list fnt"></i>Grades</a></li>';
	echo '<li>';
	echo '<li>';
	echo '<a href="'.' '.'" target="user-submenu" class="submenu-title"><span><i class="fas fa-user-plus fnt"></i>Users <i class="fa fa-angle-left pull-right"></i><span></a>';
	echo '<ul class="sidebar-submenu" id="user-submenu">';
	echo '<li '.$this->helpers->isActiveMenu("superadmin-faculty").'><a href="'.URL.'superadmin-faculty"><i class="fas fa-chalkboard-teacher fnt"></i>Faculty</a></li>';
	echo '<li '.$this->helpers->isActiveMenu("superadmin-parent").'><a href="'.URL.'superadmin-parent"><i class="far fa-address-book fnt"></i>Parent</a></li>';
	echo '<li '.$this->helpers->isActiveMenu("superadmin-student").'><a href="'.URL.'superadmin-student"><i class="fas fa-user-graduate fnt"></i>Student</a></li>';
	echo '<li '.$this->helpers->isActiveMenu("superadmin-admin").'><a href="'.URL.'superadmin-admin"><i class="fas fa-users fnt"></i>Admin</a></li>';
	echo '</ul>';
	echo '</li>';
	
	echo '<li '.$this->helpers->isActiveMenu("superadmin-events").'><a href="'.URL.'superadmin-events"><i class="far fa-calendar-alt fnt"></i>Events</a></li>';
	echo '<li>';
	echo '<a href="'.' '.'" target="reports-submenu" class="submenu-title"><span><i class="fab fa-blogger-b fnt"></i>Reports<i class="fa fa-angle-left pull-right"></i></span></a>';
	echo '<ul class="sidebar-submenu" id="reports-submenu">';
	echo '<li '.$this->helpers->isActiveMenu("superadmin-paymenthistory").'><a href="'.URL.'superadmin-paymenthistory"><i class="fas fa-history fnt"></i>Transaction History</a></li>';
	echo '<li '.$this->helpers->isActiveMenu("superadmin-enrolledstudents").'><a href="'.URL.'superadmin-enrolledstudents"><i class="fas fa-check-square fnt"></i>Enrolled Students</a></li>';
	echo '</ul>';
	echo '<li>';
	echo '<a href="'.' '.'" target="logs-submenu" class="submenu-title"><span><i class="fas fa-book fnt"></i>Logs<i class="fa fa-angle-left pull-right"></i></span></a>';
	echo '<ul class="sidebar-submenu" id="logs-submenu">';
	echo '<li '.$this->helpers->isActiveMenu("superadmin-logs").'><a href="'.URL.'superadmin-logs"><i class="fas fa-book fnt"></i>Admin Logs</a></li>';
	echo '<li '.$this->helpers->isActiveMenu("superadmin-faculty-logs").'><a href="'.URL.'superadmin-faculty-logs"><i class="fas fa-book fnt"></i>Faculty Logs</a></li>';
	echo '<li '.$this->helpers->isActiveMenu("superadmin-treasurer-logs").'><a href="'.URL.'superadmin-treasurer-logs"><i class="fas fa-book fnt"></i>Treasurer Logs</a></li>';
	echo '</ul>';
	echo '</li>';
	echo '<li '.$this->helpers->isActiveMenu("superadmin-system-settings").'><a href="'.URL.'superadmin-system-settings"><i class="fas fa-cog fnt"></i>System Settings</a></li>';
	/*echo '<li>';
	echo '<a href="'.' '.'" target="request-submenu" class="submenu-title"><span><i class="fas fa-bell fnt"></i>Request<i class="fa fa-angle-left pull-right"></i></span></a>';
	echo '<ul class="sidebar-submenu" id="request-submenu">';
	echo '<li '.$this->helpers->isActiveMenu("superadmin-budgetinfo").'><a href="'.URL.'superadmin-budgetinfo"><i class="fas fa-money-check fnt"></i>Fees</a><span class="notification_sa_1">'.$_SESSION['sanotif_1'].'</span></li>';
	echo '<li '.$this->helpers->isActiveMenu("superadmin-class").'><a href="'.URL.'superadmin-class"><i class="fas fa-plus fnt"></i>Class</a></li>';
	echo '</ul>';
	echo '</li>';*/
	break;
	default: break;
	case 'faculty' : 
	echo '<li '.$this->helpers->isActiveMenu("faculty-dashboard").'><a href="'.URL.'"><i class="fas fa-home fnt"></i>Dashboard</a></li>';
	echo '<li '.$this->helpers->isActiveMenu("faculty-calendar").'><a href="'.URL.'faculty-calendar"><i class="far fa-calendar"></i>Calendar</a></li>';
	echo '<li '.$this->helpers->isActiveMenu("faculty-enroll").'><a href="'.URL.'faculty-enroll"><i class="fas fa-user-plus"></i>Enroll Student</a></li>';
	if ($_SESSION['adviser'] === 'Yes' && $_SESSION['transfer_enabled'] === 'Yes') {
		if ($_SESSION['transfer_enabled'] === 'Yes') {
			echo '<li '.$this->helpers->isActiveMenu("faculty-student").' id="advisory"><a href="'.URL.'faculty-student"><i class="fas fa-list-ul"></i>Advisory Class</a><span class="notification">'.$_SESSION['notif'].'</span></li>';
		} else {
			echo '<li '.$this->helpers->isActiveMenu("faculty-student").' id="advisory"><a href="'.URL.'faculty-student"><i class="fas fa-list-ul"></i>Advisory Class</a></li>';
		}
	}
	if ($_SESSION['sec_privilege'] === 'Yes' && $_SESSION['editclass'] === 'Started') {
		echo '<li>';
		echo '<a href="'.' '.'" target="classes-submenu" class="submenu-title"><span><i class="fas fa-chalkboard"></i>Classes<i class="fa fa-angle-left pull-right"></i></span></a>';
		echo '<ul class="sidebar-submenu" id="classes-submenu">';
		echo '<li '.$this->helpers->isActiveMenu("faculty-classes").'><a href="'.URL.'faculty-classes"><i class="fas fa-chalkboard-teacher"></i>Classes Handled</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("faculty-editclass").'><a href="'.URL.'faculty-editclass"><i class="fas fa-edit"></i>Edit Classes</a></li>';
		echo '</ul>';
		echo '</li>';
	} else {
		echo '<li '.$this->helpers->isActiveMenu("faculty-classes").'><a href="'.URL.'faculty-classes"><i class="fas fa-chalkboard-teacher"></i>Classes Handled</a></li>';
	}
	echo '<li '.$this->helpers->isActiveMenu("faculty-attendance").'><a href="'.URL.'faculty-attendance"><i class="far fa-calendar-alt"></i>Attendance</a></li>';
	if ($_SESSION['adviser'] === 'Yes') {
		echo '<li '.$this->helpers->isActiveMenu("faculty-grades").'><a href="'.URL.'faculty-grades"><i class="fas fa-star-half-alt"></i>Grades And Core Values</a></li>';
	} else {
		echo '<li '.$this->helpers->isActiveMenu("faculty-grades").'><a href="'.URL.'faculty-grades"><i class="fas fa-star-half-alt"></i>Grades</a></li>';
	}
	break;
	case 'student' :
	echo '<li '.$this->helpers->isActiveMenu("student-dashboard").'><a href="'.URL.'"><i class="fas fa-home fnt"></i>Dashboard</a></li>';
	echo '<li '.$this->helpers->isActiveMenu("student-calendar").'><a href="'.URL.'student-calendar"><i class="fas fa-calendar-check"></i>Calendar</a></li>';
	echo '<li '.$this->helpers->isActiveMenu("student-accounts").'><a href="'.URL.'student-accounts"><i class="fas fa-money-bill"></i>Statement of Account</a></li>';
	echo '<li '.$this->helpers->isActiveMenu("student-attendance").'><a href="'.URL.'student-attendance"><i class="fa s fa-check-square"></i>Attendance</a></li>';
	echo '<li>';
	echo '<a href="'.' '.'" target="statements-submenu" class="submenu-title"><span><i class="far fa-calendar-alt fnt"></i>Report Card<i class="fa fa-angle-left pull-right"></i></span></a>';
	echo '<ul class="sidebar-submenu" id="statements-submenu">';
	echo '<li '.$this->helpers->isActiveMenu("student-coreValues").'><a href="'.URL.'student-coreValues"><i class="fas fa-star-half-alt fnt"></i>Core Values</a></li>';
	echo '<li '.$this->helpers->isActiveMenu("student-grades").'><a href="'.URL.'student-grades"><i class="fas fa-calendar-alt"></i>Grades</a></li>';
	echo '</ul>';
	echo '</li>';
	echo '<li '.$this->helpers->isActiveMenu("student-schedule").'><a href="'.URL.'student-schedule"><i class="fas fa-book fnt"></i>Class Schedule</a></li>';
	echo '<li '.$this->helpers->isActiveMenu("student-information").'><a href="'.URL.'student-information"><i class="fas fa-user fnt"></i>Student Information</a></li>';
	break;

	case 'parent' :
	echo '<li '.$this->helpers->isActiveMenu("parent-dashboard").'><a href="'.URL.'"><i class="fas fa-home fnt"></i>Dashboard</a></li>';
	echo '<li '.$this->helpers->isActiveMenu("parent-calendar").'><a href="'.URL.'parent-calendar"><i class="fas fa-calendar-alt"></i>Calendar</a></li>';
	echo '<li '.$this->helpers->isActiveMenu("parent-account").'><a href="'.URL.'parent-account"><i class="fas fa-money-bill"></i>Statement of Account</a></li>';
	echo '<li '.$this->helpers->isActiveMenu("parent-attendance").'><a href="'.URL.'parent-attendance"><i class="fas fa-check-square fnt fnt"></i>Attendance Report</a></li>';
	echo '<li>';
	echo '<a href="'.' '.'" target="statements-submenu" class="submenu-title"><span><i class="far fa-calendar-alt fnt"></i>Report Card<i class="fa fa-angle-left pull-right"></i></span></a>';
	echo '<ul class="sidebar-submenu" id="statements-submenu">';
	echo '<li '.$this->helpers->isActiveMenu("parent-coreValues").'><a href="'.URL.'parent-coreValues"><i class="fas fa-star-half-alt fnt"></i>Core Values</a></li>';
	echo '<li '.$this->helpers->isActiveMenu("parent-grades").'><a href="'.URL.'parent-grades"><i class="fas fa-list-ol fnt"></i>Child Grades</a></li>';
	echo '</ul>';
	echo '</li>';
	echo '<li '.$this->helpers->isActiveMenu("parent-schedule").'><a href="'.URL.'parent-schedule"><i class="fas fa-book fnt"></i>Class Schedule</a></li>';
	break;
	case 'treasurer':
	echo '<li '.$this->helpers->isActiveMenu("treasurer-dashboard").'><a href="'.URL.'"><i class="fas fa-home fnt"></i>Dashboard</a></li>';
	echo '<li '.$this->helpers->isActiveMenu("treasurer-calendar").'><a href="'.URL.'treasurer-calendar"><i class="fas fa-calendar-check fnt"></i>Calendar</a></li>';
	echo '<li '.$this->helpers->isActiveMenu("treasurer-accounts").'><a href="'.URL.'treasurer-accounts"><i class="fas fa-money-bill"></i>Statement of Account</a></li>';
	echo '<li '.$this->helpers->isActiveMenu("treasurer-statistics").'><a href="'.URL.'treasurer-statistics"><i class="far fa-chart-bar"></i>Statistics</a></li>';
	break;
case 'admin':
		echo '<li '.$this->helpers->isActiveMenu("admin-dashboard").'><a href="'.URL.'"><i class="fas fa-home fnt"></i>Dashboard</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("admin-calendar").'><a href="'.URL.'admin-calendar"><i class="fas fa-calendar-alt fnt"></i>Calendar</a></li>';
		echo '<li>';
		
		echo '<li>';
		echo '<a href="'.' '.'" target="soa-submenu" class="submenu-title"><span><i class="fas fa-money-bill fnt"></i>Statement Of Accounts<i class="fa fa-angle-left pull-right"></i></span></a>';
		echo '<ul class="sidebar-submenu" id="soa-submenu">';
		echo '<li '.$this->helpers->isActiveMenu("admin-feetype").'><a href="'.URL.'admin-feetype"><i class="fas fa-money-check fnt"></i>Fee Type</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("admin-balstatus").'><a href="'.URL.'admin-balstatus"><i class="fas fa-sync fnt"></i>Student Payment Status</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("admin-previous_paymenthistory").'><a href="'.URL.'admin-previous_paymenthistory"><i class="fas fa-history fnt"></i>History of Payments</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("admin-previous_feetypehistory").'><a href="'.URL.'admin-previous_feetypehistory"><i class="fas fa-archive fnt"></i>History of Fee Type</a></li>';
		echo '</ul>';
		echo '</li>';	
		echo '<li '.$this->helpers->isActiveMenu("admin-subjects").'><a href="'.URL.'admin-subjects"><i class="fas fa-book-reader fnt"></i>Curriculum</a></li>';
		echo '<li>';
		echo '<li '.$this->helpers->isActiveMenu("admin-section").'><a href="'.URL.'admin-section"><i class="fas fa-book-open fnt"></i>Section</a></li>';
		echo '<li>';
		echo '<li '.$this->helpers->isActiveMenu("admin-classes").'><a href="'.URL.'admin-classes"><i class="fas fa-plus fnt"></i>Class</a></li>';
		echo '<li>';
		/*echo '<li '.$this->helpers->isActiveMenu("admin-transfer").'><a href="'.URL.'admin-transfer"><i class="fas fa-bell fnt"></i>Accept Request</a><span class="notification">'.$_SESSION['adminNotif'].'</span></li>';
		echo '<li>';*/
		echo '<a href="'.' '.'" target="user-submenu" class="submenu-title"><span><i class="fas fa-user-plus fnt"></i>Users <i class="fa fa-angle-left pull-right"></i><span></a>';
		echo '<ul class="sidebar-submenu" id="user-submenu">';
		echo '<li '.$this->helpers->isActiveMenu("admin-faculty").'><a href="'.URL.'admin-faculty"><i class="fas fa-chalkboard-teacher fnt"></i>Faculty</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("admin-parent").'><a href="'.URL.'admin-parent"><i class="far fa-address-book fnt"></i>Parent</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("admin-student").'><a href="'.URL.'admin-student"><i class="fas fa-user-graduate fnt"></i>Student</a></li>';
		echo '</ul>';
		echo '</li>';
		echo '<li '.$this->helpers->isActiveMenu("admin-events").'><a href="'.URL.'admin-events"><i class="far fa-calendar-alt fnt"></i>Events</a></li>';
		echo '<li>';
		echo '<a href="'.' '.'" target="reports-submenu" class="submenu-title"><span><i class="fab fa-blogger-b fnt"></i>Reports<i class="fa fa-angle-left pull-right"></i></span></a>';
		echo '<ul class="sidebar-submenu" id="reports-submenu">';
		echo '<li '.$this->helpers->isActiveMenu("admin-paymenthistory").'><a href="'.URL.'admin-paymenthistory"><i class="fas fa-history fnt"></i>Transaction History</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("admin-enrolledstudents").'><a href="'.URL.'admin-enrolledstudents"><i class="fas fa-check-square fnt"></i>Enrolled Students</a></li>';
		echo '</ul>';
		echo '<li>';
		echo '<a href="'.' '.'" target="logs-submenu" class="submenu-title"><span><i class="fas fa-book fnt"></i>Logs<i class="fa fa-angle-left pull-right"></i></span></a>';
		echo '<ul class="sidebar-submenu" id="logs-submenu">';
		/*echo '<li '.$this->helpers->isActiveMenu("admin-logs").'><a href="'.URL.'admin-logs"><i class="fas fa-book fnt"></i>Admin Logs</a></li>';*/
		echo '<li '.$this->helpers->isActiveMenu("admin-faculty-logs").'><a href="'.URL.'admin-faculty-logs"><i class="fas fa-book fnt"></i>Faculty Logs</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("admin-treasurer-logs").'><a href="'.URL.'admin-treasurer-logs"><i class="fas fa-book fnt"></i>Treasurer Logs</a></li>';
		echo '</ul>';
		echo '</li>';
		/*echo '<li '.$this->helpers->isActiveMenu("admin-system-settings").'><a href="'.URL.'admin-system-settings"><i class="fas fa-cog fnt"></i>System Settings</a></li>';
		echo '<li>';*/
		break;
}
echo '<li><a id="collapse-menu"><i class="far fa-play-circle"></i>Collapse Menu</a></li>';
?>