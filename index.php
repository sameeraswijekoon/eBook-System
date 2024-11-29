<?php
session_start();
include 'db.php'; 
include 'Navigation.php';


$userId = $_SESSION['user_id'];


// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit(); // Ensure the rest of the script doesn't execute
}

$currentPage = basename($_SERVER['PHP_SELF']);



$stmt = $pdo->prepare("SELECT name, email, role FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo 'User details not found.';
    exit();
}

$username = $user['name'];
$email = $user['email'];
$role = $user['role'];

if (!isset($_SESSION['user_role'])) {
    echo "<script>
            alert('You need to log in to access this page.');
            window.location.href = 'login.php';
          </script>";
    exit(); // Stop the rest of the page from loading
}


// Fetch all categories and languages for the dropdowns
$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
$languages = $pdo->query("SELECT * FROM languages")->fetchAll(PDO::FETCH_ASSOC);

// Fetch the total count of users, books, categories, and languages
$totalCounts = [
    'users' => $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn(),
    'books' => $pdo->query("SELECT COUNT(*) FROM books")->fetchColumn(),
    'categories' => $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn(),
    'languages' => $pdo->query("SELECT COUNT(*) FROM languages")->fetchColumn()
];

// Fetch latest uploaded books (now 6 books)
$latestBooks = $pdo->query("SELECT 
    b.*, 
    c.category_name, 
    l.language_name 
FROM books b
JOIN categories c ON b.category_id = c.category_id
JOIN languages l ON b.language_id = l.language_id
ORDER BY b.book_id DESC 
LIMIT 6")->fetchAll(PDO::FETCH_ASSOC);

$userName = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'User';  // default to 'User' if not set

// Fetch the count of books per category and per language
$categoryCounts = $pdo->query("SELECT category_id, COUNT(*) as count FROM books GROUP BY category_id")->fetchAll(PDO::FETCH_ASSOC);
$languageCounts = $pdo->query("SELECT language_id, COUNT(*) as count FROM books GROUP BY language_id")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eBook Platform - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .book-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .book-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .btn-transparent {
            background-color: rgba(59, 130, 246, 0.2);
            color: #2563eb;
            border: 1px solid rgba(59, 130, 246, 0.3);
            transition: all 0.3s ease;
        }
        .btn-transparent:hover {
            background-color: rgba(59, 130, 246, 0.3);
            border-color: rgba(59, 130, 246, 0.5);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <div class="container mx-auto px-8 py-24">
        <h2 class="text-3xl font-bold mb-8 text-gray-800">Welcome to the eBook Platform <?= htmlspecialchars($username) ?> ! </h2>
      


        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <?php 
            $statsData = [
                'Total Users' => $totalCounts['users'],
                'Total Books' => $totalCounts['books'],
                'Total Categories' => $totalCounts['categories'],
                'Total Languages' => $totalCounts['languages']
            ];
            
            foreach ($statsData as $label => $value): ?>
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <h3 class="text-sm uppercase tracking-wide text-gray-500 mb-2"><?= htmlspecialchars($label) ?></h3>
                    <p class="text-3xl font-bold text-blue-600"><?= htmlspecialchars($value) ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Categories and Languages Book Count -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
            <!-- Category-wise Book Count -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-4 text-gray-700">Books by Category</h3>
                <ul>
                    <?php foreach ($categoryCounts as $categoryCount): ?>
                        <li class="flex justify-between mb-2 p-2 hover:bg-blue-50 rounded">
                            <span><?= htmlspecialchars($categories[$categoryCount['category_id'] - 1]['category_name']) ?></span>
                            <span class="text-blue-600"><?= $categoryCount['count'] ?> Books</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Language-wise Book Count -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-4 text-gray-700">Books by Language</h3>
                <ul>
                    <?php foreach ($languageCounts as $languageCount): ?>
                        <li class="flex justify-between mb-2 p-2 hover:bg-blue-50 rounded">
                            <span><?= htmlspecialchars($languages[$languageCount['language_id'] - 1]['language_name']) ?></span>
                            <span class="text-blue-600"><?= $languageCount['count'] ?> Books</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

<!-- Latest Books Section with 3 Columns, 6 Books -->
<h2 class="text-2xl font-semibold mb-6 text-gray-700">Latest Uploaded Books</h2>
<div class="grid grid-cols-6 gap-6">
    <?php  foreach ($latestBooks as $book): ?>
        <div class="book-card bg-white rounded-lg overflow-hidden shadow-md">
            <div class="flex flex-col h-full">
                <img class="w-full h-48 object-cover" 
                     src="uploads/<?= htmlspecialchars($book['cover_image']) ?>" 
                     alt="<?= htmlspecialchars($book['title']) ?> Cover">
                <div class="p-4 flex flex-col justify-between flex-grow">
                    <div>
                        <h5 class="text-lg font-bold mb-2 truncate"><?= htmlspecialchars($book['title']) ?></h5>
                        <p class="text-sm text-gray-600 mb-2">
                            Category: <?= htmlspecialchars($book['category_name']) ?>
                        </p>
                        <p class="text-sm text-gray-600 mb-2">
                            Language: <?= htmlspecialchars($book['language_name']) ?>
                        </p>
                    </div>
                    <button class="view-book-btn btn-transparent w-full py-2 rounded text-sm mt-2" 
                            data-pdf-file="<?= htmlspecialchars($book['pdf_file']) ?>">
                        View PDF
                    </button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

    <!-- Modal for viewing book -->
    <div id="bookModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 relative w-11/12 max-w-4xl">
            <span class="close absolute top-4 right-4 text-2xl font-bold text-gray-500 cursor-pointer hover:text-gray-700">&times;</span>
            <h3 class="text-xl font-bold text-gray-700 mb-4">View Book PDF</h3>
            <iframe id="bookIframe" src="" class="w-full h-[500px] border rounded" allowfullscreen></iframe>
        </div>
    </div>

    <script>

document.addEventListener("DOMContentLoaded", function () {
    const rows = document.querySelectorAll(".book-row");
    let currentRow = 0;

    setInterval(() => {
        rows.forEach((row, index) => {
            row.classList.add("hidden"); // Hide all rows
        });
        rows[currentRow].classList.remove("hidden"); // Show the current row
        currentRow = (currentRow + 1) % rows.length; // Move to the next row
    }, 1000); // Change every second
});
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById("bookModal");
        const iframe = document.getElementById("bookIframe");
        const closeBtn = document.querySelector(".close");
        const viewButtons = document.querySelectorAll(".view-book-btn");

        viewButtons.forEach(function(button) {
            button.addEventListener("click", function() {
                const pdfFile = this.getAttribute("data-pdf-file");
                iframe.src = `uploads/${pdfFile}`;
                modal.classList.remove('hidden');
            });
        });

        const closeModal = () => {
            modal.classList.add('hidden');
            iframe.src = "";
        };

        closeBtn.addEventListener('click', closeModal);

        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    });
    </script>
</body>
</html>