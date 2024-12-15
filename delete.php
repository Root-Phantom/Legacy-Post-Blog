<?php
$pdo = require('pdo.php');

$isDeleteRequest = $_SERVER["REQUEST_METHOD"] === "POST" && $_POST['_method'] === 'DELETE';
if ($isDeleteRequest) {

    $id = intval($_POST["id"]);
    if ($id <= 0) {
        echo "Invalid ID.";
        exit;
    }

    $statement = $pdo->prepare("DELETE FROM posts WHERE id = :id");
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    header("Location: index.php");
    exit;
}
?>