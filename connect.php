<?php
$servername = "localhost";
$username = "userdb";
$password = "databaza";
$dbname = "northwindmysql";

// Vytvorenie pripojenia
$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrola pripojenia
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

// Príklad dotazu
$sql = "SELECT * FROM customers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Výstup dát pre každý riadok
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: " . $row["name"]. "<br>";
    }
} else {
    echo "0 results";
}

// Zatvorenie pripojenia
$conn->close();
?>
