<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php echo ('Hello, World!'); ?>
</body>
</html>





//include("php/db_connection.php");
$test = -15;
echo "<br><br>";
echo $test ? "$test = True" : "$test = False";
echo "<br><br>";
echo $database = serialize(parse_ini_file("Protected/config.ini", true));
echo "<br><br>";
echo "Session status: " . session_status();
echo "<br><br>";
//echo $db_query = "SELECT * FROM authme WHERE realname LIKE '" . db_escape_string("local database","DavyNavy's") . "' LIMIT 1";
echo "<br><br>" . "SERVER NAME: " . $_SERVER['SERVER_NAME'];
echo "<br><br>" . "REQUEST URI: " . $_SERVER['REQUEST_URI'];
echo "<br><br>" . "DOCUMENT ROOT: " . $_SERVER['DOCUMENT_ROOT'];
echo "<br><br>";
$testarray = [];
echo ($testarray) ? "True" . (count($testarray)) : "False" . (count($testarray));
echo "<br><br>";
echo (count($testarray)) ? "True" . (count($testarray)) : "False" . (count($testarray));
echo "<br><br>";
$testarray = [];
echo ($testarray) ? "True" . (count($testarray)) : "False" . (count($testarray));
echo "<br><br>";
echo (count($testarray)) ? "True" . (count($testarray)) : "False" . (count($testarray));
echo "<br><br>";
echo "__DIR__: " . __DIR__;
echo "<br><br>";
echo "dirname(__DIR__): " . dirname(__DIR__);
echo "<br><br>";
