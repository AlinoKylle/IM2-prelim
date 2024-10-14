<?php
$host = 'localhost'; // Database host
$db = 'productdb'; // Database name
$user = 'root'; // Database username
$pass = ''; // Database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// CRUD Operations
function addProduct($name, $category, $price, $quantity, $purchasedate) {
    global $conn; // Assuming you have a connection variable

    $stmt = $conn->prepare("INSERT INTO products (product_name, category, price, quantity, created_at) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $name, $category, $price, $quantity, $purchasedate); // Adjust binding types accordingly
    $stmt->execute();
    $stmt->close();
}

function getProducts($search = '', $category = '', $dateStart = '', $dateEnd = '') {
    global $pdo;
    $query = "SELECT * FROM products_table WHERE 1";
    $params = [];

    if ($search) {
        $query .= " AND product_name LIKE ?";
        $params[] = "%$search%";
    }
    if ($category) {
        $query .= " AND category = ?";
        $params[] = $category;
    }
    if ($dateStart && $dateEnd) {
        $query .= " AND created_at BETWEEN ? AND ?";
        $params[] = $dateStart;
        $params[] = $dateEnd;
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateProduct($id, $name, $category, $price, $quantity) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE products_table SET product_name = ?, category = ?, price = ?, quantity = ? WHERE product_id = ?");
    return $stmt->execute([$name, $category, $price, $quantity, $id]);
}

function deleteProduct($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM products_table WHERE product_id = ?");
    return $stmt->execute([$id]);
}
?>
