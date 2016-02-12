<!doctype html><html  lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link rel="stylesheet" href="../include/fullcalendar/fullcalendar.min.css"/>
        <link rel="stylesheet" href="../include/fullcalendar/fullcalendar.print.css" media="print"/>
        <script type="text/javascript" src="../include/js/jquery.min.js"></script>
        <script type="text/javascript" src="../include/fullcalendar/lib/moment.min.js"></script>
        <script type="text/javascript" src="../include/fullcalendar/fullcalendar.min.js"></script>
    </head>
    <body>
        <script type="text/javascript">
            $(document).ready(function() {
                var date = new Date();
                var d = date.getDate();
                var m = date.getMonth();
                var y = date.getFullYear();

                var calendar = $('#calendar').fullCalendar({
                    editable: true,
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    scrollTime :  "08:00:00",
                    slotDuration: '00:15:00',
                    timezone: 'local',
                    events: {
                        url: '../mod_event/event_main_grid_read.php',
                        error: function() {
                            //$('#script-warning').show();
                        }
                    },
                    loading: function(bool) {
                        $('#loading').toggle(bool);
                    },
                    // Convert the allDay from string to boolean
                    eventRender: function(event, element, view) {
                        if (event.allDay === 'true') {
                            event.allDay = true;
                        } else {
                            event.allDay = false;
                        }
                    },
                    selectable: true,
                    selectHelper: true,
                    select: function(start, end) {

                        var starttime = moment(start).format('MMMM Do YYYY h:mm a');
                        var endtime = moment(end).format('h:mm a');
                        var allDay = !start.hasTime() && !end.hasTime();

                        //alert(new Date(start).getTime() / 1000);
                        var title = prompt('Event Title:');
                        //var url = prompt('Type Event url, if exits:');
                        if (title) {

                            calendar.fullCalendar('renderEvent', {
                                title: title,
                                start: start,
                                end: end,
                                allDay: allDay
                            }, false // make the event "unstick"
                        );

                            var start = new Date(start).getTime() / 1000;
                            var end = (end == null) ? start : new Date(end).getTime() / 1000;

                            $.ajax({
                                url: '../mod_event/event_main_grid_add.php',
                                data: 'title='+title+'&start='+ start +'&end='+end+'&allDay='+allDay,
                                type: "POST",
                                success: function(json) {
                                    alert(json['status']);
                                    $('#calendar').fullCalendar( 'refetchEvents' );
                                }
                            });
                        }
                        calendar.fullCalendar('unselect');
                    },
                    editable: true,
                    eventLimit: true,
                    eventDrop: function(event, delta) {
                        /*var s = event.start;
                        var e = event.end;
                        var starttime = moment(s).format('MMMM Do YYYY h:mm a');
                        var endtime = moment(e).format('h:mm a');
                        var allDay = !s.hasTime() && !e.hasTime();*/
                        alert(event.start);
                        var allDay = 'false';
                        var start = new Date(event.start).getTime() / 1000;
                        var end = (event.end == null) ? event.start : new Date(event.end).getTime() / 1000;
                        $.ajax({
                            url: '../mod_event/event_main_grid_edit.php',
                            data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id + '&allDay='+ allDay ,
                            type: "POST",
                            success: function(json) {
                                alert(json['status']);
                            }
                        });
                    },
                    eventClick: function(event) {
                        var decision = confirm("Do you really want delete this event ?");
                        if (decision) {
                            $.ajax({
                                type: "POST",
                                url: "../mod_event/event_main_grid_delete.php",
                                data: "&id=" + event.id,
                                success: function(json) {
                                    $('#calendar').fullCalendar('removeEvents', event.id);
                                    alert(json['status']);
                                }
                            });
                        }
                    },
                    eventResize: function(event, delta) {
                        var s = event.start;
                        var e = event.end;
                        var starttime = moment(s).format('MMMM Do YYYY h:mm a');
                        var endtime = moment(e).format('h:mm a');
                        var allDay = !s.hasTime() && !e.hasTime();

                        var start = new Date(event.start).getTime() / 1000;
                        var end = (event.end == null) ? event.start : new Date(event.end).getTime() / 1000;
                        $.ajax({
                            url: '../mod_event/event_main_grid_edit.php',
                            data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id + '&allDay='+allDay ,
                            type: "POST",
                            success: function(json) {
                                alert(json['status']);
                            }
                        });
                    }
                });

            });
        </script>
    <style>
        #calendar {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 10px;
        }
    </style>
    <div id='calendar'></div>
</body>
</html>