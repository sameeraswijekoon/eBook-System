<?php
session_start();
include 'db.php'; // Database connection
include 'Navigation.php';

// Fetch categories and languages for the filter dropdowns
$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
$languages = $pdo->query("SELECT * FROM languages")->fetchAll(PDO::FETCH_ASSOC);

// Initialize filters
$categoryFilter = $_GET['category'] ?? '';
$languageFilter = $_GET['language'] ?? '';

// Fetch books based on filters
$query = "SELECT books.*, categories.category_name, languages.language_name 
          FROM books 
          JOIN categories ON books.category_id = categories.category_id
          JOIN languages ON books.language_id = languages.language_id 
          WHERE 1";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit(); // Ensure the rest of the script doesn't execute
}

$currentPage = basename($_SERVER['PHP_SELF']);


$params = [];
if (!empty($categoryFilter)) {
    $query .= " AND books.category_id = :category_id";
    $params[':category_id'] = $categoryFilter;
}
if (!empty($languageFilter)) {
    $query .= " AND books.language_id = :language_id";
    $params[':language_id'] = $languageFilter;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle book deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_book'])) {
    $bookId = $_POST['book_id'];
    $stmt = $pdo->prepare("DELETE FROM books WHERE book_id = :book_id");
    $stmt->execute([':book_id' => $bookId]);
    header("Location: Allbooks.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Catalog</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* Retain existing design styles */
        .book-card-container {
            perspective: 800px;
            height: 300px;
        }
        .book-card {
            transition: transform 0.8s;
            transform-style: preserve-3d;
            height: 100%;
        }
        .book-card-container:hover .book-card {
            transform: rotateY(180deg);
        }
        .book-card-front, .book-card-back {
            backface-visibility: hidden;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .book-card-back {
            transform: rotateY(180deg);
            background: linear-gradient(135deg, #f6f8f9 0%, #e5ebee 50%, #d7dee3 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 0.75rem;
        }
    </style>
    <script>
        function openPdfModal(pdfUrl) {
            const modal = document.getElementById('pdfModal');
            const iframe = document.getElementById('pdfIframe');
            iframe.src = pdfUrl;
            modal.classList.remove('hidden');
        }

        function closePdfModal() {
            const modal = document.getElementById('pdfModal');
            const iframe = document.getElementById('pdfIframe');
            iframe.src = ''; 
            modal.classList.add('hidden');
        }
    </script>
</head>
<body class="bg-gray-50">
   
    <!-- Main Content -->
    <div class="container mx-auto px-6 py-24">
        <div class="bg-white shadow-xl rounded-lg p-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Book Catalog</h2>
            </div>

            <!-- Filters -->
            <form method="GET" class="mb-4 flex space-x-4">
                <select name="category" class="border rounded p-2">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['category_id'] ?>" <?= $category['category_id'] == $categoryFilter ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['category_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <select name="language" class="border rounded p-2">
                    <option value="">All Languages</option>
                    <?php foreach ($languages as $language): ?>
                        <option value="<?= $language['language_id'] ?>" <?= $language['language_id'] == $languageFilter ? 'selected' : '' ?>>
                            <?= htmlspecialchars($language['language_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
            </form>

            <!-- Book Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                <?php foreach ($books as $book): ?>
                    <div class="book-card-container">
                        <div class="book-card relative">
                            <!-- Front Side -->
                            <div class="book-card-front">
                                <img src="uploads/<?= htmlspecialchars($book['cover_image']) ?>" 
                                     alt="<?= htmlspecialchars($book['title']) ?>" 
                                     class="w-full h-full object-cover" 
                                     onerror="this.onerror=null; this.src='placeholder.jpg';" />
                                <div class="book-card-overlay">
                                    <h3 class="text-sm font-bold text-white truncate"><?= htmlspecialchars($book['title']) ?></h3>
                                    <p class="text-xs text-gray-300 truncate"><?= htmlspecialchars($book['category_name']) ?></p>
                                </div>
                            </div>
                            <!-- Back Side -->
                            <div class="book-card-back">
                                <div>
                                    <h3 class="text-sm font-bold text-gray-800 mb-1 truncate"><?= htmlspecialchars($book['title']) ?></h3>
                                    <p class="text-xs text-gray-600 mb-2">
                                        Category: <?= htmlspecialchars($book['category_name']) ?><br>
                                        Language: <?= htmlspecialchars($book['language_name']) ?>
                                    </p>
                                </div>
                                <button 
                                    onclick="openPdfModal('uploads/<?= htmlspecialchars($book['pdf_file']) ?>')" 
                                    class="w-full bg-blue-600 text-white px-2 py-1 rounded-md hover:bg-blue-700 text-xs transition">
                                    View PDF
                                </button>
                                <!-- Delete Button for Admins -->
                                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                                    <form method="POST" class="mt-2">
                                        <input type="hidden" name="book_id" value="<?= htmlspecialchars($book['book_id']) ?>">
                                        <button type="submit" name="delete_book" 
                                            class="w-full bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-700 text-xs transition">
                                            Delete
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- PDF Modal -->
    <div id="pdfModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden w-11/12 md:w-3/4 lg:w-2/3 xl:w-1/2 h-3/4">
            <div class="flex justify-between items-center bg-gray-800 text-white px-4 py-2">
                <h3 class="text-lg">PDF Viewer</h3>
                <button onclick="closePdfModal()" class="text-red-400 hover:text-red-600 text-lg">&times;</button>
            </div>
            <iframe id="pdfIframe" class="w-full h-full" frameborder="0"></iframe>
        </div>
    </div>
</body>
</html>
