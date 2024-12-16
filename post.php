<?php
$pdo = require("pdo.php");
$id = isset($_GET['id']) ? $_GET['id'] : null;
if (!$id) {
    header("Location: index.php");
    exit;
}

$statement = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
$statement->bindParam(':id', $id, PDO::PARAM_INT);
$statement->execute();
$post = $statement->fetch();
$title = htmlspecialchars_decode($post['title']);
$body = htmlspecialchars_decode($post['body']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Blog</title>
</head>
<body class="bg-gray-100">
<header class="bg-blue-500 text-white p-4">
    <div class="container mx-auto">
        <h1 class="text-3xl font-semibold">My Blog</h1>
    </div>
</header>

<div class="container mx-auto p-4 mt-4">
    <div class="md my-4">
        <div class="rounded-lg shadow-md mb-8">
            <div class="p-4">
                <h2 class="text-3xl font-semibold mb-6">
                    <?= $title ?>
                </h2>
                <p class="text-xl"><?= $body ?></p>
                <a href="index.php"
                   class="inline-block mt-10 py-2 px-4 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
                    Go Back
                </a>
            </div>
        </div>
        <!-- Edit Button-->
        <a href="edit.php?id=<?= $post['id'] ?>"
           class="bg-green-500 text-white px-4 py-2 rounded block w-full text-center mb-4 hover:bg-green-600 focus:outline-none">Edit</a>

        <!-- Delete Form -->
        <form action="delete.php" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="id" value="<?= $post['id'] ?>">
            <button type="submit" name="submit"
                    class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 focus:outline-none w-full">Delete
            </button>
        </form>
    </div>
</div>
</body>
</html>


