replacePageTitle();
$( document ).ready(function() {
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
    var datatable = $( "#stud-list, #adv-table-1, #adv-table-2, #treasurer-table-1" ).DataTable({
        dom: "lfrtrip",
        "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
    });

    var calendar = $('#calendar').fullCalendar({
        editable: true,
        events: "fetch-event.php",
        displayEventTime: false,
        eventRender: function (event, element, view) {
            if (event.allDay === 'true') {
                event.allDay = true;
            } else {
                event.allDay = false;
            }
        },
        selectable: true,
        selectHelper: true,
        select: function (start, end, allDay) {
            var title = prompt('Event Title:');

            if (title) {
                var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");

                $.ajax({
                    url: 'add-event.php',
                    data: 'title=' + title + '&start=' + start + '&end=' + end,
                    type: "POST",
                    success: function (data) {
                        displayMessage("Added Successfully");
                    }
                });
                calendar.fullCalendar('renderEvent',
                        {
                            title: title,
                            start: start,
                            end: end,
                            allDay: allDay
                        },
                true
                        );
            }
            calendar.fullCalendar('unselect');
        },
        
        editable: true,
        eventDrop: function (event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                    $.ajax({
                        url: 'edit-event.php',
                        data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
                        type: "POST",
                        success: function (response) {
                            displayMessage("Updated Successfully");
                        }
                    });
                },
        eventClick: function (event) {
            var deleteMsg = confirm("Do you really want to delete?");
            if (deleteMsg) {
                $.ajax({
                    type: "POST",
                    url: "delete-event.php",
                    data: "&id=" + event.id,
                    success: function (response) {
                        if(parseInt(response) > 0) {
                            $('#calendar').fullCalendar('removeEvents', event.id);
                            displayMessage("Deleted Successfully");
                        }
                    }
                });
            }
        }

    });

    var tres_table_2 = $('#treasurer-table-2').DataTable({
        "columnDefs": [{
            "targets": [6],
            "visible": false,

        }]
    });

    $( '#treasurer_home .contentpage .widget .eventcontent .cont1 select' ).on('change', function() {
        var val = $(this).val();
        tres_table_2.column(6).search(val ? val : '', true, false).draw();
    });


    $.validate();

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

$('[name=opener]').each(function () {
  var panel = $(this).siblings('[name=dialog]');
  $(this).click(function () {
      panel.dialog('open');
      $('.ui-widget-overlay').addClass('custom-overlay');
      document.getElementById("update-form").value = '';
  });
});

$('[name=dialog]').dialog({
  autoOpen: false,
  modal: true,
  preventDefault: true,
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