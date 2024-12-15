<?php
$host = "46.8.228.94";
$port = 3306;
$username = "nima";
$password = "Hunter_8719";
$dbname = "blog";
$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>