<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP-System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">ERP-SYSTEM</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/erpsystem/ERP-System-Csquare.Cloud/index.php">Customers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/erpsystem/ERP-System-Csquare.Cloud/itemindex.php">Items</a>
                    </li>
                    <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Reports
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="/erpsystem/ERP-System-Csquare.Cloud/invoicereport.php">Invoice report</a></li>
            <li><a class="dropdown-item" href="/erpsystem/ERP-System-Csquare.Cloud/invoiceitemreport.php">Invoice item report</a></li>
            <li><a class="dropdown-item" href="/erpsystem/ERP-System-Csquare.Cloud/itemreport.php">Item report</a></li>
          </ul>
        </li>
                </ul>
                
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h2>List of Items</h2>
        <br>
        <br>
        <a class="btn btn-primary" href="/erpsystem/ERP-System-Csquare.Cloud/itemcreate.php" role="button">New Items</a>
        <br>
        <br>
        <br>
        <table class="table">
            <!-- Table content goes here -->
            <thead>
                <th>ID</th>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>Item Category</th>
                <th>Item Subcategory</th>
                <th>Quantity</th>
                <th>Unit Price</th>
            </thead>
            <tbody>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "erpsystem_db";

                // Create connection
                $connection = new mysqli($servername, $username, $password, $database);

                // Check connection
                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                // Read all rows from the database table
                $sql = "SELECT * FROM item";
                $result = $connection->query($sql);

                if (!$result) {
                    die("Invalid Query: " . $connection->error);
                }

                // Read data of each row and display it in the table
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['item_code'] . "</td>";
                    echo "<td>" . $row['item_name'] . "</td>";
                    echo "<td>" . $row['item_category'] . "</td>";
                    echo "<td>" . $row['item_subcategory'] . "</td>";
                    echo "<td>" . $row['quantity'] . "</td>";
                    echo "<td>" . $row['unit_price'] . "</td>";
                    echo "<td>
                            <a class='btn btn-primary btn-sm' href='/erpsystem/ERP-System-Csquare.Cloud/itemedit.php?id=$row[id]' >EDIT</a>

                            <a class='btn btn-primary btn-sm' href='/erpsystem/ERP-System-Csquare.Cloud/itemdelete.php?id=$row[id]'>DELETE</a>
                          </td>";
                    echo "</tr>";
                }

                $connection->close();
                ?>
            </tbody>
        </table>
        <br>
        <br>
       
    </div>


    

    <!-- Required scripts for Bootstrap and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>