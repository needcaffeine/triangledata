<?php
// This is the DEMONSTRATION ONLY controller to search for crime information.
// @TODO - This works only for the City of Raleigh. May want to support other cities.
$app->get('/crime/:type', function ($type) {

	// We need to make a REST request to the Raleigh gov api.
	require 'Pest/PestJSON.php';
	$pest = new PestJSON('http://maps.raleighnc.gov/ArcGIS/rest/services/Crime/CrimePublic/MapServer/');
	$crimes = $pest->get("find?layers=0&f=json&pretty=true&searchText=$type");

	// Print out some basic information.
	foreach ($crimes['results'] as $crime) {
		$result[$crime['attributes']['INCIDENT_DATE']] = $crime['attributes']['PREMISE'];
	}

	echo prettyPrint(json_encode($result));
});

// @TODO - This really should not be inside of a controller.
// Additionally, with PHP 5.4.0, JSON_PRETTY_PRINT will be an option
// for json_encode().
function prettyPrint($string) {
	$pattern = array(',"', '{', '}');
	$replacement = array(",\n\t\"", "{\n\t", "\n}");
	echo str_replace($pattern, $replacement, $string);
}
