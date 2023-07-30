<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "erpsystem_db";

// Create database connection
$connection = new mysqli($servername, $username, $password, $database);

$id = "";
$title = "";
$fname = "";
$lname = "";
$contact = "";
$district = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // GET method: Show the data of the customer
    if (!isset($_GET["id"])) {
        header("location:/erpsystem/ERP-System-Csquare.Cloud/index.php");
        exit;
    }

    $id = $_GET["id"];

    // Read the row of the selected customer from the database table
    $sql = "SELECT * FROM customer WHERE id=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location:/erpsystem/ERP-System-Csquare.Cloud/index.php");
        exit;
    }

    // Populate the form fields with the customer data
    $title = $row['title'];
    $fname = $row['first_name'];
    $lname = $row['last_name'];
    $contact = $row['contact_no'];
    $district = $row['district'];
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // POST method: Update the customer data
    $id = $_POST["id"];
    $title = $_POST["title"];
    $fname = $_POST["Fname"];
    $lname = $_POST["Lname"];
    $contact = $_POST["Contact"];
    $district = $_POST["district"];

    do {
        if (empty($title) || empty($fname) || empty($lname) || empty($contact) || empty($district)) {
            $errorMessage = "Fill All Fields!";
            break;
        }

        $sql = "UPDATE customer SET title=?, first_name=?, last_name=?, contact_no=?, district=? WHERE id=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("sssssi", $title, $fname, $lname, $contact, $district, $id);
        $result = $stmt->execute();
        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        $successMessage = "Customer updated successfully!";
        header("location:/erpsystem/ERP-System-Csquare.Cloud/index.php");
        exit;

    } while (false);
}

// Close the database connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP-System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
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
        <h2>Edit Customer</h2>

        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Title</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="title" value="<?php echo $title; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">First Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Fname" value="<?php echo $fname; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Last Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Lname" value="<?php echo $lname; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Contact Number</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Contact" value="<?php echo $contact; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">District</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="district" value="<?php echo $district; ?>">
                </div>
            </div>

            <?php
            if (!empty($successMessage)) {
                echo "
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>$successMessage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    </div>
                </div>
                ";
            }
            ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/erpsystem/ERP-System-Csquare.Cloud/index.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
