<?php
session_start(); // Start the session
include 'db.php'; // Include the database connection

// Debug: Check if the session variable is set


$userId = $_SESSION['user_id'];

// Prepare the SQL query to fetch user details
$stmt = $pdo->prepare("SELECT name, email, role FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the user is found
if (!$user) {
    echo 'User details not found.';
    exit();
}

// Display the user details
$username = $user['name'];
$email = $user['email'];
$role = $user['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- User Profile Section -->
    <div class="container mx-auto p-8 mt-24">
        <h1 class="text-2xl font-bold mb-4">Hello, <?= htmlspecialchars($username) ?>!</h1>
        <div class="bg-white p-6 shadow-md rounded">
            <h2 class="text-xl font-semibold mb-4">Your Details</h2>
            <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
            <p><strong>Role:</strong> <?= htmlspecialchars($role) ?></p>
            <!-- Add more user details here if needed -->
        </div>
    </div>

</body>
</html>
