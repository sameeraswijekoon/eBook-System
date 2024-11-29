<?php
session_start();
include 'db.php'; // Include the database connection
include 'Navigation.php';
// Ensure a book_id is passed in the URL
$book_id = isset($_GET['book_id']) ? (int)$_GET['book_id'] : 0;

// Fetch the book details from the database using the book_id
$stmt = $pdo->prepare("SELECT * FROM books WHERE book_id = :book_id");
$stmt->execute(['book_id' => $book_id]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);

// If no book is found with the given ID
if (!$book) {
    echo "<p class='text-red-500'>Book not found.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Book</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">



    <!-- Main Content -->
    <div class="container mx-auto p-8 mt-24">
        <h2 class="text-xl font-semibold mb-6"><?= htmlspecialchars($book['title']) ?></h2>

        <!-- Display PDF in an iframe -->
        <iframe src="uploads/<?= htmlspecialchars($book['pdf_file']) ?>" width="100%" height="600px"></iframe>
    </div>

</body>
</html>
