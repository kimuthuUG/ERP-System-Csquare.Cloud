<!DOCTYPE html>
<html>
<head>
    <title>Item Report</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <h1>Item Report</h1>
    <table border="1">
        <tr>
            <th>Item Name</th>
            <th>Item Category</th>
            <th>Item Subcategory</th>
            <th>Item Quantity</th>
        </tr>
        <?php
        // Assuming you have already established the database connection
        $conn = mysqli_connect('localhost', 'root', '', 'erpsystem_db');
        
        // Check connection
        if (mysqli_connect_errno()) {
            die("Database connection failed: " . mysqli_connect_error());
        }
        
        // Fetch data from the tables
        $query = "SELECT item_name, category, sub_category, quantity FROM item
                  INNER JOIN item_category ON item.item_category = item_category.id
                  INNER JOIN item_subcategory ON item.item_subcategory = item_subcategory.id";
        $result = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$row['item_name']."</td>";
                echo "<td>".$row['category']."</td>";
                echo "<td>".$row['sub_category']."</td>";
                echo "<td>".$row['quantity']."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No items found.</td></tr>";
        }
        
        // Close the database connection
        mysqli_close($conn);
        ?>
    </table>
     <!-- Required scripts for Bootstrap and jQuery -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
