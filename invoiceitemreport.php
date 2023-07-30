<!DOCTYPE html>
<html>
<head>
    <title>Invoice Item Report</title>
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
    <h1>Invoice Item Report</h1>
    <form action="" method="post">
        <label for="from_date">From Date:</label>
        <input type="date" id="from_date" name="from_date">
        <label for="to_date">To Date:</label>
        <input type="date" id="to_date" name="to_date">
        <input type="submit" name="submit" value="Generate Report">
    </form>

    <?php
    if (isset($_POST['submit'])) {
        // Connect to the database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "erpsystem_db";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get date range from the form submission
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];

        // Prepare the SQL query to fetch data based on the date range
        $sql = "SELECT invoice.invoice_no, invoice.date, CONCAT(customer.title, ' ', customer.first_name, ' ', customer.last_name) AS customer_name,
                item.item_name, item.item_code, item_category.category AS item_category, item.unit_price
                FROM invoice
                JOIN customer ON invoice.customer = customer.id
                JOIN item ON invoice.item_count = item.id
                JOIN item_category ON item.item_category = item_category.id
                WHERE invoice.date BETWEEN '$from_date' AND '$to_date'";

        $result = $conn->query($sql);
    ?>
    <table>
        <tr>
            <th>Invoice Number</th>
            <th>Invoiced Date</th>
            <th>Customer Name</th>
            <th>Item Name</th>
            <th>Item Code</th>
            <th>Item Category</th>
            <th>Item Unit Price</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row['invoice_no']."</td>";
                echo "<td>".$row['date']."</td>";
                echo "<td>".$row['customer_name']."</td>";
                echo "<td>".$row['item_name']."</td>";
                echo "<td>".$row['item_code']."</td>";
                echo "<td>".$row['item_category']."</td>";
                echo "<td>".$row['unit_price']."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No data found.</td></tr>";
        }
        ?>
    </table>
    <?php
    $conn->close();
    }
    ?>
     <!-- Required scripts for Bootstrap and jQuery -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
