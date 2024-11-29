<?php
session_start();
include 'db.php'; // Include database connection
include 'Navigation.php';

// Ensure only admins can access this page
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $newRole = $_POST['role'];

    $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->execute([$newRole, $userId]);
    $successMessage = "User role updated successfully!";
}

// Fetch all users for admin to manage
$users = $pdo->query("SELECT id AS user_id, name, email, role FROM users")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage User Roles</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

 

    <!-- Main Content -->
    <div class="container mx-auto p-8 mt-24">
        <h1 class="text-2xl font-bold mb-4">Manage User Roles</h1>
        <?php if (isset($successMessage)): ?>
            <p class="text-green-600 font-semibold mb-4"><?= htmlspecialchars($successMessage) ?></p>
        <?php endif; ?>
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-200 text-left text-sm uppercase">
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Role</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr class="border-b">
                        <td class="px-4 py-2"><?= htmlspecialchars($user['name']) ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($user['email']) ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($user['role']) ?></td>
                        <td class="px-4 py-2">
                            <form action="roleselect.php" method="POST" class="inline">
                                <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                                <select name="role" class="border border-gray-300 rounded p-1">
                                    <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                </select>
                                <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded ml-2">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
