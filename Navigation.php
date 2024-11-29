<?php


// Get the current page URL
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<nav class="fixed top-0 left-0 w-full z-50 bg-gradient-to-r from-blue-600 to-indigo-700 shadow-lg">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <!-- Logo with slight hover effect -->
        <a href="index.php" class="flex items-center space-x-3 group">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white group-hover:rotate-6 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            <span class="text-2xl font-semibold text-white tracking-wider group-hover:text-gray-200 transition">eBook Hub</span>
        </a>

        <!-- Navigation Menu -->
        <ul class="flex space-x-6 items-center">
            <!-- Dashboard -->
            <li>
                <a href="index.php" class="<?php echo ($currentPage == 'index.php') ? 'text-white bg-white/20' : 'text-white/80 hover:text-white hover:bg-white/10' ?> px-3 py-2 rounded-md transition-all duration-300 flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- All Books -->
            <li>
                <a href="Allbooks.php" class="<?php echo ($currentPage == 'Allbooks.php') ? 'text-white bg-white/20' : 'text-white/80 hover:text-white hover:bg-white/10' ?> px-3 py-2 rounded-md transition-all duration-300 flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                    </svg>
                    <span>All Books</span>
                </a>
            </li>

            <!-- Conditional Menu Items -->
            <?php if (isset($_SESSION['user_role'])): ?>
                <!-- Admin-specific Menu Items -->
                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                    <li>
                        <a href="Bookupload.php" class="<?php echo ($currentPage == 'Bookupload.php') ? 'text-white bg-white/20' : 'text-white/80 hover:text-white hover:bg-white/10' ?> px-3 py-2 rounded-md transition-all duration-300 flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fillRule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clipRule="evenodd" />
                            </svg>
                            <span>Upload Book</span>
                        </a>
                    </li>
                    <li>
                        <a href="roleselect.php" class="<?php echo ($currentPage == 'roleselect.php') ? 'text-white bg-white/20' : 'text-white/80 hover:text-white hover:bg-white/10' ?> px-3 py-2 rounded-md transition-all duration-300 flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                            </svg>
                            <span>Role Select</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Logout -->
                <li>
                    <a href="logout.php" class="text-white/80 hover:text-red-300 px-3 py-2 rounded-md transition-all duration-300 flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fillRule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 1.293a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 01-1.414-1.414L14.586 11H7a1 1 0 110-2h7.586l-1.293-1.293a1 1 0 010-1.414z" clipRule="evenodd" />
                        </svg>
                        <span>Logout</span>
                    </a>
                </li>
            <?php else: ?>
                <!-- Login/Register for non-logged in users -->
                <li>
                    <a href="login.php" class="<?php echo ($currentPage == 'login.php') ? 'text-white bg-white/20' : 'text-white/80 hover:text-white hover:bg-white/10' ?> px-3 py-2 rounded-md transition-all duration-300 flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fillRule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clipRule="evenodd" />
                        </svg>
                        <span>Login</span>
                    </a>
                </li>
                <li>
                    <a href="register.php" class="<?php echo ($currentPage == 'register.php') ? 'text-white bg-white/20' : 'text-white/80 hover:text-white hover:bg-white/10' ?> px-3 py-2 rounded-md transition-all duration-300 flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                        </svg>
                        <span>Register</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>