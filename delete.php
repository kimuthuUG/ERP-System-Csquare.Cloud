<?php
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "erpsystem_db";

    // Create database connection
    $connection = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $sql = "DELETE FROM customer WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt->close();
    $connection->close();
}

header("location:/erpsystem/ERP-System-Csquare.Cloud/index.php");
exit;
?>
