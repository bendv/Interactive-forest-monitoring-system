<?php
	/***
	 * Handles request from GPX form.
	 * Returns all points within a kebele and timeframe where forest change occurred.
	 */
	// import db settings
	require('db.php');

	// Get values from GPX Form
	$Woreda = $_POST['Woreda'];
	$Kebele = $_POST['Kebele'];
	$Startdate = $_POST['start-date'];
	$Enddate = $_POST['end-date'];

	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=\"forest_change_in_kebele.gpx\"");

	// Connecting to db using the settings coming from db.php
	$dbconn = pg_connect($db_connection_string) or die('Could not connect: ' . pg_last_error());

	// SQL query
	$query = 'SELECT ST_AsText (ST_Transform(geom, 4326))
		FROM "forestchange_centerpoints"
		WHERE ST_Contains((
			SELECT geom from "Kebeles_utm"
			WHERE "wereda" = $1 AND "kebele_nam" = $2
		), "forestchange_centerpoints".geom)';

	// Execute SQL query
	$result = pg_query_params($query, array($Woreda, $Kebele)) or die('Query failed: ' . pg_last_error());

	// Printing results in GPX
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"no\" ?>\n" .
	"<gpx xmlns=\"http://www.topografix.com/GPX/1/1\" xmlns:gpxx=\"http://www.garmin.com/xmlschemas/GpxExtensions/v3\" xmlns:gpxtpx=\"http://www.garmin.com/xmlschemas/TrackPointExtension/v1\" creator=\"Oregon 400t\" version=\"1.1\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.topografix.com/GPX/1/1 http://www.topografix.com/GPX/1/1/gpx.xsd http://www.garmin.com/xmlschemas/GpxExtensions/v3 http://www.garmin.com/xmlschemas/GpxExtensionsv3.xsd http://www.garmin.com/xmlschemas/TrackPointExtension/v1 http://www.garmin.com/xmlschemas/TrackPointExtensionv1.xsd\">\n" .
	  "<metadata>\n" .
	    "<link href=\"http://www.cbm.wur.nl\">\n" .
	      "<text>Forest change in kebele</text>\n" .
	    "</link>\n" .
	    "<time>", gmdate("Y-m-d\Th:i:s\Z"),"</time>\n" .
	  "</metadata>\n";

	while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
	  foreach ($line as $pnt_value) {
			$lon = explode(" ", explode("(", $pnt_value)[1])[0];
			$lat = explode(")", explode(" ", explode("(", $pnt_value)[1])[1])[0];
			echo "<wpt lat=\"",$lat,"\" lon=\"",$lon,"\"></wpt>\n";
		}
	}
	echo "</gpx>";

	// Free resultset
	pg_free_result($result);

	// Closing connection
	pg_close($dbconn);

?>
