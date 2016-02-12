<!doctype html><html  lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link rel="stylesheet" href="../../include/fullcalendar/fullcalendar.min.css"/>
        <link rel="stylesheet" href="../../include/fullcalendar/fullcalendar.print.css" media="print"/>
        <link rel="stylesheet" href="../../include/js/dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />
        <script type="text/javascript" src="../../include/js/jquery.min.js"></script>
        <script type="text/javascript" src="../../include/fullcalendar/lib/moment.min.js"></script>
        <script type="text/javascript" src="../../include/fullcalendar/fullcalendar.min.js"></script>
        <script type="text/javascript" src="../../include/js/dhtmlmodal/windowfiles/dhtmlwindow.js"></script>

    </head>
    <body>
        <script type="text/javascript">
            $(document).ready(function() {

                var namespace;
                namespace = {
                    view_event : function(id) {
                       location.href = "../external_user/resource_booking_calendar_detail.php?id="+id;
                    }
                };
                window.ns = namespace;

                var date = new Date();
                var d = date.getDate();
                var m = date.getMonth();
                var y = date.getFullYear();

                var calendar = $('#calendar').fullCalendar({
                    editable: true,
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month'
                    },
                    timezone: 'local',
                    events: {
                        url: 'resource_booking_read.php',
                        error: function() {
                            //$('#script-warning').show();
                        }
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
                        //ns.add_event(start,end);
                    },
                    editable: true,
                    eventClick: function(event) {
                       ns.view_event(event.id);
                    }
                });

            });
        </script>
    <style type="text/css" >
        #calendar {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 10px;
        }
    </style>
    <div id='calendar'></div>
</body>
</html>