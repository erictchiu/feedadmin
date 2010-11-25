<?php
$DEUBG = 1;
if ($DEBUG) {
  error_reporting(E_ALL);
  ini_set('display_errors','On');
}

require_once("../fof-config.php");
echo '<h1>Location List</h1>';

$conn = mysql_connect($FOF_DB_HOST, $FOF_DB_USER, $FOF_DB_PASS);
if(!$conn)
{
   die("DB connection failed: " . mysql_error());
}
else {
     //echo "Connected to database.<br>";
     mysql_select_db("location");

     $query = "SELECT city_zip,city_name,city_state,city_latitude,city_longitude,city_county FROM cities";
     $result = mysql_query($query, $conn);


     while(list($zip,$city,$state,$lat,$lon,$county) = mysql_fetch_row($result)) {
           $path = "$state/$city";
           mkdir($path);
           echo "<a href=\"$path\">$city</a> - $state - $zip - $lat - $lon<br>";
           $handle = fopen("$path/index.html", "a");
           fwrite($handle, "$zip - $city - $state - $lat - $lon<br>");
           fclose($handle);
     }
     mysql_close($conn);
}


include('./foot.php');
echo "</html>";
?>