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
	var datatable = $( "#stud-list, #adv-table-1, #adv-table-2, #admin-table" ).DataTable({
		dom: "lBfrtip",
		buttons: [
        	'excel','pdf','print'
    	],
		"lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
	});

	var adminTable = $('#admin-table').DataTable();

	var calendar = $('#calendar').fullCalendar({
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

	/* script for filter in reports: payment status */
	$( '#admin_home .contentpage .widget .widgetContent .cont1' ).on('click', '.customButton', function(e) {
		var data = new Array($(this).siblings('select:first-of-type').val(), $(this).siblings('select:last-of-type').val());

		$.ajax({
			type: 'POST',
			url: 'app/model/admin-stud-table.php',
			data: {data:data},
			success: function(result) {
				adminTable.clear().draw();
				adminTable.rows.add($.parseJSON(result)); 
				adminTable.columns.adjust().draw();
			}
		});
	});

	var adminTable2 = $('#admin-table').DataTable();

	$( '#admin_home .contentpage .widget .widgetContent .cont1 .year_level' ).change(function() {
		var grade = $(this).val();
		var data = 'grade='+grade;
		
		$.ajax({
			type: 'POST',
			url: 'app/model/admin-stud-table2.php',
			data: data,
			success: function(result) {
				adminTable2.clear().draw();
				adminTable2.rows.add($.parseJSON(result)); 
				adminTable2.columns.adjust().draw();
			}
		});
	});
	/* end of script for filter in reports: payment status */


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
	
	$( '.sidebar-menu li' ).has('li.active-menu').addClass('active');
});

function replacePageTitle() {
	$('title').empty();
	$('title').append($( '.leftmenu nav ul li.active-menu' ).text());
}