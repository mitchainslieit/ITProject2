/** 
 * SITE FUNCTIONALITIES
 *
 * IT CONTAINS THE USAGE OF API'S AND 
 *
 *  @version 2.3.26
 *  @website http://formvalidator.net/
 *  @author Victor Jonsson, http://victorjonsson.se
 *  @license MIT
 */

replacePageTitle();
$( document ).ready(function() {
	$( ".se-pre-con" ).fadeOut("slow");
	/****************************************** START OF API(s) ******************************************/
	/*Jquery UI Tabs*/
	$( ".tabs" ).tabs();
	$( ".enrollcontent .tabs" ).tabs({ active: 1 });
	$( ".studentContent .tabs, .classesContent .tabs" ).tabs();
	$( ".contentpage .tabs" ).tabs();

	/*Datatable API*/
	var datatable = $( "#stud-list, #adv-table-1, #adv-table-2, #old-student" ).DataTable({
		dom: "lfrtip",
		"lengthMenu": [[5, 10, 25], [5, 10, 25]]
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
		height: 500
	});

	/*jQuery Form Validator API*/


	/****************************************** END OF API(s) ******************************************/

	/****************************************** START OF FRONT-END FUNCTIONALITIES USING JQUERY ******************************************/
	/*Dropdown menu, specifically for the profile dropdown*/
	$( ".dropdown-menu .dropdown-btn" ).click(function(e) {
		e.stopPropagation();
		$(".dropdown-menu-content").fadeToggle();
	});

	$( "html" ).click(function(e) {
		e.stopPropagation();
		var container = $(".dropdown-menu-content");

		//check if the clicked area is dropDown or not
		if (container.has(e.target).length === 0) {
			$('.dropdown-menu-content').fadeOut();
		}
	});

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
		ifColAct === null ? localStorage.setItem('collapse-menu', 'active') : localStorage.removeItem('collapse-menu');
	});

	if (ifColAct === 'active') {
		$('div.menu-top').addClass('top-compress');
		$('div.menu-sidebar').addClass('sidebar-compress');
		$('div.content-container').addClass('content-compress');
	}

	$('.menu nav > ul > li').each(function() {
		var newDiv = '<span class="menu-title">' + $(this).children('a').text() + '</span>';
		$(this).children('a').append(newDiv);
	});

	$('.sidebar-submenu li').each(function() {
		var newDiv = '<span class="menu-title">' + $(this).children('a').text() + '</span>';
		$(this).children('a').append(newDiv);
	});

	$( '#faculty_home .contentpage .widget .studentContent .cont' ).on('change', '.filtStudTable', (function() {
		var grade = $(this).val();
		var data = 'grade='+grade;
		
		$.ajax({
			type: 'POST',
			url: 'app/model/faculty-exts/get-stud-list.php',
			data: data,
			success: function(result) {
				datatable.clear().draw();
				datatable.rows.add($.parseJSON(result)); 
				datatable.columns.adjust().draw();
			},
		});
	}));

/*	$( '#parent_home .contentpage .row .account .container .innercont1 .eventcontent' ).on('change', '.student', (function() {
		var grade = $(this).val();
		var data = 'grade='+grade;
		
		$.ajax({
			type: 'POST',
			url: 'app/model/unstructured/parent_func1.php',
			data: data,
			success: function(result) {
				console.log(data);
			},
		});
	}));*/

	$('.parent-account-page #select-children').on('change', function() {
		var data = 'lrno=' + $(this).val();

		$.ajax({
			type: 'POST',
			url: 'app/model/unstructured/parent-changeSession.php',
			data: data,
			success: function(result) {
				$('#children-totals').load('parent-account #children-totals .container');
			}
		});
	});

	$('.parent-attendance-page #select-children').on('change', function() {
		var data = 'lrno=' + $(this).val();

		$.ajax({
			type: 'POST',
			url: 'app/model/unstructured/parent-changeSession.php',
			data: data,
			success: function(result) {
				$('.parent-attendance-page #attendance-container').load('parent-attendance #attendance-container-load');
			}
		});
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

	$('.faculty-assess-page').on('click', '#print-this', function() {
		$('.faculty-assess-page .print-container').printThis({
			importCSS: true,
			importStyle: true,
		});
	});
	/****************************************** END OF FRONT-END FUNCTIONALITIES USING JQUERY ******************************************/
});


/****************************************** START OF FRONT-END FUNCTIONALITIES USING JQUERY (CALLED WITHOUT WAITING FOR THE PAGE TO FULLY LOAD) ******************************************/
/*Jquery UI Date Picker*/
$( ".datepicker" ).datepicker({
	changeMonth: true,
	changeYear: true,
	yearRange: "-25:+0",
	dateFormat: 'yy-mm-dd'
});

$('[name=opener]').each(function () {
  var panel = $(this).siblings('[name=dialog]');
  $(this).click(function () {
      panel.dialog('open');
      $('.ui-widget-overlay').addClass('custom-overlay');
  });
});
$('[name=dialog]').dialog({
  autoOpen: false,
  modal: true,
  draggable: false,
  height: 'auto',
  width: 'auto'
});

/*Add page title using the active-menu*/
function replacePageTitle() {
	$('title').empty();
	$('title').append($( '.menu nav ul li.active-menu' ).text());
}
/****************************************** END OF FRONT-END FUNCTIONALITIES USING JQUERY (CALLED WITHOUT WAITING FOR THE PAGE TO FULLY LOAD) ******************************************/