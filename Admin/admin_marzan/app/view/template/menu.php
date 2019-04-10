<?php
$page = explode("-", str_replace('url=', '', $_SERVER['QUERY_STRING']));
switch($page[0]) {
	case 'faculty' : 
		echo '<li '.$this->helpers->isActiveMenu("faculty-dashboard").'><a href="'.URL.'"><i class="fas fa-home fnt"></i>Dashboard</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("faculty-enroll").'><a href="'.URL.'faculty-enroll"><i class="fas fa-check-square"></i>Enroll Student</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("faculty-student").'><a href="'.URL.'faculty-student"><i class="fas fa-list-ul"></i>Student List</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("faculty-classes").'><a href="'.URL.'faculty-classes"><i class="fas fa-calendar-check"></i>Classes Handled</a></li>';
		echo '<li>';
		echo '<a href="'.' '.'"><i class="fas fa-money-bill fnt"></i>Statement Of Accounts<i class="fa fa-angle-left pull-right"></i></a>';
		echo '<ul class="sidebar-submenu">';
		echo '<li '.$this->helpers->isActiveMenu("faculty-logs").'><a href="'.URL.'faculty-logs"><i class="fas fa-calendar-check"></i>Edit Classes</a></li>';
		echo '</ul>';
		echo '</li>';
		echo '<li '.$this->helpers->isActiveMenu("faculty-attendance").'><a href="'.URL.'faculty-attendance"><i class="far fa-calendar-alt"></i>Attendance</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("faculty-grades").'><a href="'.URL.'faculty-grades"><i class="fas fa-calendar-check"></i>Grades</a></li>';
		break;
	case 'student' :
		echo '<li '.$this->helpers->isActiveMenu("student-dashboard").'><a href="'.URL.'"><i class="fas fa-home fnt"></i>Dashboard</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("student-accounts").'><a href="'.URL.'student-accounts"><i class="fas fa-home fnt"></i>Statement of Account</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("student-attendance").'><a href="'.URL.'student-attendance"><i class="fas fa-home fnt"></i>Attendance</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("student-grades").'><a href="'.URL.'student-grades"><i class="fas fa-home fnt"></i>Grades</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("student-schedule").'><a href="'.URL.'student-schedule"><i class="fas fa-home fnt"></i>Class</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("student-information").'><a href="'.URL.'student-information"><i class="fas fa-home fnt"></i>Student Information</a></li>';
		break;
	case 'parent' :
		echo '<li '.$this->helpers->isActiveMenu("parent-dashboard").'><a href="'.URL.'"><i class="fas fa-home fnt"></i>Dashboard</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("parent-account").'><a href="'.URL.'parent-account"><i class="fas fa-user-plus fnt"></i>Statement of Account</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("parent-attendance").'><a href="'.URL.'parent-attendance"><i class="fas fa-book fnt"></i>Attendance Report</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("parent-grades").'><a href="'.URL.'parent-grades"><i class="far fa-calendar-alt fnt"></i>Grades</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("parent-schedule").'><a href="'.URL.'parent-schedule"><i class="fas fa-book fnt"></i>Class Schedule</a></li>';
		break;
	case 'treasurer':
		echo '<li '.$this->helpers->isActiveMenu("treasurer-dashboard").'><a href="'.URL.'"><i class="fas fa-home fnt"></i>Dashboard</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("treasurer-accounts").'><a href="'.URL.'treasurer-accounts"><i class="fas fa-user-plus fnt"></i>Statement of Account</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("treasurer-logs").'><a href="'.URL.'treasurer-logs"><i class="fas fa-book fnt"></i>Log</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("treasurer-grades").'><a href="'.URL.'treasurer-grades"><i class="fas fa-list-ol fnt"></i>Grades</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("treasurer-reports").'><a href="'.URL.'treasurer-reports"><i class="far fa-calendar-alt fnt"></i>Attendance Report</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("treasurer-schedule").'><a href="'.URL.'treasurer-schedule"><i class="fas fa-book-open fnt"></i>Class Schedule</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("treasurer-statistics").'><a href="'.URL.'treasurer-statistics"><i class="fas fa-signal fnt"></i>Statistics</a></li>';
		break;
	case 'admin':
		echo '<li '.$this->helpers->isActiveMenu("admin-dashboard").'><a href="'.URL.'"><i class="fas fa-home fnt"></i>Dashboard</a></li>';

		echo '<li>';
		echo '<a href="'.' '.'"><i class="fas fa-money-bill fnt"></i>Statement Of Accounts<i class="fa fa-angle-left pull-right"></i></a>';
		echo '<ul class="sidebar-submenu">';
		echo '<li '.$this->helpers->isActiveMenu("admin-feetype").'><a href="'.URL.'admin-feetype"><i class="fas fa-money-check fnt"></i>Fee Type</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("admin-balstatus").'><a href="'.URL.'admin-balstatus"><i class="fas fa-money-check fnt"></i>Student Payment Status</a></li>';
		echo '</ul>';
		echo '</li>';
		echo '<li '.$this->helpers->isActiveMenu("admin-section").'><a href="'.URL.'admin-section"><i class="fas fa-book-open fnt"></i>Section</a></li>';
		echo '<li>';
		echo '<li '.$this->helpers->isActiveMenu("admin-classes").'><a href="'.URL.'admin-classes"><i class="fas fa-plus fnt"></i>Class</a></li>';
		echo '<li>';
		echo '<li '.$this->helpers->isActiveMenu("admin-subjects").'><a href="'.URL.'admin-subjects"><i class="fas fa-book-reader fnt"></i>Subject</a></li>';
		echo '<li>';
		echo '<a href="'.' '.'"><i class="fas fa-user-plus fnt"></i>Users <i class="fa fa-angle-left pull-right"></i></a>';
		echo '<ul class="sidebar-submenu">';
		echo '<li '.$this->helpers->isActiveMenu("admin-faculty").'><a href="'.URL.'admin-faculty"><i class="fas fa-plus fnt"></i>Faculty</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("admin-parent").'><a href="'.URL.'admin-parent"><i class="fas fa-plus fnt"></i>Parent</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("admin-student").'><a href="'.URL.'admin-student"><i class="fas fa-plus fnt"></i>Student</a></li>';
		echo '</ul>';
		echo '</li>';
		echo '<li '.$this->helpers->isActiveMenu("admin-events").'><a href="'.URL.'admin-events"><i class="far fa-calendar-alt fnt"></i>Events</a></li>';
		echo '<li>';
		echo '<a href="'.' '.'"><i class="fab fa-blogger-b fnt"></i>Reports<i class="fa fa-angle-left pull-right"></i></a>';
		echo '<ul class="sidebar-submenu">';
		echo '<li '.$this->helpers->isActiveMenu("admin-paymenthistory").'><a href="'.URL.'admin-paymenthistory"><i class="fas fa-history fnt"></i>Payment History</a></li>';
		echo '<li '.$this->helpers->isActiveMenu("admin-enrolledstudents").'><a href="'.URL.'admin-enrolledstudents"><i class="fas fa-check-square fnt"></i>Enrolled Students</a></li>';
		echo '</ul>';
		echo '<li '.$this->helpers->isActiveMenu("admin-logs").'><a href="'.URL.'admin-logs"><i class="fas fa-book fnt"></i>Logs</a></li>';
		break;
	default: break;
}
?>