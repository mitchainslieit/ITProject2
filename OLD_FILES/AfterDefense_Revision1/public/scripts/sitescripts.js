/** 
 * SITE FUNCTIONALITIES
 *
 * IT CONTAINS THE USAGE OF API'S AND 
 */

 replacePageTitle();
 /****************************************** START OF FRONT-END FUNCTIONALITIES USING JQUERY (CALLED WITHOUT WAITING FOR THE PAGE TO FULLY LOAD) ******************************************/
 var bootstrapButton = $.fn.button.noConflict()
 $.fn.bootstrapBtn = bootstrapButton  

 function replacePageTitle() {
 	var pageURL = $(location).attr("href");
	var getPage = pageURL.split("/");
	var page = getPage[getPage.length - 1];
	getPage = page.split("-");
	page = getPage[getPage.length - 1];
 	$('title').empty();
	if (page == 'profile') {
	 	$('title').append('Profile');
	} else {
	 	$('title').append($( '.menu nav ul li.active-menu a' ).text());
	}
 }

/*jQuery.extend(jQuery.validator.messages, {
	required: "This field is required.",
	remote: "Please fix this field.",
	email: "Please enter a valid email address.",
	url: "Please enter a valid URL.",
	date: "Please enter a valid date.",
	dateISO: "Please enter a valid date (ISO).",
	number: "Please enter a valid number.",
	digits: "Please enter only digits.",
	creditcard: "Please enter a valid credit card number.",
	equalTo: "Please enter the same value again.",
	accept: "Please enter a value with a valid extension.",
	maxlength: jQuery.validator.format("Please enter no more than {0} numbers."),
	minlength: jQuery.validator.format("Please enter at least {0} numbers."),
	rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
	range: jQuery.validator.format("Please enter a value between {0} and {1}."),
	max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
	min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
});*/

 /*Custom Sidebar using pure jQuery*/
 $('.menu-sidebar .menu nav ul li a[href^=" "]').click(function(event) {
 	event.preventDefault();
 	var oldSubMenu = "#" + $('.menu-sidebar .menu nav ul li ul.active-submenu').attr('id');
 	var submenuID = "#" + $(this).attr("target");
 	if (!($('.menu-sidebar .menu nav ul li').hasClass('active')) || $(submenuID).parent('li').hasClass('active')) {
 		$(submenuID).parent('li').toggleClass('active');
 		$(submenuID).slideToggle();
 	} else {
 		$('.menu-sidebar .menu nav ul li.active ul').slideUp();
 		$('.menu-sidebar .menu nav ul li.active').removeClass('active');
 		$(submenuID).parent('li').addClass('active');
 		$(submenuID).slideDown();
 	}
 });

 if ($('.menu-sidebar .menu nav ul li ul li').hasClass('active-menu')) {
 	$('.menu-sidebar .menu nav ul li').has('li.active-menu').addClass('active');
 	$('.menu-sidebar .menu nav ul li.active ul').show();
 }

 var ifColAct = localStorage.getItem('collapse-menu');

 $('#collapse-menu').click(function() {
 	$('div.menu-top').toggleClass('top-compress');
 	$('div.menu-sidebar').toggleClass('sidebar-compress');
 	$('div.content-container').toggleClass('content-compress');
 	$('.menu-sidebar .menu nav ul li#advisory span.notification').toggle();
 	ifColAct === null ? localStorage.setItem('collapse-menu', 'active') : localStorage.removeItem('collapse-menu');
 });

 if (ifColAct === 'active') {
 	$('div.menu-top').addClass('top-compress');
 	$('div.menu-sidebar').addClass('sidebar-compress');
 	$('div.content-container').addClass('content-compress');
 	$('.menu-sidebar .menu nav ul li#advisory span.notification').hide();
 }

 $('.menu nav > ul > li').each(function() {
 	var newDiv = '<span class="menu-title">' + $(this).children('a').text() + '</span>';
 	$(this).children('a').append(newDiv);
 });

 $('.sidebar-submenu li').each(function() {
 	var newDiv = '<span class="menu-title">' + $(this).children('a').text() + '</span>';
 	$(this).children('a').append(newDiv);
 });

 $( '.sidebar-menu li' ).has('li.active-menu').addClass('active');

 $( ".datepicker" ).datepicker({
 	changeMonth: true,
 	changeYear: true,
 	yearRange: "-25:+0",
 	dateFormat: 'yy-mm-dd',
 	showMonthAfterYear:true,
 	maxDate: new Date
 });

 $( ".datepicker-attendance, .datepicker-attendance1" ).datepicker({
 	changeMonth: true,
 	dateFormat: 'yy-mm-dd',
 	maxDate: new Date, 
 	minDate: "-2m",
 	beforeShowDay: $.datepicker.noWeekends
 }).datepicker("setDate", new Date());

 $('[name=opener]').each(function () {
 	var panel = $(this).siblings('[name=dialog]');
 	$(this).click(function () {
 		$(".datepicker-attendance, .datepicker-attendance1, .datepicker-payment").datepicker("disable");
 		panel.dialog('open');
 		$(".datepicker-attendance, .datepicker-attendance1, .datepicker-payment").datepicker("enable");
 		$('.ui-widget-overlay').addClass('custom-overlay');
 	});
 });

 $('[name=dialog]').dialog({
 	autoOpen: false,
 	modal: true,
 	draggable: false,
 	height: 'auto',
 	width: 'auto',
 	close: function() {
 		$('.faculty-editclass-page .classes-sched').trigger("reset");
 	}
 });

 $('[name=opener2]').each(function () {
	var panel = $(this).siblings('[name=dialog2]');
	$(this).click(function () {
		panel.dialog('open');
		$('.ui-widget-overlay').addClass('custom-overlay');
	});
});

$('[name=dialog2]').dialog({
	autoOpen: false,
	modal: true,
	resizable: false,
	draggable: false
});

$('[name=opener3]').each(function () {
	var panel = $(this).siblings('[name=dialog3]');
	$(this).click(function () {
		panel.dialog('open');
		$('.ui-widget-overlay').addClass('custom-overlay');
	});
});

$('[name=dialog3]').dialog({
	autoOpen: true,
	modal: true,
	resizable: false,
	draggable: false
});

$( "#eventDataTable, #announcementDataTable, #historyDataTable, #notif" ).DataTable({
	"initComplete": function (settings, json) {  
		$("#eventDataTable, #announcementDataTable, #historyDataTable, #notif").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
	},
	"paging":   false,
	"ordering": false,
	"info": false,
	buttons: false,
	"searching":false,
	stateSave: true
});


