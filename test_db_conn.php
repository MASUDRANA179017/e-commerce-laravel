<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=qbit_ecommerce;port=3306', 'root', '');
    echo "Connected successfully";
    
    // Also try a query
    $stmt = $pdo->query("SELECT count(*) FROM products");
    echo "\nProducts count: " . $stmt->fetchColumn();
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
