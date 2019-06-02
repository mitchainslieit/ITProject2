/** 
 * SITE FUNCTIONALITIES
 *
 * IT CONTAINS THE USAGE OF API'S AND 
 */

 replacePageTitle();
 /****************************************** START OF FRONT-END FUNCTIONALITIES USING JQUERY (CALLED WITHOUT WAITING FOR THE PAGE TO FULLY LOAD) ******************************************/
 function replacePageTitle() {
 	$('title').empty();
 	$('title').append($( '.menu nav ul li.active-menu a' ).text());
 }

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

 $( ".datepicker" ).datepicker({
 	changeMonth: true,
 	changeYear: true,
 	yearRange: "-25:+0",
 	dateFormat: 'yy-mm-dd',
 	maxDate: new Date
 });

 $( ".datepicker-attendance" ).datepicker({
 	changeMonth: true,
 	dateFormat: 'yy-mm-dd',
 	maxDate: new Date, 
 	minDate: "-2m",
 	beforeShowDay: $.datepicker.noWeekends
 }).datepicker("setDate", new Date());

 $('[name=opener]').each(function () {
 	var panel = $(this).siblings('[name=dialog]');
 	$(this).click(function () {
 		$(".datepicker-attendance").datepicker("disable");
 		panel.dialog('open');
 		$(".datepicker-attendance").datepicker("enable");
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

 /*******Parent-Account*******/
 if ($('body').is('[class*="parent-"]')) {
 	var parent_table1 = $('#customParentTable').DataTable({
 		"columnDefs": [{
 			"targets": [2,3],
 			"visible": false
 		}]
 	});

 	var parent_table2 = $('#table-attendance').DataTable({
 		"columnDefs": [{
 			"targets": [3],
 			"visible": false
 		}],
 		"language": {
 			"emptyTable": "THERE ARE NO ABSENCES YET."
 		}
 	});

 	var par_select_child = $('.parent-account-page .contentpage .widget .contleft .innercont1 .eventcontent .tl select#select-children').val();
 	parent_table1.column(2).search(par_select_child ? par_select_child : '', true, false).draw();

 	$('.parent-account-page .customContent span.wlrno').each(function() {
 		if ($(this).data('lrno') != par_select_child) {
 			$(this).hide();
 		}
 	});

 	$('.parent-account-page .contentpage .widget .contleft .innercont1 .eventcontent .tl select#select-children').on('change', function () {
 		var data = new Array($(this).val(), $(this).siblings('select').val());
 		$('.parent-account-page .customContent span.wlrno').each(function() {
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
 	var par_select_att = $('.parent-attendance-page #select-attendance').val();
 	parent_table2.column(3).search(par_select_att ? par_select_att : '', true, false).draw();

 	$('.parent-attendance-page .eventcontent span.wlrno').each(function() {
 		if ($(this).data('lrno') != par_select_att) {
 			$(this).hide();
 		}
 	});

 	$('.parent-attendance-page #select-attendance').on('change', function () {
 		var data = new Array($(this).val(), $(this).siblings('select').val());
 		$('.parent-attendance-page .eventcontent span.wlrno').each(function() {
 			$(this).show();
 			if ($(this).data('lrno') != $('.parent-attendance-page #select-attendance').val()) {
 				$(this).hide();
 			}
 		});
 		parent_table2.column(3).search('^'+data+'$' ? data : '', true, false).column(3).search(data [0]).draw();
 	})

 	$('.parent-attendance-page #select-attendance').on('change', function () {
 		var data = $(this).val();
 		parent_table2.column(3).search(data ? data : '', true, false).draw();
 	});

 	$('.parent-grades-page #select-child-grade').on('change', function() {
 		var data = 'lrno=' + $(this).val();

 		$.ajax({
 			type: 'POST',
 			url: 'app/model/unstructured/parent-changeSession.php',
 			data: data,
 			success: function(result) {
 				$('#table-grade-student').load('parent-grades  #grade-student');
 			}
 		});
 	});

 	$('.parent-schedule-page #select-child-schedule').on('change', function() {
 		var data = 'lrno=' + $(this).val();

 		$.ajax({
 			type: 'POST',
 			url: 'app/model/unstructured/parent-changeSession.php',
 			data: data,
 			success: function(result) {
 				$('#table-children-schedule').load('parent-schedule #table-children-schedule table');
 			}
 		});
 	});

 	$('.parent-coreValues-page #select-core-value').on('change', function() {
 		var data = 'lrno=' + $(this).val();

 		$.ajax({
 			type: 'POST',
 			url: 'app/model/unstructured/changeSession.php',
 			data: data,
 			success: function(result) {
 				$('#table-core-value').load('parent-coreValues #coreValue-student');
 			}
 		});
 	});
 }

 if ($('body').is('[class*="faculty-"]')) {
 	getCurrentSection('sec1');

 	$('.faculty-editclass-page #getCurrentLevel').on('change', function() {
 		var val = $(this).val();
 		getCurrentSection(val);
 	});

 	function getCurrentSection(value) {
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
 		var data = new Array('att-changedate', $(this).val(), $(this).data('section'));

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


 	$('#faculty_home .contentpage .widget .studentContent #adv-table-1 tr td').on('click', 'button.transfer', function() {
 		var data = new Array('transfer', $(this).siblings('.stud_id').val());

 		$.ajax({
 			context: this,
 			type: 'POST',
 			url: 'app/model/faculty-exts/faculty-ajax.php',
 			data: {data:data},
 			success: function(result) {
 				$(this).append(result);
 			}
 		});
 	});

 	$('#faculty_home .contentpage .widget .studentContent .details').on('click', 'button.cancel', function() {
 		var data = new Array('cancel', $(this).siblings('.stud_id').val());

 		$.ajax({
 			context: this,
 			type: 'POST',
 			url: 'app/model/faculty-exts/faculty-ajax.php',
 			data: {data:data},
 			success: function(result) {
 				$(this).append(result);
 			}
 		});
 	});

 	$('#faculty_home .contentpage .widget .studentContent .details').on('click', 'button.accept', function() {
 		var data = new Array('accept', $(this).siblings('.stud_id').val());

 		$.ajax({
 			context: this,
 			type: 'POST',
 			url: 'app/model/faculty-exts/faculty-ajax.php',
 			data: {data:data},
 			success: function(result) {
 				$(this).append(result);
 			}
 		});
 	});

 	$('#faculty_home .contentpage .widget .studentContent .details').on('click', 'button.reject', function() {
 		var data = new Array('reject', $(this).siblings('.stud_id').val());

 		$.ajax({
 			context: this,
 			type: 'POST',
 			url: 'app/model/faculty-exts/faculty-ajax.php',
 			data: {data:data},
 			success: function(result) {
 				$(this).append(result);
 			}
 		});
 	});
 }



 /****************************************** END OF FRONT-END FUNCTIONALITIES USING JQUERY (CALLED WITHOUT WAITING FOR THE PAGE TO FULLY LOAD) ******************************************/

 /****************************************** START OF FRONT-END FUNCTIONALITIES USING JQUERY ******************************************/
 $( document ).ready(function() {
 	$( ".se-pre-con" ).fadeOut("slow");

 	/****************************************** START OF API(s) ******************************************/
 	/*Jquery UI Tabs*/
 	$( ".enrollcontent .tabs" ).tabs({ active: 1 });
 	$( ".tabs, .studentContent .tabs, .classesContent .tabs, #grades-cv" ).tabs();

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
 		if (val == 'Yes') {
 			studlist.column(2).search( '' ).draw();
 		} else {
 			studlist.column(2).search( 'Not Enrolled' ).draw();
 		}
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

 	});

 	var faculty_calendar = $('#calendar-faculty').fullCalendar({
 		header:{
 			left:'prev,next today',
 			center:'title',
 			right:'month,agendaWeek,agendaDay'
 		},
 		events: 'app/model/unstructured/load.php',
 		selectHelper:true,
 		height: 300
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

 	/****************************************** END OF API(s) ******************************************/

 	$('.faculty-assess-page').on('click', '#print-this', function() {
 		$('.faculty-assess-page .print-container').printThis({
 			importCSS: true,
 			importStyle: true,
 		});
 	});

 });

 var forTransferTable = $('#adv-table-2').DataTable();
 setInterval(function() {
 	var data = new Array('getNotif', parseInt($('body[class*="faculty-"] .menu-sidebar .menu nav ul li#advisory span.notification').text()));
 	if ($('body[class*="faculty-"] .menu-sidebar .menu nav ul li#advisory span.notification').length) {
 		$.ajax({
 			type: 'get',
 			url: 'app/model/faculty-exts/faculty-ajax.php',
 			data: {data:data},
 			success: function(result) {
 				try {
 					var data = JSON.parse(result);
 					var current_no = parseInt($('body[class*="faculty-"] .menu-sidebar .menu nav ul li#advisory span.notification').text());
 					var new_no = data["response"];
 					if ((current_no != new_no) && $('body').is('[class*="faculty-"]')) {
 						var new_data = data["addthis"];
 						$('body[class*="faculty-"] .menu-sidebar .menu nav ul li#advisory span.notification, #faculty_home .contentpage .widget .studentContent .notification').empty();
 						$('body[class*="faculty-"] .menu-sidebar .menu nav ul li#advisory span.notification, #faculty_home .contentpage .widget .studentContent .notification').append(new_no);
 						forTransferTable.clear().draw();
 						for (i = 0; i < new_data.length; i++) {
 							forTransferTable.row.add($(new_data[i])).draw();
 						}
 						$.ambiance({
 							message: "There is a change in your advisory class!",
 							title: "Success!",
 							type: "success"
 						});

 					}
 				} catch (e) {

 				}
 			}
 		});
 	}
 }, 2000);


 $('#faculty_home .contentpage .widget .widgetcontent #classes-sched td .sched-info button span.edit').tooltipster({
 	theme: 'tooltipster-borderless'
 });

 $('#faculty_home .contentpage .widget .widgetcontent #classes-sched td .sched-info button span.remove').tooltipster({
 	theme: 'tooltipster-borderless'
 });
 /****************************************** END OF FRONT-END FUNCTIONALITIES USING JQUERY ******************************************/

/****************************************** ADMIN FUNCTIONALITY ****************************************************/
var adminTable8 = $('#admin-table-request').DataTable({
	"initComplete": function (settings, json) {  
		$("#admin-table-request").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
	}
});

setInterval(function() {
	var data = new Array('getNotif', parseInt($('body[class*="admin-"] .menu-sidebar .menu nav ul li span.notification').text()));
	if ($('body[class*="admin-"] .menu-sidebar .menu nav ul li span.notification').length) {
		$.ajax({
			type: 'get',
			url: 'app/model/admin-exts/admin-ajax.php',
			data: {data:data},
			success: function(result) {
				try {
					var data = JSON.parse(result);
					var current_no = parseInt($('body[class*="admin-"] .menu-sidebar .menu nav ul li span.notification').text());
					var new_no = data["response"];
					if ((current_no != new_no) && $('body').is('[class*="admin-"]')) {
						var new_data = data["addthis"];
						$('body[class*="admin-"] .menu-sidebar .menu nav ul li span.notification').empty();
						$('body[class*="admin-"] .menu-sidebar .menu nav ul li span.notification').append(new_no);
						adminTable8.clear().draw();
						for (i = 0; i < new_data.length; i++) {
							adminTable8.row.add($(new_data[i])).draw();
						}
					}
				} catch (e) {
					
				}
			}
		});
	}
}, 2000);

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
	$('input:checkbox').not(this).prop('checked', this.checked);
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


$( "#stud-list, .admin-table, .admin-table-withScroll" ).DataTable({
	//"scrollX": true,            
	"initComplete": function (settings, json) {  
		$("#stud-list, .admin-table, .admin-table-withScroll").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
	},
	stateSave: true,
	"lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
	
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
		var title = event.title;
		var id = event.id;
		$.ajax({
			url:"app/model/unstructured/updateEvent.php",
			type:"POST",
			data:{title:title, start:start, end:end, id:id},
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

var adminTable3 = $('#admin-table-enrolled').DataTable({
	"scrollX": true,
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
	"scrollX": true,
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
	],
	 
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
	"order": [[ 3, "desc" ]]
});
$( '#admin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.log_events', function() {
	var val5 = $(this).val();
	adminTable5.column(2).search(val5 ? val5 : '', true, false).draw();
});


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
	adminTable7.column(5).search(val7 ? "^" + val7 + "$"  : '', true, false).draw();
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
		'<select name="subj_dept[]" data-validation="required" required><option selected disabled hidden>Select Department</option><option value="Filipino">Filipino</option><option value="Math">Math</option><option value="MAPEH">MAPEH</option><option value="Science">Science</option><option value="AP">AP</option><option value="Math">Math</option><option value="English">English</option><option value="TLE">TLE</option><option value="Math">Math</option></select>',
		'<input type="text" name="subj_name[]" data-validation="length custom" data-validation-length="max45" data-validation-regexp="^[a-zA-Z0-9\-& ]+$" data-validation-error-msg="Enter less than 45 characters and Alphaneumerics only" value="" data-validation="required" required placeholder="Subject Name" class="subject-name">'
		] ).draw( false );
	
	counter++;
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

$( '#super_unique' ).on('change', function() {
	var val = $(this).val();
	adminTableCurriculum.column(3).search(val ? val : '', true, false).draw();
});

$( '.sidebar-menu li' ).has('li.active-menu').addClass('active');
/****************************************** END ADMIN FUNCTIONALITY *************************************************/
 
 /****************************************** SUPERADMIN FUNCTIONALITY ****************************************************/

var sanotif_1 = $('.superadmin-request-table').DataTable();
if ($('body[class*="superadmin-"] .menu-sidebar .menu nav ul li span.notification_sa_1').length) {
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

 $( ".datepicker-schoolyear" ).datepicker({
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

 $superadmin_feeType_request = $('#superadmin_feeType_request').DataTable({
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
 
 $superadminTableSection = $('#superadmin-table-section').DataTable({
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

var secCurrentSuperAdmin = $('.superadmin-classes-page #getCurrentLevel').val();
getCurrentSection1SuperAdmin(secCurrentSuperAdmin);

$('.superadmin-classes-page #getCurrentLevel').on('change', function() {
	var val = $(this).val();
	getCurrentSection1SuperAdmin(val);
});

function getCurrentSection1SuperAdmin(value) {
	var showThis = '.superadmin-classes-page .table-scroll #'+value;
	var hideThis = '.superadmin-classes-page .table-scroll .classes-edit:not(#'+value+')';
	$(hideThis).each(function() {
		$(this).hide();
	});
	$(showThis).show();
}

var superadminTablePayhist = $('#superadmin-table-payhist').DataTable({
	"initComplete": function (settings, json) {  
		$("#superadmin-table-payhist").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
	},
	"scrollX": true,
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

$( '#admin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.year_level_enrolled', function() {
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
	"order": [[ 3, "desc" ]]
});
$( '#admin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.log_events', function() {
	var val5 = $(this).val();
	superadminTableLogs.column(2).search(val5 ? val5 : '', true, false).draw();
});

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

 $( '.sidebar-menu li' ).has('li.active-menu').addClass('active');

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

 /****************************************** END SUPERADMIN FUNCTIONALITY *************************************************/

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


 var data_table = $(".treasurer-table-4" ).DataTable({
 	dom: "lBfrtip",
 	"lengthMenu": [[5, 10, 25, -1], [5, 10, 25, 'All']],
 	buttons: [
 	'pdf', 'print'
 	],
 	"searching" : false
 });

 var data_table1 = $("#treasurer-table-1" ).DataTable({
 	dom: "lBfrtip",
 	"lengthMenu": [[5, 10, 25, -1], [5, 10, 25, 'All']],
 	buttons: [
 	'pdf', 'print'
 	]
 });

 var tres_table_2 = $('#treasurer-table-2').DataTable({
 	dom: 'Bfrtip',
 	"columnDefs": [{
 		"targets": [6],
 		"visible": false,
 	}],
 	buttons: [
 	'pdf', 'print'
 	]
 });

 $( '#treasurer_home .contentpage .widget .eventcontent .cont1 select' ).on('change', function() {
 	var val = $(this).val();
 	tres_table_2.column(6).search(val ? val : '', true, false).draw();
 });



 $('.treasurer-statistics-page').on('change', '#select-year-level', function() {
 	var data = 'yr_lvl=' + $(this).val();

 	$.ajax({
 		type: 'POST',
 		url: 'app/model/unstructured/filter-year-level.php',
 		data: data,
 		success: function(result) {
 			window.location.reload();
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

 $( ".datepicker-schoolyear" ).datepicker({
 	changeMonth: true,
 	dateFormat: 'yyyy',
 	maxDate: new Date, 
 	minDate: "-2m",
 	beforeShowDay: $.datepicker.noWeekends
 }).datepicker("setDate", new Date());

//superadmin

