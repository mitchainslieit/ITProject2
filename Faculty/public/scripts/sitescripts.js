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
	$( ".enrollcontent .tabs" ).tabs({ active: 1 });
	$( ".studentContent .tabs, .classesContent .tabs" ).tabs();

	/*Jquery UI Date Picker*/
	$( "#datepicker" ).datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "-100:+0",
		dateFormat: 'yy-mm-dd'
	});

	/*Datatable API*/
	var datatable = $( "#stud-list, #adv-table-1, #adv-table-2, #old-student" ).DataTable({
		dom: "lfrtip",
		"lengthMenu": [[-1, 5, 10, 25], ["All", 5, 10, 25]],
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

	/*Custom Modal*/
	$( 'button[toggle=modal]' ).click(function() {
		var toOpen = '#' + $(this).attr('target');
		$(modsibID).addClass('modal-enabled');
		$(toOpen).fadeIn();
	});

	$( 'div[data-type=modal] .exit-modal' ).click(function() {
		$(modsibID).removeClass('modal-enabled');
		$( 'div[data-type=modal]' ).fadeOut();
	});

	$( 'div[data-type=modal]' ).click(function(e) {
		e.stopPropagation();
		var container = $(this);
		if (container.has(e.target).length === 0) {
			$(modsibID).removeClass('modal-enabled');
			$(this).fadeOut();
		}
	});

	$( 'div[data-type=modal]').prependTo($('body'));
	var modsibID = '#' + $('div[id*="_home"]').attr('id');
	$( '#faculty_home .contentpage .widget .enrollcontent .cont3 .table-scroll .table-wrap tbody select' ).change(function() {
		var enroll = $(this).val();
		var data = 'enroll='+enroll;
		$.ajax({
			type: 'POST',
			url: 'app/model/unstructured/get-old-stud.php',
			data: data,
			success: function(result) {
				$(modsibID).addClass('modal-enabled');
				$("#status-update").fadeIn();
			}
		});
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

	$('#faculty_home .contentpage .widget .widgetcontent td button.assessment-button').click(function() {;
		localStorage.setItem('lrn', $(this).data('lrn'));
		window.location = 'faculty-assess';
	});
	/****************************************** END OF FRONT-END FUNCTIONALITIES USING JQUERY ******************************************/
});

/*Add page title using the active-menu*/
function replacePageTitle() {
	$('title').empty();
	$('title').append($( '.menu nav ul li.active-menu' ).text());
}