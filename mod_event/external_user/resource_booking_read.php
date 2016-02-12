<?php
header('Content-Type: application/json');
require_once '../../class.adapter.php';
require_once '../../include/helper.php';
require_once '../../session.php';

$session = new session();
$session->start_session('_s', false);

// Require our Event class and datetime utilities
require dirname(__FILE__) . '/utils.php';

// Short-circuit if the client did not give us a date range.
if (!isset($_GET['start']) || !isset($_GET['end'])) {
    die("Please provide a date range.");
}

// Parse the start/end parameters.
// These are assumed to be ISO8601 strings with no time nor timezone, like "2013-12-29".
// Since no timezone will be present, they will parsed as UTC.
$range_start = parseDateTime($_GET['start']);
$range_end = parseDateTime($_GET['end']);

// Parse the timezone parameter if it is present.
$timezone = null;
if (isset($_GET['timezone'])) {
    $timezone = new DateTimeZone($_GET['timezone']);
}

// Read and parse our events JSON file into an array of event data arrays.
//$json = file_get_contents(dirname(__FILE__) . '/events.json');
//$input_arrays = json_decode($json, true);

// Accumulate an output array of event data arrays.


//print_r($input_arrays);
$db = MySQL::getInstance();
$sql = "SELECT `ebm_seq_no`,`lmd_name`,`ebm_from_date`, `ebm_to_date` FROM `event_booking_main`
        JOIN `location_main_detail` WHERE `ebm_location_id` = `lmd_seq_no`";
$stmt = $db->prepare($sql);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($ec_seq_no,$ec_title,$ec_startdate,$ec_enddate);

$columns = array();
$output_arrays = array();

$i = 0;
while ($stmt->fetch()) {
    $columns[$i]['id'] = $ec_seq_no;
    $columns[$i]['title'] = $ec_title;
    if($ec_allDay === 'true'){
       $createDate = new DateTime($ec_startdate);
       $strip = $createDate->format('Y-m-d');
       $columns[$i]['start']  = $strip;
    }else{
      $columns[$i]['start'] = $ec_startdate;
      $columns[$i]['end'] = $ec_enddate;
    }
    

    $i++;
}
$stmt->close();
$db->close();

//print_r($columns);

/*foreach ($columns as $array) {

	// Convert the input array into a useful Event object
	$event = new Event($array, $timezone);

	// If the event is in-bounds, add it to the output
	if ($event->isWithinDayRange($range_start, $range_end)) {
		$output_arrays[] = $event->toArray();
	}
}*/

// Send JSON to the client.
echo json_encode($columns);