<?php
$host = 'localhost';
$db   = 'tms';           // Your database name
$user = 'root';          // Your MySQL username
$pass = 'password';      // Your MySQL password (blank if none)

//echo "<h3>🔍 Testing DB Connections</h3>";

// ✅ PDO
try {
    $dbh = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
   // echo "✅ PDO connection success!<br>";
} catch (PDOException $e) {
    echo "❌ PDO Error: " . $e->getMessage() . "<br>";
}

// ✅ MySQLi
$conn = mysqli_connect($host, $user, $pass, $db);
if ($conn) {
   // echo "✅ MySQLi connection success!";
} else {
    echo "❌ MySQLi Error: " . mysqli_connect_error();
}
?>
