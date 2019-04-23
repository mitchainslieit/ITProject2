replacePageTitle();
$( document ).ready(function() {
	
	$('[name=opener]').each(function () {
		var panel = $(this).siblings('[name=dialog]');
		$(this).click(function () {
			panel.dialog('open');
			$('.ui-widget-overlay').addClass('custom-overlay');
		});
	});

	$('[name=dialog]').dialog({
		autoOpen: false,
		modal: true
	});
	
	$( ".se-pre-con" ).fadeOut("slow");


	$( "#clickme" ).click(function() {
		if ($( ".leftmenu" ).css('display') === 'none') {
			$( ".contentpage" ).css( "margin", "0 0 0 calc(18.229166666666664%)" );
			$( ".leftmenu" ).fadeToggle();
		} else{
			$( ".leftmenu" ).toggle();
			$( ".contentpage" ).css( "margin", "25px 0 25px 50px" );
		}  if ($( ".topbarleft" ).css('display') === 'none') {
			$( ".topbarright" ).css( "width", "81.77083333333334%" );
			$( ".topbarleft" ).fadeToggle();
		} else {
			$( ".topbarleft" ).toggle();
			$( ".topbarright" ).css( "width", "100%" );
		} 
	});

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

	$( ".enrollcontent .tabs" ).tabs({ active: 1 });
	$( ".studentContent .tabs, .classesContent .tabs" ).tabs();

	$( "#datepicker" ).datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "-100:+0"
	});
	
	
	$('#ptaTable').DataTable( {
	
   	});
   	
   	var noFilterTable = $("#noFilterTable").DataTable({
   		"scrollX": true,
		dom: "lBfrtip",
		fixedColumns: {
       		leftColumns: 1
        	},
   		dom: "lBfrtip",
		"paging":   false,
       	"ordering": false,
		buttons: [
        	'excel','pdf','print'
    	],
   	});
	
	$( "#eventDataTable, #announcementDataTable" ).DataTable({
		"paging":   false,
       	"ordering": false,
       	"info": false,
		 buttons: false,
		 "searching":false
	});
	
	var datatable = $( "#stud-list, #adv-table-1, #adv-table-2, #admin-table, #admin-table-withScroll" ).DataTable({
		"scrollX": true,
		dom: "lBfrtip",
		fixedColumns: {
       		leftColumns: 1
        	},
		buttons: [
        	'excel','pdf','print'
    	],
		"lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
		
	});

	var calendar = $('#calendarAdmin').fullCalendar({
		editable:true,
		header:{
			left:'prev,next today',
			center:'title',
			right:'month,agendaWeek,agendaDay'
		},
		events: 'app/model/unstructured/loadEvent.php',
		selectable:true,
		selectHelper:true,/*
		select: function(start, end, allDay)
		{
			var title = prompt("Enter Event Title");
			if(title)
			{
				var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
				var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
				$.ajax({
					url:"insert.php",
					type:"POST",
					data:{title:title, start:start, end:end},
					success:function()
					{
						calendar.fullCalendar('refetchEvents');
						alert("Added Successfully");
					}
				})
			}
		},*/
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
					calendar.fullCalendar('refetchEvents');
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
					calendar.fullCalendar('refetchEvents');
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
						calendar.fullCalendar('refetchEvents');
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
	
	/* script for filter in reports: payment status */

	var adminTable = $('#admin-table-balstatus').DataTable();

	$( '#admin_home .contentpage .widget .widgetContent .cont1' ).on('click', '.customButton', function(e) {
		var val1 = $(this).siblings('select:first-of-type').val();
		var val2 = $(this).siblings('select:last-of-type').val();
		adminTable.column(2).search(val1 ? val1 : '', true, false).column(6).search(val2 ? "^" + val2 + "$" : '', true, false).draw();
	});

	var adminTable3 = $('#admin-table-enrolled').DataTable();
	$( '#admin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.year_level_enrolled', function() {
		var val3 = $(this).val();
		adminTable3.column(2).search(val3 ? val3 : '', true, false).draw();
	});

	var adminTable4 = $('#admin-table-payhist').DataTable();
	$( '#admin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.year_level_payhist', function() {
		var val4 = $(this).val();
		adminTable4.column(2).search(val4 ? val4 : '', true, false).draw();
	});

	var adminTable5 = $('#admin-table-logs').DataTable();
	$( '#admin_home .contentpage .widget .widgetContent .cont1' ).on('change', '.log_events', function() {
		var val5 = $(this).val();
		adminTable5.column(2).search(val5 ? val5 : '', true, false).draw();
	});
	/* end of script for filter in reports: payment status */

	
	$( '.sidebar-menu li' ).has('li.active-menu').addClass('active');
});

function replacePageTitle() {
	$('title').empty();
	$('title').append($( '.leftmenu nav ul li.active-menu' ).text());
}