    <?php 

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "nexus_db";

$servername = "localhost";
$username = "u866427573_nexus";
$password = "@Qetu1357";
$dbname = "u866427573_nexus";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>