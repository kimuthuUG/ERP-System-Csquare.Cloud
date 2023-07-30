<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "erpsystem_db";

$itemcode = "";
$itemname = "";
$itemcategory = "";
$itemsubcategory = "";
$quantity = "";
$unitprice = "";

$errorMessage = "";
$successMessage = "";

// Create database connection
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $itemcode = $_POST["itemcode"];
    $itemname = $_POST["itemname"];
    $itemcategory = $_POST["itemcategory"];
    $itemsubcategory = $_POST["itemsubcategory"];
    $quantity = $_POST["quantity"];
    $unitprice = $_POST["unitprice"];

    // Assuming the following datatype assumptions for each form field:
    // $itemcode, $itemname, $itemcategory, $itemsubcategory -> VARCHAR
    // $quantity, $unitprice -> INT or DECIMAL (or other appropriate numeric type)

    if (empty($itemcode) || empty($itemname) || empty($itemcategory) || empty($itemsubcategory) || empty($quantity) || empty($unitprice)) {
        $errorMessage = "Fill All Fields!";
    } else {
        $stmt = $connection->prepare("INSERT INTO item(item_code, item_name, item_category, item_subcategory, quantity, unit_price) VALUES (?, ?, ?, ?, ?, ?)");

        // Assuming item_code, item_name, item_category, item_subcategory are VARCHAR,
        // and quantity, unit_price are INT or DECIMAL (change as per your database schema)
        $stmt->bind_param("sssssi", $itemcode, $itemname, $itemcategory, $itemsubcategory, $quantity, $unitprice);

        if ($stmt->execute()) {
            $successMessage = "Item added successfully!";
            $itemcode = "";
            $itemname = "";
            $itemcategory = "";
            $itemsubcategory = "";
            $quantity = "";
            $unitprice = "";
        } else {
            $errorMessage = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

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
                        <a class="nav-link active" aria-current="page"
                            href="/erpsystem/ERP-System-Csquare.Cloud/index.php">Customers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/erpsystem/ERP-System-Csquare.Cloud/itemindex.php">Items</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Reports
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item"
                                    href="/erpsystem/ERP-System-Csquare.Cloud/invoicereport.php">Invoice report</a></li>
                            <li><a class="dropdown-item"
                                    href="/erpsystem/ERP-System-Csquare.Cloud/invoiceitemreport.php">Invoice item
                                    report</a></li>
                            <li><a class="dropdown-item" href="/erpsystem/ERP-System-Csquare.Cloud/itemreport.php">Item
                                    report</a></li>
                        </ul>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    <div class="container my-5">
        <h2>New Item</h2>

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
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Item Code</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="itemcode" value="<?php echo $itemcode; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Item Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="itemname" value="<?php echo $itemname; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Item Category</label>
                <div class="col-sm-6">
                    <select class="form-select" name="itemcategory">
                        <option value="1" <?php if ($itemcategory === 'Printers')
                            echo 'selected'; ?>>Printers</option>
                        <option value="2" <?php if ($itemcategory === 'Laptops')
                            echo 'selected'; ?>>Laptops</option>
                        <option value="3" <?php if ($itemcategory === 'Gadgets')
                            echo 'selected'; ?>>Gadgets</option>
                        <option value="4" <?php if ($itemcategory === 'Ink bottels')
                            echo 'selected'; ?>>Ink bottels</option>
                            <option value="5" <?php if ($itemcategory === 'Cartridges')
                            echo 'selected'; ?>>Cartridges</option>

                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Item Subcategory</label>
                <div class="col-sm-6">
                <select class="form-select" name="itemsubcategory">
                        <option value="1" <?php if ($itemsubcategory === 'HP')
                            echo 'selected'; ?>>HP</option>
                        <option value="2" <?php if ($itemsubcategory === 'Dell')
                            echo 'selected'; ?>>Dell</option>
                        <option value="3" <?php if ($itemsubcategory === 'Lenovo')
                            echo 'selected'; ?>>Lenovo</option>
                        <option value="4" <?php if ($itemsubcategory === 'Acer')
                            echo 'selected'; ?>>Acer</option>
                            <option value="5" <?php if ($itemsubcategory === 'Samsung')
                            echo 'selected'; ?>>Samsung</option>

                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Quantity</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="quantity" value="<?php echo $quantity; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Unit Price</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="unitprice" value="<?php echo $unitprice; ?>">
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/erp-system-csquare.cloud/index.php"
                        role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>