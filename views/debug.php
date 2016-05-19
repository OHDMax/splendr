<?php

if (Session::get('UserID') !== FALSE) {
    $auth = "TRUE";
}

echo "Authenticated: " . $auth . "<br>";
echo "Session Data: ";
var_dump(session::display());
echo "<br>";
//echo "Cookies: ";
//var_dump($_COOKIE);
//echo "<br>";
echo var_dump($data);
