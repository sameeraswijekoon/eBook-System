<?php
session_start();
include 'db.php'; // Database connection
include 'Navigation.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Fetch categories and languages for the dropdowns
$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
$languages = $pdo->query("SELECT * FROM languages")->fetchAll(PDO::FETCH_ASSOC);

// Initialize variables
$title = '';
$category_id = '';
$language_id = '';
$pdfFile = '';
$coverImage = '';
$errors = [];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $category_id = isset($_POST['category']) ? $_POST['category'] : '';
    $language_id = isset($_POST['language']) ? $_POST['language'] : '';
    
    // File uploads
    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
        $pdfFile = 'uploads/' . basename($_FILES['pdf']['name']);
        if (!move_uploaded_file($_FILES['pdf']['tmp_name'], $pdfFile)) {
            $errors[] = 'Failed to upload PDF file.';
        }
    } else {
        $errors[] = 'Please upload a valid PDF file.';
    }

    if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
        $coverImage = 'uploads/' . basename($_FILES['cover']['name']);
        if (!move_uploaded_file($_FILES['cover']['tmp_name'], $coverImage)) {
            $errors[] = 'Failed to upload cover image.';
        }
    } else {
        $errors[] = 'Please upload a cover image.';
    }

    // If no errors, insert data into the database
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO books (title, category_id, language_id, pdf_file, cover_image) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $category_id, $language_id, basename($_FILES['pdf']['name']), basename($_FILES['cover']['name'])]);
            echo "<p class='text-green-500'>Book uploaded successfully!</p>";
        } catch (PDOException $e) {
            echo "<p class='text-red-500'>Error: " . $e->getMessage() . "</p>";
        }
    } else {
        // Display errors
        foreach ($errors as $error) {
            echo "<p class='text-red-500'>$error</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Book</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">




    <!-- Main Content -->
    <div class="container mx-auto p-8 mt-24">
        <h2 class="text-xl font-semibold mb-6">Upload a New Book</h2>

        <form action="Bookupload.php" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
            <!-- Title -->
            <label for="title" class="block text-sm font-medium">Book Title</label>
            <input type="text" name="title" id="title" class="border p-2 rounded w-full mb-4" required>

            <!-- Category -->
            <label for="category" class="block text-sm font-medium">Category</label>
            <select name="category" id="category" class="border p-2 rounded w-full mb-4" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['category_id'] ?>"><?= htmlspecialchars($category['category_name']) ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Language -->
            <label for="language" class="block text-sm font-medium">Language</label>
            <select name="language" id="language" class="border p-2 rounded w-full mb-4" required>
                <?php foreach ($languages as $language): ?>
                    <option value="<?= $language['language_id'] ?>"><?= htmlspecialchars($language['language_name']) ?></option>
                <?php endforeach; ?>
            </select>

            <!-- PDF Upload -->
            <label for="pdf" class="block text-sm font-medium">Upload PDF</label>
            <input type="file" name="pdf" id="pdf" accept=".pdf" class="border p-2 rounded w-full mb-4" required>

            <!-- Cover Image Upload -->
            <label for="cover" class="block text-sm font-medium">Upload Cover Image</label>
            <input type="file" name="cover" id="cover" accept="image/*" class="border p-2 rounded w-full mb-4" required>

            <!-- Submit Button -->
            <button type="submit" class="bg-blue-500 text-white p-2 rounded w-full">Upload Book</button>
        </form>
    </div>

</body>
</html>
