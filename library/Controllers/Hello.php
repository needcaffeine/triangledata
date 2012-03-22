<?php
// This is the Hello World controller for this application.
$app->get('/hello', function () {
	echo '{"Hello":"World!"}';
});