$( "#stud-list, .admin-table, .admin-table-withScroll, .systemTable" ).DataTable({
	//"scrollX": true,            
	"initComplete": function (settings, json) {  
		$("#stud-list, .admin-table, .admin-table-withScroll, .systemTable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
	},
	stateSave: true,
	"lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
	
});

$( document ).ready(function() {
	$( ".se-pre-con" ).fadeOut("slow");

	/****************************************** START OF API(s) ******************************************/
	/*Jquery UI Tabs*/
	$( ".enrollcontent .tabs" ).tabs({ active: 1 });
	$( ".tabs, .studentContent .tabs, .classesContent .tabs" ).tabs();

	/*Datatable API*/
	var datatable = $( "#stud-list" ).DataTable({
		dom: "lfrtip",
		"lengthMenu": [[5, 10, 25, -1], [5, 10, 25, 'All']]
	});

	var studlist = $('#old-student').DataTable({
		"columnDefs" : [{
			"targets": [4],
			"visible": false,
		}]
	});

	studlist.column(2).search( 'Not Enrolled' ).draw();

	$('.faculty-enroll-page #filter-stud-list').on('change', function() {
		var val = $(this).val();
		studlist.column(4).search( val ? val : '', true, false ).draw();
	});

	$('.faculty-enroll-page #filter-stud-list-transfers').on('change', function() {
		var val = $(this).val();
		studlist.column(2).search( val ? '^'+val+'$' : '', true, false ).draw();
	});

	/*FullCalendar API*/
	var calendar = $('#calendar').fullCalendar({
		header:{
			left:'prev,next today',
			center:'title',
			right:'month,agendaWeek,agendaDay'
		},
		events: 'app/model/unstructured/load.php',
		selectHelper:true,
		height: screen.height - 375
	});

	var faculty_calendar = $('#calendar-faculty').fullCalendar({
		header:{
			left:'prev,next today',
			center:'title',
			right:'month,agendaWeek,agendaDay'
		},
		events: 'app/model/unstructured/load.php',
		selectHelper:true,
		height: screen.height - 450
	});

	/*jQuery Form Validator API*/
	$.validate({
		onError : function($form) {
			swal({
				title: 'Error!',
				text: 'Please check your form.',
				icon: 'error'
			})
		}
	});
});



if ($('body').is('[class*="student-"]')) {
 	var student_table = $('#student-payment-history').DataTable({
 		"columnDefs": [{
 			"targets": [2],
 			"visible": false
 		}]
 	});

 	var student_select_table = $('.student-accounts-page #filter-year').val();
 	student_table.column(2).search(student_select_table ? student_select_table : '', true, false).draw();

 	$('.student-accounts-page #filter-year-stud span.year').each(function() {
 		if ($(this).data('year') != student_select_table) {
 			$(this).hide();
 		}
 	});

 	$('.student-accounts-page  #filter-year').on('change', function () {
 		var data = $(this).val();
 		$('.student-accounts-page #filter-year-stud span.year').each(function() {
 			$(this).show();
 			if ($(this).data('year') != $('.student-accounts-page  #filter-year').val()) {
 				$(this).hide();
 			}
 		});
 		student_table.column(2).search(data ? data : '', true, false).column(2).search(data).draw();
 	});

 	$('.student-accounts-page #filter-year').on('change', function () {
 		var data = $(this).val();
 		student_table.column(2).search(data ? data : '', true, false).draw();
 	});
 }

 /*******Parent-Account*******/
 if ($('body').is('[class*="parent-"]')) {
 	var parent_table1 = $('#customParentTable').DataTable({
 		"columnDefs": [{
 			"targets": [2,3],
 			"visible": false
 		}]
 	});

 	var par_select_child = $('.parent-account-page .contentpage .widget .contleft .innercont1 .eventcontent .tl select#select-children').val();
 	parent_table1.column(2).search(par_select_child ? par_select_child : '', true, false).draw();

 	$('.parent-account-page span.wlrno, .parent-account-page td.wlrno').each(function() {
 		if ($(this).data('lrno') != par_select_child) {
 			$(this).hide();
 		}
 	});

 	$('.parent-account-page .contentpage .widget .contleft .innercont1 .eventcontent .tl select#select-children').on('change', function () {
 		var data = new Array($(this).val(), $(this).siblings('select').val());
 		$('.parent-account-page span.wlrno, .parent-account-page td.wlrno').each(function() {
 			$(this).show();
 			if ($(this).data('lrno') != $('.parent-account-page .contentpage .widget .contleft .innercont1 .eventcontent .tl select#select-children').val()) {
 				$(this).hide();
 			}
 		});
 		parent_table1.column(2).search('^'+data[0]+'$' ? data[0] : '', true, false).column(3).search(data[1]).draw();
 	})

 	$('.parent-account-page .contentpage .widget .contleft .innercont1 .eventcontent .tl select#select-year').on('change', function () {
 		var data = new Array($(this).val(), $(this).siblings('select').val());
 		parent_table1.column(3).search('^'+data[0]+'$' ? data[0] : '', true, false).column(2).search('^'+data[1]+'$' ? data[1] : '', true, false).draw();
 	})


 	/*******Parent-Attendance*******/
 	var parent_table2 = $('#table-attendance').DataTable({
 		"columnDefs": [{
 			"targets": [0],
 			"visible": false
 		}],
 		"language": {
 			"emptyTable": "THERE ARE NO ABSENCES YET."
 		}
 	});

 	/*******Parent-Attendance*******/
 	var par_select_att = $('.parent-attendance-page #select-child-attendance').val();
 	parent_table2.column(0).search(par_select_att ? par_select_att : '', true, false).draw();

 	$('.parent-attendance-page #table-attendance span.wlrno').each(function() {
 		if ($(this).data('lrno') != par_select_att) {
 			$(this).hide();
 		}
 	});

 	$('.parent-attendance-page #select-child-attendance').on('change', function () {
 		var data = $(this).val();
 		$('.parent-attendance-page #table-attendance span.wlrno').each(function() {
 			$(this).show();
 			if ($(this).data('lrno') != $('.parent-attendance-page #select-child-attendance').val()) {
 				$(this).hide();
 			}
 		});
 		parent_table2.column(0).search('^'+data+'$' ? data : '', true, false).column(0).search(data [0]).draw();
 	})
 	
 	$('.parent-attendance-page #select-child-attendance').on('change', function () {
 		var data = $(this).val();
 		parent_table2.column(0).search(data ? data : '', true, false).draw();

 		var data2 = 'lrno=' + $(this).val();
 		$.ajax({
 			type: 'POST',
 			url: 'app/model/unstructured/parent-changeSession.php',
 			data: data2
 		});
 	})

 	/*******Grades*******/
 	var grades_table = $('#grade-student').DataTable({
 		"initComplete": function (settings, json) {  
 			$("#grades-history-classes-handled").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
 		},
 		"columnDefs": [{
 			"targets": [8],
 			"visible": false
 		}],
 		"paging": false,
 		"info": false,
 		"ordering": false
 	});
 	grades_table.column(8).search($('.parent-grades-page #select-child-grade').val() ? $('.parent-grades-page #select-child-grade').val() : '', true, false).draw();

 	$('#grade-student .wlrno').each(function() {
 		if ($('.parent-grades-page #select-child-grade').val() == $(this).data('lrno')) {
 			$(this).show();
 		} else {
 			$(this).hide();
 		}
 	});
 	
 	$('.parent-grades-page #select-child-grade').on('change', function() {
 		grades_table.column(8).search($(this).val() ? $(this).val() : '', true, false).draw();
 		$('#grade-student .wlrno').each(function() {
 			if ($('.parent-grades-page #select-child-grade').val() == $(this).data('lrno')) {
 				$(this).show();
 			} else {
 				$(this).hide();
 			}
 		});
 	});

 	$('#table-children-schedule > div').each(function() {
 		if ($('.parent-schedule-page #select-child-schedule').val() == $(this).data('lrno')) {
 			$(this).show();
 		} else {
 			$(this).hide();
 		}
 	});

 	$('.parent-schedule-page #select-child-schedule').on('change', function() {
 		$('#table-children-schedule > div').each(function() {
 			if ($('.parent-schedule-page #select-child-schedule').val() == $(this).data('lrno')) {
 				$(this).show();
 			} else {
 				$(this).hide();
 			}
 		});
 	});

 	var par_stud_transcript = $('#grade-student-history').DataTable({
 		"columnDefs" : [{
 			"targets": [4],
 			"visible" : false
 		}]
 	});

 	par_stud_transcript.column(4).search($('.parent-grades-history-page #select-child-grade').val() ? $('.parent-grades-history-page #select-child-grade').val() : '', true, false).draw();

 	$('.parent-grades-history-page #select-child-grade').on('change', function() {
 		par_stud_transcript.column(4).search($(this).val() ? $(this).val() : '', true, false).draw();
 	});

 	var cv_child_table = $('#coreValue-student').DataTable({
 		"columnDefs": [{
 			"targets": [5],
 			"visible": false
 		}],
 		"paging": false,
 		"info": false,
 		"ordering": false
 	});

 	cv_child_table.column(5).search($('.parent-coreValues-page #select-core-value').val() ? $('.parent-coreValues-page #select-core-value').val() : '', true, false).draw();

 	$('.parent-coreValues-page #select-core-value').on('change', function() {
 		cv_child_table.column(5).search($(this).val() ? $(this).val() : '', true, false).draw();
 	});
 }

 if ($('body').is('[class*="faculty-"]')) {

 	var enrollment_student_all = $('#student-all-list').DataTable({
 		"language": {
 			"emptyTable": "There are no students to show."
 		}
 	});

 	$("form").on("change", ".file-upload-field", function(){ 
 		$(this).parent(".file-upload-wrapper").attr("data-text",$(this).val().replace(/.*(\/|\\)/, '') );
 	});

 	$('#filter-stud-list-remarks').on('change', function() {
 		var val = $(this).val();
 		enrollment_student_all.column(1).search(val ? '^'+val+'$' : '', true, false).draw();
 	});

 	var students_handled_table_classes = $('#students_handled_faculty_only').DataTable({
 		"language": {
 			"emptyTable": "There are no students to show."
 		},
 		"bPaginate": false,
 		"bLengthChange": false,
 		"bFilter": true,
 		"bInfo": false,
 		"bAutoWidth": false
 	});

 	$('#filter_by_gender').on('change', function() {
 		students_handled_table_classes.column(1).search($(this).val() ? "^" + $(this).val() + "$" : '', true, false).draw();
 	});

 	var grades_history_subject_handled = $('#grades-history-subject-handled').DataTable({
 		"initComplete": function (settings, json) {  
 			$("#grades-history-subject-handled").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
 		},
 		"columnDefs" : [{
 			"targets" : [7],
 			"visible" : false,
 		}]
 	});

 	var grades_history_classes_handled = $('#grades-history-classes-handled').DataTable({
 		"initComplete": function (settings, json) {  
 			$("#grades-history-classes-handled").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
 		},
 		"columnDefs" : [{
 			"targets" : [8],
 			"visible" : false,
 		}]
 	});

 	$('.faculty-grades-history-page #faculty_home .selects').on('change', 'select#grades-history-handled-select-subject', function() {
 		grades_history_classes_handled.column(5).search($(this).val() ? "^" + $(this).val() + "$" : '', true, false).draw();
 	});

 	$('.faculty-grades-history-page #faculty_home .selects').on('change', 'select#grades-history-handled-select-section', function() {
 		grades_history_classes_handled.column(7).search($(this).val() ? "^" + $(this).val() + "$" : '', true, false).draw();
 	});

 	$('.faculty-grades-history-page #faculty_home .selects').on('change', 'select#grades-history-handled-select-teacher', function() {
 		grades_history_classes_handled.column(6).search($(this).val() ? "^" + $(this).val() + "$" : '', true, false).draw();
 	});

 	$('.faculty-grades-history-page #faculty_home .selects').on('change', 'select#grades-history-handled-select-year', function() {
 		grades_history_classes_handled.column(8).search($(this).val() ? "^" + $(this).val() + "$" : '', true, false).draw();

 		var data = new Array('filter-selects2', $(this).val());
 		$.ajax({
 			context: this,
 			type: 'get',
 			url: 'app/model/faculty-exts/faculty-ajax.php',
 			data: {data:data},
 			success: function (result) {
 				var newdata = JSON.parse(result);
 				var sec = $('.faculty-grades-history-page #faculty_home #grades-history-handled-select-section');
 				var sub = $('.faculty-grades-history-page #faculty_home #grades-history-handled-select-subject');
 				sec.empty();
 				sec.append(newdata['sec']);
 				sub.empty();
 				sub.append(newdata['sub']);
 			}
 		});
 	});	

 	$('.faculty-grades-history-page #faculty_home .selects').on('change', 'select#grades-history-select-subject', function() {
 		grades_history_subject_handled.column(5).search($(this).val() ? "^" + $(this).val() + "$" : '', true, false).draw();
 	});

 	$('.faculty-grades-history-page #faculty_home .selects').on('change', 'select#grades-history-select-section', function() {
 		grades_history_subject_handled.column(6).search($(this).val() ? "^" + $(this).val() + "$" : '', true, false).draw();
 	});

 	$('.faculty-grades-history-page #faculty_home .selects').on('change', 'select#grades-history-select-year', function() {
 		grades_history_subject_handled.column(7).search($(this).val() ? "^" + $(this).val() + "$" : '', true, false).draw();

 		var data = new Array('filter-selects', $(this).val());
 		$.ajax({
 			context: this,
 			type: 'get',
 			url: 'app/model/faculty-exts/faculty-ajax.php',
 			data: {data:data},
 			success: function (result) {
 				var newdata = JSON.parse(result);
 				var sec = $('.faculty-grades-history-page #faculty_home #grades-history-select-section');
 				var sub = $('.faculty-grades-history-page #faculty_home #grades-history-select-subject');
 				sec.empty();
 				sec.append(newdata['sec']);
 				sub.empty();
 				sub.append(newdata['sub']);
 			}
 		});
 	});

 	$('.faculty-grades-form .first_td, .faculty-grades-form .second_td, .faculty-grades-form .third_td').on('input', 'input',function() {
 		var fourth_qtr = $(this).parent().parent().find('.fourth_qtr');
 		if (fourth_qtr.length === 1) {
 			fourth_qtr.trigger('input');
 		}
 	});

 	$('.faculty-grades-form').on('input', '.fourth_qtr',function() {
 		var first_qtr = $(this).parent().parent().find('.first_td input').val();
 		var second_qtr = $(this).parent().parent().find('.second_td input').val();
 		var third_qtr = $(this).parent().parent().find('.third_td input').val();
 		var remarks = $(this).parent().parent().find('.remarks');
 		if($(this).val() == '') {
 			remarks.val('');
 		}
 		if(first_qtr !== '' && second_qtr !== '' && third_qtr !== '') {
 			if ($(this).val() === 'INC') {
 				remarks.val('');
 				remarks.val('Incomplete Requirements');
 			} else if (!isNaN(parseInt($(this).val()))) {
 				var averageAll = Math.round((parseFloat(first_qtr) + parseFloat(second_qtr) + parseFloat(third_qtr) + parseFloat($(this).val())) / 4);
 				console.log(averageAll);
 				remarks.val('');
 				if (averageAll >= 75) {
 					remarks.val('Passed');
 				} else {
 					remarks.val('Failed');
 				}
 			}
 		}
 	});

 	var advisory_t2 = $('#adv-table-2').DataTable({
 		"columnDefs" : [{
 			"targets" : [1],
 			"visible" : false,
 		}],
 		"paging": false,
		// "searching": false,
		"info": false,
		"ordering": false
	});

 	var advisory_t4 = $('#adv-table-4, #adv-table-5, .attendance_student_summary').DataTable();

 	var getAdv_curValue = $('#transfer-sec_search').val();
 	advisory_t2.column(1).search(getAdv_curValue ? "^" + getAdv_curValue + "$" : '', true, false).draw();
 	
 	$('#transfer-sec_search').on('change', function() {
 		var current = $(this).val();
 		advisory_t2.column(1).search(current ? "^" + current + "$" : '', true, false).draw();
 	});

 	var currentSectionSelect = $('.faculty-editclass-page #getCurrentLevel').val();
 	getCurrentSection_faculty(currentSectionSelect);

 	$('.faculty-editclass-page #getCurrentLevel').on('change', function() {
 		var val = $(this).val();
 		getCurrentSection_faculty(val);
 	});

 	function getCurrentSection_faculty(value) {
 		var showThis = '.faculty-editclass-page .table-scroll #'+value;
 		var hideThis = '.faculty-editclass-page .table-scroll .classes-edit:not(#'+value+')';
 		$(hideThis).each(function() {
 			$(this).hide();
 		});
 		$(showThis).show();
 	}	

 	$('.faculty-editclass-page .classes-sched').on('change', 'select.editclass-teacher', function() {
 		var dept = $(this).find(':selected').data('facdept');
 		var sibling = $(this).siblings('select.editclass-subjects');
 		if (dept != null) {
 			$(sibling).find('option').each(function() {
 				$(this).hide();
 			});
 			$(sibling).find('option[data-subdept="'+dept+'"]').each(function() {
 				$(this).show();
 			});
 		} else {
 			$(this).siblings('select.editclass-subjects').val('');
 			$(sibling).find('option').each(function() {
 				$(this).show();
 			});
 		}
 	});

 	$('.faculty-editclass-page .classes-sched').on('change', 'select.editclass-subjects', function() {
 		var dept = $(this).find(':selected').data('subdept');
 		var sibling = $(this).siblings('select.editclass-teacher');
 		if (dept != null) {
 			$(sibling).find('option').each(function() {
 				$(this).hide();
 			});
 			$(sibling).find('option[data-facdept="'+dept+'"]').each(function() {
 				$(this).show();
 			});
 		} else {
 			$(this).siblings('select.editclass-teacher').val('');
 			$(sibling).find('option').each(function() {
 				$(this).show();
 			});
 		}
 	});

 	$('.faculty-editclass-page .classes-sched').on('click', 'button.reset', function(e) {
 		e.preventDefault();
 		$('select.editclass-teacher, select.editclass-subjects').find('option').each(function() {
 			$(this).show();
 		});
 		$('.faculty-editclass-page .classes-sched').trigger("reset");
 	});

 	var faculty_grades_table = $('#grades-list').DataTable({
 		"columnDefs" : [{
 			"targets" : [6,7],
 			"visible" : false,
 		}]
 	});

 	$('#grades-filter .boxs1').on('click', '#filterGradesTable', function() {
 		var select1 = $(this).siblings('select[name=sectionList]').val();
 		var select2 = $(this).siblings('select[name=subjList]').val();
 		faculty_grades_table.column(6).search(select1 ? select1 : '', true, false).column(7).search(select2 ? "^" + select2 + "$" : '', true, false).draw();
 	});

 	$('.faculty-attendance-form .date-subj').on('change', '.datepicker-attendance', function() {
 		var teacher = $(this).parentsUntil('.date-subj').siblings('.subject').find('input[name*="faculty-id"]').val();
 		var subject = $(this).parentsUntil('.date-subj').siblings('.subject').find('input[name*="subject-code"]').val();
 		var data = new Array('att-changedate', $(this).val(), $(this).data('section'), teacher, subject);
 		$.ajax({
 			context: this,
 			type: 'get',
 			url: 'app/model/faculty-exts/faculty-ajax.php',
 			data: {data:data},
 			success: function (result) {
 				$(this).parentsUntil('.date-subj').parent().siblings('.table-cont').find('tbody').empty();
 				$(this).parentsUntil('.date-subj').parent().siblings('.table-cont').find('tbody').append(result);
 			}
 		});
 	});

 	$('.faculty-attendance-form .date-subj').on('change', '.datepicker-attendance1', function() {
 		var data = new Array('att-changedate1', $(this).val(), $(this).data('section'), $('.faculty-attendance-form .subject input').val());
 		
 		$.ajax({
 			context: this,
 			type: 'get',
 			url: 'app/model/faculty-exts/faculty-ajax.php',
 			data: {data:data},
 			success: function (result) {
 				$(this).parentsUntil('.date-subj').parent().siblings('.table-cont1').find('tbody').empty();
 				$(this).parentsUntil('.date-subj').parent().siblings('.table-cont1').find('tbody').append(result);
 			}
 		});
 	});

 	$('.faculty-attendance-form .table-cont tbody').on('click', 'input', function() {
 		if ($(this).val() == 'Present') {
 			$(this).val('Late');
 			$(this).removeClass('present');
 			$(this).addClass('late');
 		} else if ($(this).val() == 'Late') {
 			$(this).val('Absent');
 			$(this).removeClass('late');
 			$(this).addClass('absent');
 		} else {
 			$(this).val('Present');
 			$(this).removeClass('absent');
 			$(this).addClass('present');
 		}
 	});

 	$('.faculty-attendance-form .table-cont1 tbody').on('click', 'input', function() {
 		if ($(this).val() == 'Unexcused') {
 			$(this).val('Excused');
 			$(this).removeClass('unexcused');
 			$(this).addClass('excused');
 		} else if ($(this).val() == 'Excused') {
 			$(this).val('Unexcused');
 			$(this).removeClass('excused');
 			$(this).addClass('unexcused');
 		} else {
 			$(this).val('Unexcused');
 			$(this).removeClass('unexcused');
 			$(this).addClass('unexcused');
 		}
 	});

 	$('#existing-guardian-autofill-submit').on('click', function() {
 		var data = new Array('filloutform', 'guar_id=' + $(this).siblings('#existing-guardian-autofill').val());

 		$('#faculty_home .contentpage .widget .enrollcontent .enrollment-form .save button').attr("disabled", true);
 		$.ajax({
 			type: 'POST',
 			url: 'app/model/faculty-exts/faculty-ajax.php',
 			data: {data:data},
 			success: function(result) {
 				$('[name=dialog]').dialog('close');
 				$('#auto-fill').load('faculty-enroll #auto-fill .form-row');
 				$('#faculty_home .contentpage .widget .enrollcontent .enrollment-form .save button').attr("disabled", false);
 			}
 		});
 	});

 	$('#student-form-request').on('change', '.check-all-student', function() {
 		$('#student-form-request table tbody input[type=checkbox]').each(function() {
 			$(this).prop("checked", $('#student-form-request .check-all-student').is(':checked'));
 		});
 	});

 	$('#student-form-request-cancel').on('change', '.check-all-student', function() {
 		$('#student-form-request-cancel table tbody input[type=checkbox]').each(function() {
 			$(this).prop("checked", $('#student-form-request-cancel .check-all-student').is(':checked'));
 		});
 	});

 	$('#student-form-request-cancel table tbody').on('change', 'input[type=checkbox]', function() {
 		if(!this.checked) {
 			$('#student-form-request-cancel table .check-all-student').prop('checked', false);
 		}
 	});

 	$('#student-form-request table tbody').on('change', 'input[type=checkbox]', function() {
 		if(!this.checked) {
 			$('#student-form-request table .check-all-student').prop('checked', false);
 		}
 	});

 	$('.faculty-assess-page').on('click', '#print-this', function() {
 		$('.faculty-assess-page .print-container').printThis({
 			importCSS: true,
 			importStyle: true,
 		});
 	});
 }

 if ($('body').is('[class*="treasurer-"]')) {
 	var data_table = $(".treasurer-table-4" ).DataTable({
 		dom: "lBfrtip",
 		"lengthMenu": [[5, 10, 25, -1], [5, 10, 25, 'All']],
 		buttons: [
 		'pdf', 'print'
 		],
 		"searching" : false
 	});

 	var data_table1 = $(".treasurer-table-1" ).DataTable({
 		"initComplete": function (settings, json) {  
 			$(".treasurer-table-1").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
 		},
 		dom: "lBfrtip",
 		"lengthMenu": [[5, 10, 25, -1], [5, 10, 25, 'All']],
 		buttons: [
 		'pdf', 'print'
 		]
 	});

 	var data_table2 = $("#treasurer-table-6" ).DataTable({
 		"initComplete": function (settings, json) {  
 			$("#treasurer-table-6").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
 		},
 		dom: "lBfrtip",
 		"lengthMenu": [[5, 10, 25, -1], [5, 10, 25, 'All']],
 		buttons: [
 		'pdf', 'print'
 		]
 	});

 	var tres_table_2 = $('#treasurer-table-2').DataTable({
 		"initComplete": function (settings, json) {  
			$("#treasurer-table-2").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
		},
 		dom: 'Bfrtip',
 		"columnDefs": [{
 			"targets": [7],
 			"visible": false,
 		}],
 		buttons: [
 		'pdf', 'print'
 		],
 		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
 	});

 	var tres_table_3 = $('#treasurer-table-3').DataTable({
 		"initComplete": function (settings, json) {  
			$("#treasurer-table-3").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
		},
 		dom: 'Bfrtip',
 		"columnDefs": [{
 			"targets": [6],
 			"visible": false,
 		}],
 		buttons: [
 		'pdf', 'print'
 		]
 	});

 	var tres_table_5 = $('#treasurer-table-5').DataTable({
 		dom: 'Bfrtip',
 		"columnDefs": [{
 			"targets": [3],
 			"visible": false,
 		}],
 		buttons: [
 		'pdf', 'print'
 		]
 	});

 	$( '#treasurer_home .contentpage .widget .eventcontent .cont1 select[name=year_level]' ).on('change', function() {
 		tres_table_2.column(7).search($(this).val() ? '^'+$(this).val()+'$' : '', true, false).draw();
 	});

 	$( '#treasurer_home .contentpage .widget .eventcontent .cont1 select[name=bal_status]' ).on('change', function() {
 		tres_table_2.column(3).search($(this).val() ? '^'+$(this).val()+'$' : '', true, false).draw();
 		tres_table_3.column(4).search($(this).val() ? '^'+$(this).val()+'$' : '', true, false).draw();
 	});

 	$('.treasurer-reports-page .widgetContent #unique #unique1 #unique2 span.wtotal').each(function() {
 		if ($(this).data('wtotal') != $('#treasurer_home .contentpage .widget .eventcontent .cont1 select').val()) {
 			$(this).hide();
 		} else {
 			$(this).show();
 		}
 	});

 	$( '#treasurer_home .contentpage .widget .eventcontent .cont1 select[name=year]' ).on('change', function() {
 		tres_table_3.column(6).search($(this).val() ? '^'+$(this).val()+'$' : '', true, false).draw();
 		tres_table_5.column(3).search($(this).val() ? '^'+$(this).val()+'$' : '', true, false).draw();
 		data_table2.column(3).search($(this).val() ? '^'+$(this).val()+'$' : '', true, false).draw();
 		$('.treasurer-balance-page .widgetContent #unique #unique1 #unique2 span.wmiscfee').each(function() {
 			if ($(this).data('miscfee') != $('#treasurer_home .contentpage .widget .eventcontent .cont1 select').val()) {
 				$(this).hide();
 			} else {
 				$(this).show();
 			}
 		});
 		$('.treasurer-reports-page .widgetContent #unique #unique1 #unique2 span.wtotal').each(function() {
 			if ($(this).data('wtotal') != $('#treasurer_home .contentpage .widget .eventcontent .cont1 select').val()) {
 				$(this).hide();
 			} else {
 				$(this).show();
 			}
 		});
 	});
 	/*LOAD DEFAULT*/
 	tres_table_5.column(3).search($('#treasurer_home .contentpage .widget .eventcontent .cont1 select').val() ? $('#treasurer_home .contentpage .widget .eventcontent .cont1 select').val() : '', true, false).draw();
 	tres_table_3.column(6).search($('#treasurer_home .contentpage .widget .eventcontent .cont1 select').val() ? $('#treasurer_home .contentpage .widget .eventcontent .cont1 select').val() : '', true, false).draw();

 	$('.treasurer-balance-page .widgetContent #unique #unique1 #unique2 span.wmiscfee').each(function() {
 		if ($(this).data('miscfee') != $('#treasurer_home .contentpage .widget .eventcontent .cont1 select').val()) {
 			$(this).hide();
 		} else {
 			$(this).show();
 		}
 	});

 	$('.treasurer-statistics-page .statementContent .cont2').each(function() {
 		if ($('.treasurer-statistics-page #select-year-level').val() == $(this).data('lvl')) {
 			$(this).show();
 		} else {
 			$(this).hide();
 		}
 	});

 	$('.treasurer-statistics-page .charts-container .cont2').slick({

 	});
 	$('.treasurer-reports-page .charts-container .cont2').slick({

 	});

 	$('.treasurer-statistics-page').on('change', '#select-year-level', function() {
 		$('.treasurer-statistics-page .statementContent .cont2').each(function() {
 			if ($('.treasurer-statistics-page #select-year-level').val() == $(this).data('lvl')) {
 				$(this).show();
 			} else {
 				$(this).hide();
 			}
 		});
 	});

 	$( ".datepicker-payment" ).datepicker({
 		changeMonth: true,
 		dateFormat: 'yy-mm-dd',
 		maxDate: new Date, 
 		minDate: "-2m",
 		beforeShowDay: $.datepicker.noWeekends
 	}).datepicker("setDate", new Date());


 	$('#treasurer-end-trial button').on('click', function(e) {
 		e.preventDefault();
 		swal({
 			title: "Are you sure to end this school year?",
 			text: "Once you click OK, the school year will end already!",
 			icon: "warning",
 			buttons: true,
 			dangerMode: true,
 		}).then((willAccept) => {
 			if (willAccept) {
 				$('#treasurer-end-trial').submit();
 			} else {
 				swal("Click Ok to cancel.");
 			}
 		});
 	});
 }



 if ($('body').is('[class*="admin-"]')) {
 	var admin_notif = $('#admin-notif-table').DataTable({
 		"initComplete": function (settings, json) {  
 			$("#admin-notif-table").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
 		},
 		"columnDefs" : [{
 			"targets" : [2],
 			"visible" : false
 		}],
 		"order": [[ 2, "desc" ]]
 	});

 	if ($('body[class*="admin-"] .menu-sidebar .menu nav ul li span.admin-notif').length) {
 		setInterval(function() {
			var data = 'data=getNotif';
			$.ajax({
				type: 'get',
				url: 'app/model/admin-exts/admin-ajax.php',
				data: data,
				success: function(result) {
					try {
						var data = JSON.parse(result);
						var current_no = parseInt($('body[class*="admin-"] .menu-sidebar .menu nav ul li span.admin-notif').text());
						var new_no = data["response"];
						if ((current_no != new_no) && $('body').is('[class*="admin-"]')) {
							var new_data = data["addthis"];
							$('body[class*="admin-"] .menu-sidebar .menu nav ul li span.admin-notif').empty();
							$('body[class*="admin-"] .menu-sidebar .menu nav ul li span.admin-notif').append(new_no);
							admin_notif.clear().draw();
							for (i = 0; i < new_data.length; i++) {
								admin_notif.row.add($(new_data[i])).draw();
							}
							if (new_no > current_no) {
		 						$.ambiance({
		 							message: "You have "+ new_no +" new notification!",
		 							type: "success"
		 						});
							}

 						}
 					} catch (e) {

 					}
 				}
 			});
		}, 2000);
	}
 	
 	$(function() {
 		var $form = $('.validateChangesInForm');
 		
 		var initialState = $form.serialize();
 		
 		$form.submit(function (e) {
 			if (initialState === $form.serialize()) {
 				alert('No changes');
 			} else {
 				$form = $(this).get(0);
 			}
 			e.preventDefault();
 		});
 	});
 	$(function() {
 		var $form = $('.validateChangesInFormCurriculum');
 		
 		var initialState = $form.serialize();
 		
 		$form.submit(function (e) {
 			if (initialState === $form.serialize()) {
 				alert('You are not allowed to update the curriculum!');
 			} else {
 				$form = $(this).get(0);
 			}
 			e.preventDefault();
 		});
 	});

 	$('[name=opener2]').each(function () {
 		var panel = $(this).siblings('[name=dialog2]');
 		$(this).click(function () {
 			panel.dialog('open');
 			$('.ui-widget-overlay').addClass('custom-overlay');
 		});
 	});

 	$('[name=dialog2]').dialog({
 		autoOpen: false,
 		modal: true,
 		resizable: false,
 		draggable: false
 	});

 	$('[name=opener3]').each(function () {
 		var panel = $(this).siblings('[name=dialog3]');
 		$(this).click(function () {
 			panel.dialog('open');
 			$('.ui-widget-overlay').addClass('custom-overlay');
 		});
 	});

 	$('[name=dialog3]').dialog({
 		autoOpen: true,
 		modal: true,
 		resizable: false,
 		draggable: false
 	});

 	$( ".enrollcontent .tabs" ).tabs({ active: 1 });
 	$( ".studentContent .tabs, .classesContent .tabs" ).tabs();

 	$( ".datepickerAdmin" ).datepicker({
 		changeMonth: true,
 		dateFormat: 'yy-mm-dd',
 		changeYear: true,
 		yearRange: "+0:+100"
 	});
 	
 	$("#checkAl").click(function () {
 		$('input:checkbox').not(this).prop('checked', this.checked);
 	});
 	
 	$("#checkAl1").click(function () {
 		$('input:checkbox.chkbox1').not(this).prop('checked', this.checked);
 	});
 	
 	$("#noFilterTable, #ptaTable").DataTable({
 		"initComplete": function (settings, json) {  
 			$("#noFilterTable, #ptaTable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
 		},
 		dom: "lBfrtip",
 		"paging":   false,
 		"ordering": false,
 		buttons: [
 		'excel','pdf'
 		],
 	});

 	$adminTableSection = $('#admin-table-section').DataTable({
 		"initComplete": function (settings, json) {  
 			$("#admin-table-section").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
 		},
 		dom: "lBfrtip",
 		buttons: [
 		{
 			extend: 'excelHtml5',
 			exportOptions: {
 				columns: [1,2]
 			}
 		},
 		{
 			extend: 'pdfHtml5',
 			exportOptions: {
 				columns: [1,2]
 			},
 			pageSize: 'Folio'
 		}
 		],
 	});
 	$adminTableClasses = $('#admin-table-classes').DataTable({
 		"initComplete": function (settings, json) {  
 			$("#admin-table-classes").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
 		},
 		dom: "lBfrtip",
 		buttons: [
 		{
 			extend: 'excelHtml5',
 			exportOptions: {
 				columns: [0,1,2,3]
 			}
 		},
 		{
 			extend: 'pdfHtml5',
 			exportOptions: {
 				columns: [0,1,2,3]
 			},
 			pageSize: 'Folio'
 		}
 		],
 	});
 	$adminTableSubject = $('#admin-table-subject').DataTable({
 		"initComplete": function (settings, json) {  
 			$("#admin-table-subject").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
 		},
 		dom: "lBfrtip",
 		buttons: [
 		{
 			extend: 'excelHtml5',
 			exportOptions: {
 				columns: [1,2,3]
 			}
 		},
 		{
 			extend: 'pdfHtml5',
 			exportOptions: {
 				columns: [1,2,3]
 			},
 			pageSize: 'Folio'
 		}
 		],
 	});
 	$adminTableFaculty = $('#admin-table-faculty').DataTable({
 		"initComplete": function (settings, json) {  
 			$("#admin-table-faculty").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
 		},
 		dom: "lBfrtip",
 		buttons: [
 		{
 			extend: 'excelHtml5',
 			exportOptions: {
 				columns: [1,2,3,4,5,6]
 			}
 		},
 		{
 			extend: 'pdfHtml5',
 			exportOptions: {
 				columns: [1,2,3,4,5,6]
 			},
 			pageSize: 'Folio'
 		}
 		],
 	});
 	$adminTableParent = $('#admin-table-treasurer').DataTable({
 		"initComplete": function (settings, json) {  
 			$("#admin-table-treasurer").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
 		},
 		dom: "lBfrtip",
 		buttons: [
 		{
 			extend: 'excelHtml5',
 			exportOptions: {
 				columns: [1,2,3]
 			}
 		},
 		{
 			extend: 'pdfHtml5',
 			exportOptions: {
 				columns: [1,2,3]
 			},
 			pageSize: 'Folio'
 		}
 		],
 		
 	});
 	$adminTableEvents = $('#admin-table-events').DataTable({
 		"initComplete": function (settings, json) {  
 			$("#admin-table-events").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
 		},
 		dom: "lBfrtip",
 		buttons: [
 		{
 			extend: 'excelHtml5',
 			exportOptions: {
 				columns: [1,2,3,4]
 			}
 		},
 		{
 			extend: 'pdfHtml5',
 			exportOptions: {
 				columns: [1,2,3,4]
 			},
 			pageSize: 'Folio'
 		}
 		],
 	});
 	var calendarAdmin = $('#calendarAdmin').fullCalendar({
 		editable:true,
 		header:{
 			left:'prev,next today',
 			center:'title',
 			right:'month,agendaWeek,agendaDay'
 		},
 		events: 'app/model/unstructured/loadEvent.php',
 		selectable:true,
 		selectHelper:true,
 		editable:true,
 		eventResize:function(event)
 		{
 			var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
 			var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
 			var id = event.id;
 			$.ajax({
 				url:"app/model/unstructured/updateEvent.php",
 				type:"POST",
 				data:{start:start, end:end, id:id},
 				success:function(){
 					calendarAdmin.fullCalendar('refetchEvents');
 					alert('Event Update');
 				}
 			})
 		},

 		eventDrop:function(event)
 		{
 			var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
 			var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
 			var title = event.title;
 			var id = event.id;
 			$.ajax({
 				url:"app/model/unstructured/updateEvent.php",
 				type:"POST",
 				data:{title:title, start:start, end:end, id:id},
 				success:function()
 				{
 					calendarAdmin.fullCalendar('refetchEvents');
 					alert("Event Updated");	
 				}
 			});
 		},
 		
 		eventClick:function(event)
 		{
 			if(confirm("Are you sure you want to remove it?"))
 			{
 				var id = event.id;
 				$.ajax({
 					url:"app/model/unstructured/deleteEvent.php",
 					type:"POST",
 					data:{id:id},
 					success:function()
 					{
 						calendarAdmin.fullCalendar('refetchEvents');
 						alert("Event Removed");
 					}
 				})
 			}
 		},

 	});

 	$( '#faculty_home .contentpage .widget .studentContent .cont .filtStudTable' ).change(function() {
 		var grade = $(this).val();
 		var data = 'grade='+grade;
 		
 		$.ajax({
 			type: 'POST',
 			url: 'app/model/unstructured/get-stud-list.php',
 			data: data,
 			success: function(result) {
 				datatable.clear().draw();
 				datatable.rows.add($.parseJSON(result)); 
 				datatable.columns.adjust().draw();
 			}
 		});
 	});

 	var adminTable = $('#admin-table-balstatus').DataTable({
 		"initComplete": function (settings, json) {  
 			$("#admin-table-balstatus").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
 		},
 		dom: "lBfrtip",
 		"columnDefs" : [{
 			"targets" : [7],
 			"visible" : false
 		}],
 		buttons: [
 		{
 			extend: 'excelHtml5',
 			exportOptions: {
 				columns: ':visible'
 			}
 		},
 		{
 			extend: 'pdfHtml5',
 			exportOptions: {
 				columns: ':visible'
 			},
 			pageSize: 'Folio'
 		}
 		],
 		fixedColumns:   {
 			leftColumns: 1
 		}
 	});

 	$( '#admin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.year_level_balstatus1', function(e) {
 		var val1 = $(this).val();
 		adminTable.column(7).search(val1 ? "^" + val1 + "$"  : '', true, false).draw();
 	});

 	$( '#admin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.year_level_balstatus2', function(e) {
 		var val2 = $(this).val();
 		adminTable.column(6).search(val2 ? "^" + val2 + "$" : '', true, false).draw();
 	});

 	var adminTablePaymentHistory = $('#admin-table-paymentHistory').DataTable({
 		"initComplete": function (settings, json) {  
 			$("#admin-table-paymentHistory").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
 		},
 		dom: "lBfrtip",
 		"columnDefs" : [{
 			"targets" : [8],
 			"visible" : false
 		}],
 		buttons: [
 		{
 			extend: 'excelHtml5',
 			exportOptions: {
 				columns: ':visible'
 			}
 		},
 		{
 			extend: 'pdfHtml5',
 			exportOptions: {
 				columns: ':visible'
 			},
 			pageSize: 'Folio',
 			orientation: 'landscape'
 		}
 		]
 	});

 	$( '#admin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.year_level_balstatus1', function(e) {
 		var val1 = $(this).val();
 		adminTablePaymentHistory.column(8).search(val1 ? "^" + val1 + "$"  : '', true, false).draw();
 	});

 	$( '#admin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.year_level_balstatus2', function(e) {
 		var val2 = $(this).val();
 		adminTablePaymentHistory.column(7).search(val2 ? "^" + val2 + "$" : '', true, false).draw();
 	});

 	$( '#admin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.year_level_balstatus3', function(e) {
 		var val2 = $(this).val();
 		adminTablePaymentHistory.column(4).search(val2 ? "^" + val2 + "$" : '', true, false).draw();
 	});
 	adminTablePaymentHistory.column(4).search($('.year_level_balstatus3').val() ? $('.year_level_balstatus3').val() : '', true, false).draw();

 	$( '#admin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.year_level_balstatus3', function(e) {
 		var val2 = $(this).val();
 		adminTablePaymentHistory.column(4).search(val2 ? "^" + val2 + "$" : '', true, false).draw();
 		
 		$('#admin_home .contentpage .widget .balContent .cont1 .box4 span.wtotal').each(function() {
 			if ($(this).data('wtotal') != $('#admin_home .contentpage .widget .balContent .cont1 .box2 .year_level_balstatus3').val()) {
 				$(this).hide();
 			} else {
 				$(this).show();
 			}
 		});
 		
 		$('#admin_home .contentpage .widget .balContent .cont1 .box5 span.wtotal').each(function() {
 			if ($(this).data('wtotal') != $('#admin_home .contentpage .widget .balContent .cont1 .box2 .year_level_balstatus3').val()) {
 				$(this).hide();
 			} else {
 				$(this).show();
 			}
 		});
 	});
 	$('#admin_home .contentpage .widget .balContent .cont1 .box4 span.wtotal').each(function() {
 		if ($(this).data('wtotal') != $('#admin_home .contentpage .widget .balContent .cont1 .box2 .year_level_balstatus3').val()) {
 			$(this).hide();
 		} else {
 			$(this).show();
 		}
 	});
 	
 	$('#admin_home .contentpage .widget .balContent .cont1 .box5 span.wtotal').each(function() {
 		if ($(this).data('wtotal') != $('#admin_home .contentpage .widget .balContent .cont1 .box2 .year_level_balstatus3').val()) {
 			$(this).hide();
 		} else {
 			$(this).show();
 		}
 	});


 	var adminTableFeetypeHistory = $('#admin-table-feetypeHistory').DataTable({
 		"initComplete": function (settings, json) {  
 			$("#admin-table-feetypeHistory").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
 		},
 		dom: "lBfrtip",
 		buttons: [
 		{
 			extend: 'excelHtml5',
 			exportOptions: {
 				columns: ':visible'
 			}
 		},
 		{
 			extend: 'pdfHtml5',
 			exportOptions: {
 				columns: ':visible'
 			},
 			pageSize: 'Folio'
 		}
 		],
 		fixedColumns:   {
 			leftColumns: 1
 		}
 	});

 	$( '#admin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.year_level_balstatus1', function(e) {
 		var val1 = $(this).val();
 		adminTableFeetypeHistory.column(3).search(val1 ? "^" + val1 + "$"  : '', true, false).draw();
 	});

 	$( '#yearAdminTable' ).on('change', function() {
 		var val = $(this).val();
 		adminTableFeetypeHistory.column(3).search(val ? val : '', true, false).draw();
 		$('#admin_home .contentpage .widget .feeTypeHistoryContent .cont1 .box4 span.wtotal').each(function() {
 			if ($(this).data('wtotal') != $('#admin_home .contentpage .widget .feeTypeHistoryContent .cont1 .box2 .year_level_balstatus1').val()) {
 				$(this).hide();
 			} else {
 				$(this).show();
 			}
 		});
 		
 		$('#admin_home .contentpage .widget .feeTypeHistoryContent .cont1 .box5 span.wtotal').each(function() {
 			if ($(this).data('wtotal') != $('#admin_home .contentpage .widget .feeTypeHistoryContent .cont1 .box2 .year_level_balstatus1').val()) {
 				$(this).hide();
 			} else {
 				$(this).show();
 			}
 		});
 	});
 	$('#admin_home .contentpage .widget .feeTypeHistoryContent .cont1 .box4 span.wtotal').each(function() {
 		if ($(this).data('wtotal') != $('#admin_home .contentpage .widget .feeTypeHistoryContent .cont1 .box2 .year_level_balstatus1').val()) {
 			$(this).hide();
 		} else {
 			$(this).show();
 		}
 	});
 	
 	$('#admin_home .contentpage .widget .feeTypeHistoryContent .cont1 .box5 span.wtotal').each(function() {
 		if ($(this).data('wtotal') != $('#admin_home .contentpage .widget .feeTypeHistoryContent .cont1 .box2 .year_level_balstatus1').val()) {
 			$(this).hide();
 		} else {
 			$(this).show();
 		}
 	});
 	adminTableFeetypeHistory.column(3).search($('#yearAdminTable').val() ? $('#yearAdminTable').val() : '', true, false).draw();


 	var adminTable3 = $('#admin-table-enrolled').DataTable({
 		dom: "lBfrtip",
 		"columnDefs" : [{
 			"targets" : [8],
 			"visible" : false
 		}],
 		buttons: [
 		{
 			extend: 'excelHtml5',
 			exportOptions: {
 				columns: ':visible'
 			}
 		},
 		{
 			extend: 'pdfHtml5',
 			exportOptions: {
 				columns: ':visible'
 			},
 			orientation: 'landscape',
 			pageSize: 'Folio'
 		}
 		],
 	});
 	$( '#admin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.year_level_enrolled', function() {
 		var val3 = $(this).val();
 		adminTable3.column(8).search(val3 ? "^" + val3 + "$"  : '', true, false).draw();
 	});


 	var adminTable4 = $('#admin-table-payhist').DataTable({
 		"initComplete": function (settings, json) {  
 			$("#admin-table-payhist").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
 		},
 		dom: "lBfrtip",
 		"columnDefs" : [{
 			"targets" : [8],
 			"visible" : false
 		}],
 		buttons: [
 		{
 			extend: 'excelHtml5',
 			exportOptions: {
 				columns: [0,1,2,3,4,5,6]
 			}
 		},
 		{
 			extend: 'pdfHtml5',
 			exportOptions: {
 				columns: [0,1,2,3,4,5,6]
 			},
 			orientation: 'landscape',
 			pageSize: 'Folio'
 		}
 		]
 		
 	});
 	$( '#admin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.year_level_payhist', function() {
 		var val4 = $(this).val();
 		adminTable4.column(8).search(val4 ? "^" + val4 + "$"  : '', true, false).draw();
 	});

 	var adminTable5 = $('#admin-table-logs').DataTable({
 		"initComplete": function (settings, json) {  
 			$("#admin-table-logs").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
 		},
 		dom: "lBfrtip",
 		buttons: [
 		{
 			extend: 'excelHtml5',
 			exportOptions: {
 				columns: [0,1,2,3]
 			}
 		},
 		{
 			extend: 'pdfHtml5',
 			exportOptions: {
 				columns: [0,1,2,3]
 			},
 			orientation: 'landscape',
 			pageSize: 'Folio'
 		}
 		],
 		"order": [[ 3, "desc" ]],
 		"columnDefs": [{
 			"targets": [4],
 			"visible": false
 		}],
 		ordering:false
 	});
 	$( '#admin_home .contentpage .widget .widgetContent .cont1 .box1' ).on('change', '.log_events', function() {
 		var val5 = $(this).val();
 		adminTable5.column(1).search(val5 ? val5 : '', true, false).draw();
 	});

 	$( '#admin_home .contentpage .widget .widgetContent .cont1 .box2' ).on('change', '.year_level', function(e) {
 		var val2 = $(this).val();
 		adminTable5.column(4).search(val2 ? "^" + val2 + "$" : '', true, false).draw();
 	});
 	adminTable5.column(4).search($('.year_level').val() ? $('.year_level').val() : '', true, false).draw();

 	var adminTable6 = $('#admin-table-student').DataTable({
 		"initComplete": function (settings, json) {  
 			$("#admin-table-student").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
 		},
 		dom: "lBfrtip",
 		buttons: [
 		{
 			extend: 'excelHtml5',
 			exportOptions: {
 				columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16]
 			},
 			orientation: 'landscape'
 		},
 		{
 			extend: 'pdfHtml5',
 			exportOptions: {
 				columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16]
 			},
 			orientation: 'landscape',
 			pageSize: 'Folio'
 		}
 		],
 	});

 	$( '#admin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.year_level_balstatus1', function(e) {
 		var val6 = $(this).val();
 		adminTable6.column(5).search(val6 ? "^" + val6 + "$"  : '', true, false).draw();
 	});

 	var adminTable7 = $('#admin-table-parent').DataTable({
 		"initComplete": function (settings, json) {  
 			$("#admin-table-parent").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
 		},
 		dom: "lBfrtip",
 		fixedColumns:   {
 			leftColumns: 1
 		},
 		buttons: [
 		{
 			extend: 'excelHtml5',
 			exportOptions: {
 				columns: [1,2,3,4,5,6,7,8]
 			},
 			orientation: 'landscape'
 		},
 		{
 			extend: 'pdfHtml5',
 			exportOptions: {
 				columns: [1,2,3,4,5,6,7,8]
 			},
 			orientation: 'landscape',
 			pageSize: 'Folio'
 		}
 		],
 		
 	});

 	$( '#admin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.year_level_balstatus1', function(e) {
 		var val7 = $(this).val();
 		adminTable7.column(6).search(val7 ? "^" + val7 + "$"  : '', true, false).draw();
 	});

 	$( '#admin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.year_level', function(e) {
 		var val8 = $(this).val();
 		adminTable8.column(4).search(val8 ? "^" + val8 + "$"  : '', true, false).draw();
 	});

 	var secCurrentAdmin = $('.admin-classes-page #getCurrentLevel').val();
 	getCurrentSectionAdmin(secCurrentAdmin);

 	$('.admin-classes-page #getCurrentLevel').on('change', function() {
 		var val = $(this).val();
 		getCurrentSectionAdmin(val);
 	});

 	function getCurrentSectionAdmin(value) {
 		var showThis = '.admin-classes-page .table-scroll #'+value;
 		var hideThis = '.admin-classes-page .table-scroll .classes-edit:not(#'+value+')';
 		$(hideThis).each(function() {
 			$(this).hide();
 		});
 		$(showThis).show();
 	}
 	
 	var TableSubjects = $('#table-subjects').DataTable({
 		"initComplete": function (settings, json) {  
 			$("#table-subjects").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
 		},
 		stateSave: true,
 		paging: false,
 		info: false,
 		searching: false
 	});

 	var CurriculumTable = $('#curriculumTable').DataTable({
 		"initComplete": function (settings, json) {  
 			$("#curriculumTable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
 		},
 		stateSave: true,
 		paging: false,
 		info: false
 	});

 	$('#curriculumTable tbody').on( 'click', 'tr', function () {
 		if ( $(this).hasClass('selected') ) {
 			$(this).removeClass('selected');
 		}
 		else {
 			CurriculumTable.$('tr.selected').removeClass('selected');
 			$(this).addClass('selected');
 		}
 	} );

 	$('#addRow').on( 'click', function () {
 		CurriculumTable.row.add( [
 			'<select name="subj_level[]" data-validation="required"><option selected disabled hidden>Select Subject Level</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select>' ,
 			'<input type="text" list="subjects" name="subj_dept[]"/><datalist  name="subj_dept[]" id="subjects" data-validation="required" required><option selected disabled hidden>Subject Department</option><option value="Filipino">Filipino</option><option value="Math">Math</option><option value="MAPEH">MAPEH</option><option value="Science">Science</option><option value="AP">AP</option><option value="Math">Math</option><option value="English">English</option><option value="TLE">TLE</option><option value="Math">Math</option></datalist>',
 			'<input type="text" name="subj_name[]" data-validation="length custom" data-validation-length="max45" data-validation-regexp="^[a-zA-Z0-9\-& ]+$" data-validation-error-msg="Enter less than 45 characters and Alphaneumerics only" value="" data-validation="required" required placeholder="Subject Name" class="subject-name">'
 			] ).draw( false );
 	} );
 	$('#removeRow').click( function () {
 		/*CurriculumTable.row('tr:last').remove().draw( false );*/
 		CurriculumTable.row('.selected').remove().draw( false );
 	} );

    // Automatically add a first row of data
    $('#addRow').click();
    $('#removeRow').click(function(){
    	$('tr:last').remove()
    });

    var adminTableCurriculum = $('#admin-table-curriculum').DataTable({
    	"initComplete": function (settings, json) {  
    		$("#admin-table-curriculum").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
    	},
    	dom: "lBfrtip",
    	searching: true,
    	/*"bFilter": true,*/
    	responsive: true,
    	buttons: [
    	{
    		extend: 'excelHtml5',
    		exportOptions: {
    			columns: [1,2,3]
    		},
    		orientation: 'landscape'
    	},
    	{
    		extend: 'pdfHtml5',
    		exportOptions: {
    			columns: [1,2,3]
    		},
    		orientation: 'landscape',
    		pageSize: 'Folio'
    	}
    	],
    	"columnDefs": [{
    		"targets": [3],
    		"visible": false,
    	}],
    	"lengthMenu": [[10, 25, -1], [10, 25, "All"]]
    });

    /*uncomment to customize search filter*/
/*$("#admin-table-curriculum_filter").addClass("hidden"); // hidden search input

$("#serachInput").on("input", function (e) {
   e.preventDefault();
   $('#admin-table-curriculum').DataTable().search($(this).val()).draw();
});*/

	$( '#super_unique' ).on('change', function() {
		var val = $(this).val();
		adminTableCurriculum.column(3).search(val ? val : '', true, false).draw();
	});
	adminTableCurriculum.column(3).search($('#super_unique').val() ? $('#super_unique').val() : '', true, false).draw();
}



if ($('body').is('[class*="superadmin-"]')) {
	var sanotif_1 = $('#superadmin_feeType_request').DataTable({
		"initComplete": function (settings, json) {  
			$("#superadmin_feeType_request").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
		},
		dom: "lBfrtip",
		buttons: [
		{
			extend: 'excelHtml5',
			exportOptions: {
				columns: [1,2]
			}
		},
		{
			extend: 'pdfHtml5',
			exportOptions: {
				columns: [1,2]
			},
			pageSize: 'Folio'
		}
		],
	});

	if ($('body[class*="superadmin-"] .menu-sidebar .menu nav ul li span.notification_sa_1').length) {
		/*$(".widgetHide").addClass("hidden");*/
		setInterval(function() {
			var data = 'getNotif';
			$.ajax({
				type: 'get',
				url: 'app/model/superadmin-exts/superadmin-ajax.php',
				data: data,
				success: function(result) {
					try {
						var data = JSON.parse(result);
						var current_no = parseInt($('body[class*="superadmin-"] .menu-sidebar .menu nav ul li span.notification_sa_1').text());
						var new_no = data["response"];
						if(new_no === 0){
							$('.FeeTypeWidgetHide').addClass('hidden');
						}else{
							$('.FeeTypeWidgetHide').removeClass('hidden');
							$('.FeeTypeWidgetHide').addClass('show');
						}
						if ((current_no != new_no) && $('body').is('[class*="superadmin-"]')) {
							var new_data = data["addthis"];
							$('body[class*="superadmin-"] .menu-sidebar .menu nav ul li span.notification_sa_1').empty();
							$('body[class*="superadmin-"] .menu-sidebar .menu nav ul li span.notification_sa_1').append(new_no);
							sanotif_1.clear().draw();
							for (i = 0; i < new_data.length; i++) {
								sanotif_1.row.add($(new_data[i])).draw();
							}
 					/*	$.ambiance({
 							message: "There is a change in your advisory class!",
 							title: "Success!",
 							type: "success"
 						});*/

 					}
 				} catch (e) {

 				}
 			}
 		});
		}, 2000);
	}

	var superadminTableTransfer = $('#superadmin-table-transfer').DataTable({
		"initComplete": function (settings, json) {  
			$("#superadmin-table-transfer").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
		}
	});
	if ($('body[class*="superadmin-"] .menu-sidebar .menu nav ul li span.notificationTransfer').length) {
		setInterval(function() {
			var data = new Array('getTransferNotif', parseInt($('body[class*="superadmin-"] .menu-sidebar .menu nav ul li span.notificationTransfer').text()));
			if ($('body[class*="superadmin-"] .menu-sidebar .menu nav ul li span.notificationTransfer').length) {
				$.ajax({
					type: 'get',
					url: 'app/model/superadmin-exts/superadmin-ajax.php',
					data: {data:data},
					success: function(result) {
						try {
							var data = JSON.parse(result);
							var current_no = parseInt($('body[class*="superadmin-"] .menu-sidebar .menu nav ul li span.notificationTransfer').text());
							var new_no = data["response"];
							if(new_no === 0){
								$('.transferCont').addClass('hidden');
							}else{
								$('.transferCont').removeClass('hidden');
								$('.transferCont').addClass('show');
							}
							if ((current_no != new_no) && $('body').is('[class*="superadmin-"]')) {
								var new_data = data["addthis"];
								
								$('body[class*="superadmin-"] .menu-sidebar .menu nav ul li span.notificationTransfer').empty();
								$('body[class*="superadmin-"] .menu-sidebar .menu nav ul li span.notificationTransfer').append(new_no);
								superadminTableTransfer.clear().draw();
								for (i = 0; i < new_data.length; i++) {
									superadminTableTransfer.row.add($(new_data[i])).draw();
								}
							}
						} catch (e) {
							
						}
					}
				});
			}
		}, 2000);	
	}

	var superadminTableCurriculum = $('#superadmin-table-curriculum').DataTable({
		"initComplete": function (settings, json) {  
			$("#superadmin-table-curriculum").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
		},
		dom: "lBfrtip",
		buttons: [
		{
			extend: 'excelHtml5',
			exportOptions: {
				columns: ':visible'
			},
			orientation: 'landscape'
		},
		{
			extend: 'pdfHtml5',
			exportOptions: {
				columns: ':visible'
			},
			orientation: 'landscape',
			pageSize: 'Folio'
		}
		],
		"columnDefs": [{
			"targets": [3],
			"visible": false,
		}],
		"lengthMenu": [[10, 25, -1], [10, 25, "All"]]
	});

	$( '#super_unique' ).on('change', function() {
		var val = $(this).val();
		superadminTableCurriculum.column(3).search(val ? val : '', true, false).draw();
	});

	$( ".datepicker-schoolyear" ).datepicker({
		changeMonth: true,
		dateFormat: 'yy-mm',
		changeYear: true,
		yearRange: "+0:+100",
 	/*onClose: function(dateText, inst) { 
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
       }*/
  }).focus(function() {
  	$(".ui-datepicker-prev, .ui-datepicker-next").remove();
  });
  
  $( ".datepicker-schoolyearStart" ).datepicker({
  	changeMonth: true,
  	dateFormat: 'yy-mm',
  	changeYear: true,
  	yearRange: "+0:+100",
  	onClose: function(dateText, inst) { 
  		$(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
  	}
  }).focus(function() {
  	$(".ui-datepicker-prev, .ui-datepicker-next").remove();
  });

  $( ".datepicker-schoolyearEnd" ).datepicker({
  	changeMonth: true,
  	dateFormat: 'yy-mm',
  	changeYear: true,
  	yearRange: "+0:+100",
  	onClose: function(dateText, inst) { 
  		$(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
  	}
  }).focus(function() {
  	$(".ui-datepicker-prev, .ui-datepicker-next").remove();
  });
  
  $( ".datepicker-superadmin" ).datepicker({
  	changeMonth: true,
  	dateFormat: 'yy-mm',
  	changeYear: true,
  	yearRange: "+0:+100",
  	onClose: function(dateText, inst) { 
  		$(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
  	}
  }).focus(function() {
  	$(".ui-datepicker-prev, .ui-datepicker-next").remove();
  });

  var superadmingTableAll = $('#superadmin-table-all').DataTable({
  	"initComplete": function (settings, json) {  
  		$("#superadmin-table-all").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
  	},
  	dom: "lBfrtip",
  	buttons: [
  	{
  		extend: 'excelHtml5',
  		exportOptions: {
  			columns: ':visible'
  		}
  	},
  	{
  		extend: 'pdfHtml5',
  		exportOptions: {
  			columns: ':visible'
  		},
  		pageSize: 'Folio'
  	}
  	],
  	fixedColumns:   {
  		leftColumns: 1
  	}
  });
  
  var superadmingTableStudent = $('#superadmin-table-student').DataTable({
  	"initComplete": function (settings, json) {  
  		$("#superadmin-table-student").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
  	},
  	dom: "lBfrtip",
  	buttons: [
  	{
  		extend: 'excelHtml5',
  		exportOptions: {
  			columns: ':visible'
  		}
  	},
  	{
  		extend: 'pdfHtml5',
  		exportOptions: {
  			columns: ':visible'
  		},
  		pageSize: 'Folio',
  		orientation: 'landscape'
  	}
  	]
  });
  $( '#superadmin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.year_level_balstatus1', function(e) {
 		var val6 = $(this).val();
 		superadmingTableStudent.column(5).search(val6 ? "^" + val6 + "$"  : '', true, false).draw();
 	});
  var superadmingTableAnnouncement = $('#superadmin-table-announcement').DataTable({
  	"initComplete": function (settings, json) {  
  		$("#superadmin-table-announcement").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
  	},
  	dom: "lBfrtip",
  	buttons: [
  	{
  		extend: 'excelHtml5',
  		exportOptions: {
  			columns: ':visible'
  		}
  	},
  	{
  		extend: 'pdfHtml5',
  		exportOptions: {
  			columns: ':visible'
  		},
  		pageSize: 'Folio',
  		orientation: 'landscape'
  	}
  	]
  });

  
  var superadminTableBalStatus = $('#superadmin-table-balstatus').DataTable({
  	"initComplete": function (settings, json) {  
  		$("#superadmin-table-balstatus").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
  	},
  	dom: "lBfrtip",
  	"columnDefs" : [{
  		"targets" : [7],
  		"visible" : false
  	}],
  	buttons: [
  	{
  		extend: 'excelHtml5',
  		exportOptions: {
  			columns: ':visible'
  		}
  	},
  	{
  		extend: 'pdfHtml5',
  		exportOptions: {
  			columns: ':visible'
  		},
  		pageSize: 'Folio'
  	}
  	],
  	fixedColumns:   {
  		leftColumns: 1
  	}
  });
  


  $( '#superadmin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.year_level_balstatus1', function(e) {
  	var val1 = $(this).val();
  	superadminTableBalStatus.column(7).search(val1 ? "^" + val1 + "$"  : '', true, false).draw();
  });
  
  $( '#admin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.year_level_balstatus2', function(e) {
  	var val2 = $(this).val();
  	superadminTableBalStatus.column(6).search(val2 ? "^" + val2 + "$" : '', true, false).draw();
  });
  
  var superadminTableFeetypeHistory = $('#superadmin-table-feetypeHistory').DataTable({
  	"initComplete": function (settings, json) {  
  		$("#superadmin-table-feetypeHistory").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
  	},
  	dom: "lBfrtip",
  	buttons: [
  	{
  		extend: 'excelHtml5',
  		exportOptions: {
  			columns: ':visible'
  		}
  	},
  	{
  		extend: 'pdfHtml5',
  		exportOptions: {
  			columns: ':visible'
  		},
  		pageSize: 'Folio'
  	}
  	],
  	fixedColumns:   {
  		leftColumns: 1
  	}
  });

  $( '#superadmin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.year_level_balstatus1', function(e) {
  	var val1 = $(this).val();
  	superadminTableFeetypeHistory.column(3).search(val1 ? "^" + val1 + "$"  : '', true, false).draw();
  });

  $( '#yearSuperadminTable' ).on('change', function() {
  	var val = $(this).val();
  	superadminTableFeetypeHistory.column(3).search(val ? val : '', true, false).draw();
  	$('#superadmin_home .contentpage .widget .feeTypeHistoryContent .cont1 .box4 span.wtotal').each(function() {
  		if ($(this).data('wtotal') != $('#superadmin_home .contentpage .widget .feeTypeHistoryContent .cont1 .box2 .year_level_balstatus1').val()) {
  			$(this).hide();
  		} else {
  			$(this).show();
  		}
  	});
  	
  	$('#superadmin_home .contentpage .widget .feeTypeHistoryContent .cont1 .box5 span.wtotal').each(function() {
  		if ($(this).data('wtotal') != $('#superadmin_home .contentpage .widget .feeTypeHistoryContent .cont1 .box2 .year_level_balstatus1').val()) {
  			$(this).hide();
  		} else {
  			$(this).show();
  		}
  	});
  });
  $('#superadmin_home .contentpage .widget .feeTypeHistoryContent .cont1 .box4 span.wtotal').each(function() {
  	if ($(this).data('wtotal') != $('#superadmin_home .contentpage .widget .feeTypeHistoryContent .cont1 .box2 .year_level_balstatus1').val()) {
  		$(this).hide();
  	} else {
  		$(this).show();
  	}
  });
  
  $('#superadmin_home .contentpage .widget .feeTypeHistoryContent .cont1 .box5 span.wtotal').each(function() {
  	if ($(this).data('wtotal') != $('#superadmin_home .contentpage .widget .feeTypeHistoryContent .cont1 .box2 .year_level_balstatus1').val()) {
  		$(this).hide();
  	} else {
  		$(this).show();
  	}
  });
  superadminTableFeetypeHistory.column(3).search($('#yearSuperadminTable').val() ? $('#yearSuperadminTable').val() : '', true, false).draw();


  var superadminTableCurriculum2 = $('#superadmin-table-curriculum2').DataTable({
  	"initComplete": function (settings, json) {  
  		$("#superadmin-table-curriculum2").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
  	},
  	dom: "lBfrtip",
  	buttons: [
  	{
  		extend: 'excelHtml5',
  		exportOptions: {
  			columns: ':visible'
  		},
  		orientation: 'landscape'
  	},
  	{
  		extend: 'pdfHtml5',
  		exportOptions: {
  			columns: ':visible'
  		},
  		orientation: 'landscape',
  		pageSize: 'Folio'
  	}
  	],
  	"columnDefs": [{
  		"targets": [0],
  		"visible": false,
  	}],
  	"lengthMenu": [[10, 25, -1], [10, 25, "All"]]
  });

  $( '#super_unique2' ).on('change', function() {
  	var val = $(this).val();
  	superadminTableCurriculum2.column(0).search(val ? val : '', true, false).draw();
  });
  superadminTableCurriculum2.column(0).search($('#super_unique2').val() ? $('#super_unique2').val() : '', true, false).draw();


  var adminTableNoFunct=$( " #admin-table-noFunct" ).DataTable({
  	"initComplete": function (settings, json) {  
  		$("#admin-table-noFunct").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
  	},
  	"paging":   false,
  	"ordering": false,
  	"info": false,
  	buttons: false,
  	"searching":false,
  	stateSave: true
  });

  var superadminTableNoFunct=$( "#superadmin-table-noFunct" ).DataTable({
  	"initComplete": function (settings, json) {  
  		$("#superadmin-table-noFunct").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
  	},
  	"paging":   false,
  	"ordering": false,
  	"info": false,
  	buttons: false,
  	"searching":false,
  	stateSave: true
  });

  setInterval(function() {
  	var data = new Array('getCurriculumNotif', parseInt($('body[class*="superadmin-"] .menu-sidebar .menu nav ul li span.notificationCurriculum').text()));
  	if ($('body[class*="superadmin-"] .menu-sidebar .menu nav ul li span.notificationCurriculum').length) {
  		$.ajax({
  			type: 'get',
  			url: 'app/model/superadmin-exts/superadmin-ajax.php',
  			data: {data:data},
  			success: function(result) {
  				try {
  					var data = JSON.parse(result);
  					var current_no = parseInt($('body[class*="superadmin-"] .menu-sidebar .menu nav ul li span.notificationCurriculum').text());
  					var new_no = data["response"];
  					if(new_no === 0){
  						$('.SubjectWidgetHide').addClass('hidden');
  					}else{
  						$('.SubjectWidgetHide').removeClass('hidden');
  						$('.SubjectWidgetHide').addClass('show');
  					}
  					if ((current_no != new_no) && $('body').is('[class*="superadmin-"]')) {
  						var new_data = data["addthis"];
  						
  						$('body[class*="superadmin-"] .menu-sidebar .menu nav ul li span.notificationCurriculum').empty();
  						$('body[class*="superadmin-"] .menu-sidebar .menu nav ul li span.notificationCurriculum').append(new_no);
  						superadminTableNoFunct.clear().draw();
  						for (i = 0; i < new_data.length; i++) {
  							superadminTableNoFunct.row.add($(new_data[i])).draw();
  						}
  					}
  					
  				} catch (e) {
  					
  				}
  			}
  		});
  	}
  }, 2000);	

  var superadminTableSectionTop = $('#superadmin-table-section-top').DataTable({
  	"initComplete": function (settings, json) {  
  		$("#superadmin-table-section-top").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
  	},
  	dom: "lBfrtip",
  	buttons: [
  	{
  		extend: 'excelHtml5',
  		exportOptions: {
  			columns: [1,2]
  		}
  	},
  	{
  		extend: 'pdfHtml5',
  		exportOptions: {
  			columns: [1,2]
  		},
  		pageSize: 'Folio'
  	}
  	],
  });

  var superadminTableSection = $('#superadmin-table-section').DataTable({
  	"initComplete": function (settings, json) {  
  		$("#superadmin-table-section").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
  	},
  	dom: "lBfrtip",
  	buttons: [
  	{
  		extend: 'excelHtml5',
  		exportOptions: {
  			columns: [1,2]
  		}
  	},
  	{
  		extend: 'pdfHtml5',
  		exportOptions: {
  			columns: [1,2]
  		},
  		pageSize: 'Folio'
  	}
  	],
  });

  if ($('body[class*="superadmin-"] .menu-sidebar .menu nav ul li span.notification_sa_2').length) {
  	setInterval(function() {
  		var data = new Array('getSectionNotif', parseInt($('body[class*="superadmin-"] .menu-sidebar .menu nav ul li span.notification_sa_2').text()));
  		if ($('body[class*="superadmin-"] .menu-sidebar .menu nav ul li span.notification_sa_2').length) {
  			$.ajax({
  				type: 'get',
  				url: 'app/model/superadmin-exts/superadmin-ajax.php',
  				data: {data:data},
  				success: function(result) {
  					try {
  						var data = JSON.parse(result);
  						var current_no = parseInt($('body[class*="superadmin-"] .menu-sidebar .menu nav ul li span.notification_sa_2').text());
  						var new_no = data["response"];
  						if(new_no === 0){
  							$('.SectionWidget').addClass('hidden');
  						}else{
  							$('.SectionWidget').removeClass('hidden');
  							$('.SectionWidget').addClass('show');
  						}
  						if ((current_no != new_no) && $('body').is('[class*="superadmin-"]')) {
  							var new_data = data["addthis"];
  							$('body[class*="superadmin-"] .menu-sidebar .menu nav ul li span.notification_sa_2').empty();
  							$('body[class*="superadmin-"] .menu-sidebar .menu nav ul li span.notification_sa_2').append(new_no);
  							superadminTableSection.clear().draw();
  							for (i = 0; i < new_data.length; i++) {
  								superadminTableSection.row.add($(new_data[i])).draw();
  							}
  						}
  					} catch (e) {
  						
  					}
  				}
  			});
  		}
  	}, 2000);	
  }

  var superadminTableClassesRequest = $('#superadmin-table-classesRequest').DataTable({
  	"initComplete": function (settings, json) {  
  		$("#superadmin-table-classesRequest").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
  	},
  	dom: "lBfrtip",
  	buttons: [
  	{
  		extend: 'excelHtml5',
  		exportOptions: {
  			columns: ':visible'
  		}
  	},
  	{
  		extend: 'pdfHtml5',
  		exportOptions: {
  			columns: ':visible'
  		},
  		pageSize: 'Folio'
  	}
  	],
  });

  if ($('body[class*="superadmin-"] .menu-sidebar .menu nav li ul li span.classNotification').length) {
  	setInterval(function() {
  		var data = new Array('getClassNotif', parseInt($('body[class*="superadmin-"] .menu-sidebar .menu nav li ul li span.classNotification').text()));
  		if ($('body[class*="superadmin-"] .menu-sidebar .menu nav li ul li span.classNotification').length) {
  			$.ajax({
  				type: 'get',
  				url: 'app/model/superadmin-exts/superadmin-ajax.php',
  				data: {data:data},
  				success: function(result) {
  					try {
  						var data = JSON.parse(result);
  						var current_no = parseInt($('body[class*="superadmin-"] .menu-sidebar .menu nav li ul li span.classNotification').text());
  						var new_no = data["response"];
  						if(new_no === 0){
  							$('.ClassWidget').addClass('hidden');
  						}else{
  							$('.ClassWidget').removeClass('hidden');
  							$('.ClassWidget').addClass('show');
  						}
  						if ((current_no != new_no) && $('body').is('[class*="superadmin-"]')) {
  							var new_data = data["addthis"];
  							$('body[class*="superadmin-"] .menu-sidebar .menu nav li ul li span.classNotification').empty();
  							$('body[class*="superadmin-"] .menu-sidebar .menu nav li ul li span.classNotification').append(new_no);
  							superadminTableClassesRequest.clear().draw();
  							for (i = 0; i < new_data.length; i++) {
  								superadminTableClassesRequest.row.add($(new_data[i])).draw();
  							}
  						}
  					} catch (e) {
  						
  					}
  				}
  			});
  		}
  	}, 2000);	
  }

  $superadminTableClasses = $('#superadmin-table-classes').DataTable({
  	"initComplete": function (settings, json) {  
  		$("#superadmin-table-classes").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
  	},
  	dom: "lBfrtip",
  	buttons: [
  	{
  		extend: 'excelHtml5',
  		exportOptions: {
  			columns: ':visible'
  		}
  	},
  	{
  		extend: 'pdfHtml5',
  		exportOptions: {
  			columns: ':visible'
  		},
  		pageSize: 'Folio'
  	}
  	],
  });

  var secCurrentSuperAdmin = $('.superadmin-classschedule-page #getCurrentLevel').val();
  getCurrentSection1SuperAdmin(secCurrentSuperAdmin);

  $('.superadmin-classschedule-page #getCurrentLevel').on('change', function() {
  	var val = $(this).val();
  	getCurrentSection1SuperAdmin(val);
  });

  function getCurrentSection1SuperAdmin(value) {
  	var showThis = '.superadmin-classschedule-page .table-scroll #'+value;
  	var hideThis = '.superadmin-classschedule-page .table-scroll .classes-edit:not(#'+value+')';
  	$(hideThis).each(function() {
  		$(this).hide();
  	});
  	$(showThis).show();
  }

  $superadminTableClasses = $('#superadmin-table-classesList').DataTable({
  	"initComplete": function (settings, json) {  
  		$("#superadmin-table-classesList").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
  	},
  	dom: "lBfrtip",
  	buttons: [
  	{
  		extend: 'excelHtml5',
  		exportOptions: {
  			columns: ':visible'
  		}
  	},
  	{
  		extend: 'pdfHtml5',
  		exportOptions: {
  			columns: ':visible'
  		},
  		pageSize: 'Folio'
  	}
  	],
  });

  var superadminTablePayhist = $('#superadmin-table-payhist').DataTable({
  	"initComplete": function (settings, json) {  
  		$("#superadmin-table-payhist").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
  	},
  	dom: "lBfrtip",
  	"columnDefs" : [{
  		"targets" : [8],
  		"visible" : false
  	}],
  	buttons: [
  	{
  		extend: 'excelHtml5',
  		exportOptions: {
  			columns: ':visible'
  		}
  	},
  	{
  		extend: 'pdfHtml5',
  		exportOptions: {
  			columns: ':visible'
  		},
  		orientation: 'landscape',
  		pageSize: 'Folio'
  	}
  	]
  });


  $( '#superadmin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.year_level_payhist', function() {
  	var val4 = $(this).val();
  	superadminTablePayhist.column(8).search(val4 ? "^" + val4 + "$"  : '', true, false).draw();
  });

  var superadminTableEnrolled = $('#superadmin-table-enrolled').DataTable({
  	"initComplete": function (settings, json) {  
  		$("#superadmin-table-enrolled").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
  	},
  	dom: "lBfrtip",
  	"columnDefs" : [{
  		"targets" : [8],
  		"visible" : false
  	}],
  	buttons: [
  	{
  		extend: 'excelHtml5',
  		exportOptions: {
  			columns: ':visible'
  		}
  	},
  	{
  		extend: 'pdfHtml5',
  		exportOptions: {
  			columns: ':visible'
  		},
  		orientation: 'landscape',
  		pageSize: 'Folio'
  	}
  	],
  });

  $( '#superadmin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.year_level_enrolled', function() {
  	var val3 = $(this).val();
  	superadminTableEnrolled.column(8).search(val3 ? "^" + val3 + "$"  : '', true, false).draw();
  });

  var superadminTableLogs = $('#superadmin-table-logs').DataTable({
  	"initComplete": function (settings, json) {  
  		$("#superadmin-table-logs").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
  	},
  	dom: "lBfrtip",
  	buttons: [
  	{
  		extend: 'excelHtml5',
  		exportOptions: {
  			columns: ':visible'
  		}
  	},
  	{
  		extend: 'pdfHtml5',
  		exportOptions: {
  			columns: ':visible'
  		},
  		orientation: 'landscape',
  		pageSize: 'Folio'
  	}
  	],
  	"columnDefs": [{
  		"targets": [4],
  		"visible": false
  	}],
  	ordering: false
  });
  $( '#superadmin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.log_events', function() {
  	var val5 = $(this).val();
  	superadminTableLogs.column(1).search(val5 ? val5 : '', true, false).draw();
  });

  $( '#superadmin_home .contentpage .widget .widgetContent .cont1 .box2' ).on('change', '.year_level', function(e) {
  	var val2 = $(this).val();
  	superadminTableLogs.column(4).search(val2 ? "^" + val2 + "$" : '', true, false).draw();
  });
  superadminTableLogs.column(4).search($('.year_level').val() ? $('.year_level').val() : '', true, false).draw();

  var superadminTable = $('.superadmin-table, .superadmin-request-table, .superadmin-classrequest-table, .superadmin-table-withScroll').DataTable({
  	"initComplete": function (settings, json) {  
  		$(".superadmin-table, .superadmin-request-table, .superadmin-classrequest-table, .superadmin-table-withScroll").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
  	},
  	dom: "lBfrtip",
  	"columnDefs" : [{
  		"targets" : [7],
  		"visible" : false
  	}]
  });
  

  getCurrentSection('sec1');

  $('.superadmin-faculty-page #getCurrentLevel').on('change', function() {
  	var val = $(this).val();
  	getCurrentSection(val);
  });

  function getCurrentSection(value) {
  	var showThis = '.superadmin-faculty-page .table-scroll #'+value;
  	var hideThis = '.superadmin-faculty-page .table-scroll .classes-edit:not(#'+value+')';
  	$(hideThis).each(function() {
  		$(this).hide();
  	});
  	$(showThis).show();
  }

  getCurrentSection1('sec1');

  $('.superadmin-faculty-page #getCurrentLevel').on('change', function() {
  	var val = $(this).val();
  	getCurrentSection1(val);
  });

  function getCurrentSection1(value) {
  	var showThis = '.superadmin-faculty-page .table-scroll #'+value;
  	var hideThis = '.superadmin-faculty-page .table-scroll .classes-edit:not(#'+value+')';
  	$(hideThis).each(function() {
  		$(this).hide();
  	});
  	$(showThis).show();
  }

  var superadminTablePaymentHistory = $('#superadmin-table-paymentHistory').DataTable({
  	"initComplete": function (settings, json) {  
  		$("#superadmin-table-paymentHistory").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
  	},
  	dom: "lBfrtip",
  	"columnDefs" : [{
  		"targets" : [8],
  		"visible" : false
  	}],
  	buttons: [
  	{
  		extend: 'excelHtml5',
  		exportOptions: {
  			columns: ':visible'
  		}
  	},
  	{
  		extend: 'pdfHtml5',
  		exportOptions: {
  			columns: ':visible'
  		},
  		pageSize: 'Folio',
  		orientation: 'landscape'
  	}
  	],
  	fixedColumns:   {
  		leftColumns: 1
  	}
  });

  $( '#superadmin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.year_level_balstatus1', function(e) {
  	var val1 = $(this).val();
  	superadminTablePaymentHistory.column(8).search(val1 ? "^" + val1 + "$"  : '', true, false).draw();
  });

  $( '#superadmin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.year_level_balstatus2', function(e) {
  	var val2 = $(this).val();
  	superadminTablePaymentHistory.column(7).search(val2 ? "^" + val2 + "$" : '', true, false).draw();
  });

  $( '#superadmin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.year_level_balstatus3', function(e) {
  	var val2 = $(this).val();
  	superadminTablePaymentHistory.column(4).search(val2 ? "^" + val2 + "$" : '', true, false).draw();
  	
  	$('#superadmin_home .contentpage .widget .balContent .cont1 .box4 span.wtotal').each(function() {
  		if ($(this).data('wtotal') != $('#superadmin_home .contentpage .widget .balContent .cont1 .box2 .year_level_balstatus3').val()) {
  			$(this).hide();
  		} else {
  			$(this).show();
  		}
  	});
  	
  	$('#superadmin_home .contentpage .widget .balContent .cont1 .box5 span.wtotal').each(function() {
  		if ($(this).data('wtotal') != $('#superadmin_home .contentpage .widget .balContent .cont1 .box2 .year_level_balstatus3').val()) {
  			$(this).hide();
  		} else {
  			$(this).show();
  		}
  	});
  });
  $('#superadmin_home .contentpage .widget .balContent .cont1 .box4 span.wtotal').each(function() {
  	if ($(this).data('wtotal') != $('#superadmin_home .contentpage .widget .balContent .cont1 .box2 .year_level_balstatus3').val()) {
  		$(this).hide();
  	} else {
  		$(this).show();
  	}
  });
  
  $('#superadmin_home .contentpage .widget .balContent .cont1 .box5 span.wtotal').each(function() {
  	if ($(this).data('wtotal') != $('#superadmin_home .contentpage .widget .balContent .cont1 .box2 .year_level_balstatus3').val()) {
  		$(this).hide();
  	} else {
  		$(this).show();
  	}
  });

  $( '#yearSuperadminTable' ).on('change', function() {
  	var val = $(this).val();
  	superadminTablePaymentHistory.column(4).search(val ? val : '', true, false).draw();
  });
  superadminTablePaymentHistory.column(4).search($('#yearSuperadminTable').val() ? $('#yearSuperadminTable').val() : '', true, false).draw();

  if ($('body').is('[class*="superadmin-"]')) {
  	$('.superadmin-classedit-page').on('change', '#getCurrentLevel', function() {
  		var current = $(this).val();
  		$('.superadmin-classedit-page .classes-edit').each(function() {
  			var this_id = $(this).attr('id');
  			$(this).hide();
  			if(current === this_id) {
  				$(this).show();
  			}
  		});
  	});
  	$('.superadmin-classedit-page .classes-edit').each(function() {
  		var current = $('.superadmin-classedit-page #getCurrentLevel').val();
  		var this_id = $(this).attr('id');
  		$(this).hide();
  		if(current === this_id) {
  			$(this).show();
  		}
  	});
  }

  var superAdmin_grades = $('#superadmin-table-grades').DataTable({
  	"initComplete": function (settings, json) {  
  		$("#superadmin-table-grades").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
  	},
  	dom: "lBfrtip",
  	"columnDefs" : [{
  		"targets" : [2,3],
  		"visible" : true
  	}],
  	buttons: [
  	{
  		extend: 'excelHtml5',
  		exportOptions: {
  			columns: ':visible'
  		}
  	},
  	{
  		extend: 'pdfHtml5',
  		exportOptions: {
  			columns: ':visible'
  		},
  		pageSize: 'Folio'
  	}
  	],
  	fixedColumns:   {
  		leftColumns: 1
  	}
  });

  $('.superadmin-grades-page').on('change', '#gradeAndsection', function() {
  	superAdmin_grades.column(2).search($(this).val() ? $(this).val() : '', true, false).draw();
  });

  $('.superadmin-grades-page').on('change', '#subject-grades-subject', function() {
  	superAdmin_grades.column(4).search($(this).val() ? $(this).val() : '', true, false).draw();
  });

  $('.superadmin-grades-page').on('change', '#subject-grades-sy', function() {
  	superAdmin_grades.column(3).search($(this).val() ? $(this).val() : '', true, false).draw();
  });

  $( '#subject-grades-sy' ).on('change', function() {
  	var val = $(this).val();
  	superAdmin_grades.column(3).search(val ? val : '', true, false).draw();
  });
  superAdmin_grades.column(3).search($('#subject-grades-sy').val() ? $('#subject-grades-sy').val() : '', true, false).draw();

  var superadminTableParent = $('#superadmin-table-parent').DataTable({
  	"initComplete": function (settings, json) {  
  		$("#superadmin-table-parent").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
  	},
  	dom: "lBfrtip",
  	fixedColumns:   {
  		leftColumns: 1
  	},
  	buttons: [
  	{
  		extend: 'excelHtml5',
  		exportOptions: {
  			columns: [1,2,3,4,5,6,7,8]
  		},
  		orientation: 'landscape'
  	},
  	{
  		extend: 'pdfHtml5',
  		exportOptions: {
  			columns: [1,2,3,4,5,6,7,8]
  		},
  		orientation: 'landscape',
  		pageSize: 'Folio'
  	}
  	],
  	
  });

  $( '#superadmin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.year_level_balstatus1', function(e) {
  	var val7 = $(this).val();
  	superadminTableParent.column(6).search(val7 ? "^" + val7 + "$"  : '', true, false).draw();
  });
  if ($('body[class*="superadmin-"]').length) {
  	$('.superadmin-system-settings-page select[name=teacher]').on('change', function() {
  		var data = new Array('update-sec-priv', $(this).val());

  		$.ajax({
  			context: this,
  			type: 'post',
  			url: 'app/model/superadmin-exts/superadmin-ajax.php',
  			data: {data:data},
  			success: function (result) {
  				swal({
  					title: "Success!",
  					text: result,
  					icon: "success"
  				}).then(function() {
  					window.location = 'superadmin-system-settings';
  				});
  			}
  		}); 
  	});
  	$('.superadmin-system-settings-page input[name=switch-one]').on('change', function() {
  		var data = new Array('toggle-edit-class', $(this).val());

  		$.ajax({
  			context: this,
  			type: 'post',
  			url: 'app/model/superadmin-exts/superadmin-ajax.php',
  			data: {data:data},
  			success: function (result) {
  				swal({
  					title: "Success!",
  					text: result,
  					icon: "success"
  				}).then(function() {
  					window.location = 'superadmin-system-settings';
  				});
  			}
  		}); 
  	});
  	$('.superadmin-grades-page #gradeAndsection').on('change', function() {
  		var value = $(this).val();
  		var data = $(this).find(':selected').data('section');
  		$('.superadmin-grades-page #subject-grades-subject option').each(function() {
  			if($('.superadmin-grades-page #gradeAndsection').val() === '') {
  				$(this).show();
  			} else if($(this).data('subjectlvl') == $('.superadmin-grades-page #gradeAndsection').val()) {
  				$(this).show();
  			} else {
  				$(this).hide();
  			}
  		});
  	});
	$('.accordion-header').toggleClass('inactive-header');

	var contentwidth = $('.accordion-header').width();
	$('.accordion-content').css({'width' : contentwidth });

	$('.accordion-header').first().toggleClass('active-header').toggleClass('inactive-header');
	$('.accordion-content').first().slideDown().toggleClass('open-content');

	$('.accordion-header').click(function () {
		if($(this).is('.inactive-header')) {
			$('.active-header').toggleClass('active-header').toggleClass('inactive-header').next().slideToggle().toggleClass('open-content');
			$(this).toggleClass('active-header').toggleClass('inactive-header');
			$(this).next().slideToggle().toggleClass('open-content');
		}
		
		else {
			$(this).toggleClass('active-header').toggleClass('inactive-header');
			$(this).next().slideToggle().toggleClass('open-content');
		}
	});

	}
	$('#superadmin-end #end-button').on('click', function(e) {
		e.preventDefault();
		swal({
			title: "Are you sure to end this school year?",
			text: "Once you click OK, the school year will end already!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		}).then((willAccept) => {
			if (willAccept) {
				$('#superadmin-end').submit();
			} else {
				swal("Click Ok to cancel.");
			}
		});
	});
	
	$('#enrollPrivilege').on('click', 'input', function() {
 		if ($(this).val() == 'Yes') {
 			$(this).val('No');
 			$(this).removeClass('yes');
 			$(this).addClass('no');
 		} else if ($(this).val() == 'No') {
 			$(this).val('Yes');
 			$(this).removeClass('no');
 			$(this).addClass('Yes');
 		}
 	});
 	/* FACULTY SYSTEM SETTINGS*/
	$( ".systemTable-fact" ).DataTable({
	//"scrollX": true,            
		"initComplete": function (settings, json) {  
			$(".systemTable-fact").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
		},
		stateSave: true,
		"lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
		"order": [[ 1, "asc" ]]
	});

	var systemsettingstable_2 = $( "#systemTable-fact-2" ).DataTable({
	//"scrollX": true,            
		"initComplete": function (settings, json) {  
			$("#systemTable-fact-2").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
		},
		stateSave: true,
		"lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
		"order": [[ 0, "asc" ]]
	});

	$('#systemsettings-enroll-assign').one('submit', function(e) {
		e.preventDefault();
		systemsettingstable_2.destroy();
		$(this).submit();
	});
	/* FACULTY SYSTEM SETTINGS*/
	
	function showPreview(objFileInput) {
			hideUploadOption();
			if (objFileInput.files[0]) {
				var fileReader = new FileReader();
				fileReader.onload = function (e) {
					$("#targetLayer").html('<img src="'+e.target.result+'" width="200px" height="200px" class="upload-preview" />');
					$("#targetLayer").css('opacity','0.7');
					$(".icon-choose-image").css('opacity','0.5');
				}
				fileReader.readAsDataURL(objFileInput.files[0]);
			}
		}
		function showUploadOption(){
			$("#profile-upload-option").css('display','block');
		}

		function hideUploadOption(){
			$("#profile-upload-option").css('display','none');
		}

		function removeProfilePhoto(){
			hideUploadOption();
			$("#userImage").val('');
			$.ajax({
				url: "remove.php",
				type: "POST",
				data:  new FormData(this),
				beforeSend: function(){$("#body-overlay").show();},
				contentType: false,
				processData:false,
				success: function(data)
				{				
				$("#targetLayer").html('');
				setInterval(function() {$("#body-overlay").hide(); },500);
				},
				error: function() 
				{
				} 	        
			});
		}
		$(document).ready(function (e) {
			$("#uploadForm").on('submit',(function(e) {
				e.preventDefault();
				$.ajax({
					url: "upload.php",
					type: "POST",
					data:  new FormData(this),
					beforeSend: function(){$("#body-overlay").show();},
					contentType: false,
					processData:false,
					success: function(data)
					{
					$("#targetLayer").css('opacity','1');
					setInterval(function() {$("#body-overlay").hide(); },500);
					},
					error: function() 
					{
					} 	        
			   });
			}));
		});
	
	/*include this(superadmin)*/
	$( ".datepickerWithTime" ).datepicker({
 		changeMonth: true,
 		dateFormat: 'yy-mm-dd hh:mm:ss',
 		changeYear: true,
 		yearRange: "+0:+100"
 	});
}