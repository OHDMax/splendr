<?php

//set timezone
date_default_timezone_set('Europe/Berlin');

//site address
define('DIR','https://studi.f4.htw-berlin.de/~s0544210/Splendr2/');
define('DOCROOT', dirname(__FILE__));

// Credentials for the local server
define('DB_TYPE','mysql');
define('DB_HOST','localhost');
define('DB_NAME','products');
define('DB_USER','abc');
define('DB_PASS','abc');

//set prefix for sessions
define('SESSION_PREFIX','splendr_');

//optionall create a constant for the name of the site
define('SITETITLE','Splendr');
