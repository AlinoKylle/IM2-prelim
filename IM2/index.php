<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Store</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container mt-5">
    <h2>Product Store</h2>

    <!<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductLabel">Add Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="add_product.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" class="form-control" name="product_name" required>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" name="category" required>
                            <option value="Electronics">Electronics</option>
                            <option value="Toys & Games">Toys & Games</option>
                            <option value="Grocery & Food">Grocery & Food</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" name="price" required step="0.01">
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control" name="quantity" required>
                    </div>
                    <div class="form-group">
                        <label for="created_at">Date of Purchase</label>
                        <input type="date" class="form-control" name="created_at" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <!-- Search and Filter -->
    <form method="GET" class="mb-3">
        <div class="form-row">
            <div class="form-group col-md-4">
                <input type="text" class="form-control" name="search" placeholder="Search Product" value="<?php echo $_GET['search'] ?? ''; ?>">
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="category">
                    <option value="">All Categories</option>
                    <option value="Electronics" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Electronics') ? 'selected' : ''; ?>>Electronics</option>
                    <option value="Toys & Games" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Toys & Games') ? 'selected' : ''; ?>>Toys & Games</option>
                    <option value="Grocery & Food" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Grocery & Food') ? 'selected' : ''; ?>>Grocery & Food</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="dateStart">Start Date</label>
                <input type="date" class="form-control" name="dateStart" value="<?php echo $_GET['dateStart'] ?? ''; ?>">
            </div>
            <div class="form-group col-md-4">
                <label for="dateEnd">End Date</label>
                <input type="date" class="form-control" name="dateEnd" value="<?php echo $_GET['dateEnd'] ?? ''; ?>">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addProductModal">Add Product</button>
    </form>

    <!-- Product Table -->
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Product Name</th>
                <th scope="col">Category</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Created At</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'db.php';
            $products = getProducts($_GET['search'] ?? '', $_GET['category'] ?? '', $_GET['dateStart'] ?? '', $_GET['dateEnd'] ?? '');
            foreach ($products as $product) {
                echo "<tr>
                    <th scope='row'>{$product['product_id']}</th>
                    <td>{$product['product_name']}</td>
                    <td>{$product['category']}</td>
                    <td>{$product['price']}</td>
                    <td>{$product['quantity']}</td>
                    <td>{$product['created_at']}</td>
                    <td>
                        <button type='button' class='btn btn-warning' data-toggle='modal' data-target='#editProductModal{$product['product_id']}'>Edit</button>
                        <form action='delete_product.php' method='POST' style='display:inline;'>
                            <input type='hidden' name='product_id' value='{$product['product_id']}'>
                            <button type='submit' class='btn btn-danger'>Delete</button>
                        </form>
                    </td>
                </tr>";

                // Edit Product Modal
                echo "<div class='modal fade' id='editProductModal{$product['product_id']}' tabindex='-1' role='dialog' aria-labelledby='editProductLabel' aria-hidden='true'>
                    <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='editProductLabel'>Edit Product</h5>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>
                            <form action='edit_product.php' method='POST'>
                                <div class='modal-body'>
                                    <input type='hidden' name='product_id' value='{$product['product_id']}'>
                                    <div class='form-group'>
                                        <label for='product_name'>Product Name</label>
                                        <input type='text' class='form-control' name='product_name' value='{$product['product_name']}' required>
                                    </div>
                                    <div class='form-group'>
                                        <label for='category'>Category</label>
                                        <select class='form-control' name='category' required>
                                            <option value='Electronics' " . ($product['category'] == 'Electronics' ? 'selected' : '') . ">Electronics</option>
                                            <option value='Toys & Games' " . ($product['category'] == 'Toys & Games' ? 'selected' : '') . ">Toys & Games</option>
                                            <option value='Grocery & Food' " . ($product['category'] == 'Grocery & Food' ? 'selected' : '') . ">Grocery & Food</option>
                                        </select>
                                    </div>
                                    <div class='form-group'>
                                        <label for='price'>Price</label>
                                        <input type='number' class='form-control' name='price' value='{$product['price']}' required step='0.01'>
                                    </div>
                                    <div class='form-group'>
                                        <label for='quantity'>Quantity</label>
                                        <input type='number' class='form-control' name='quantity' value='{$product['quantity']}' required>
                                    </div>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                    <button type='submit' class='btn btn-primary'>Update Product</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
