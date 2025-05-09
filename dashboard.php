<?php include 'components/header.php'; ?>

<div class="flex h-screen">
    <!-- Sidebar -->
    <div class="w-64 bg-green-500 text-white flex flex-col shadow-lg">
        <div class="p-4 text-center font-bold text-xl border-b border-green-400">Dashboard</div>
        <nav class="flex-1">
            <ul class="space-y-2 p-4">
                <li>
                    <a href="home.php" class="flex items-center p-2 rounded hover:bg-green-400 transition duration-200">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9 2v10m4-10l2 2m-2-2v10"></path>
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <a href="add_staff.php" class="flex items-center p-2 rounded hover:bg-green-400 transition duration-200">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0-1.657-1.343-3-3-3s-3 1.343-3 3 1.343 3 3 3 3-1.343 3-3zm0 0c0 1.657 1.343 3 3 3s3-1.343 3-3-1.343-3-3-3-3 1.343-3 3zm0 0v8m0 0H6m6 0h6"></path>
                        </svg>
                        Add Staff
                    </a>
                </li>
                <li>
                    <a href="feedback.php" class="flex items-center p-2 rounded hover:bg-green-400 transition duration-200">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16h6m-7 4h8a2 2 0 002-2V6a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Feedback
                    </a>
                </li>
                <li>
                    <a href="index.php" class="flex items-center p-2 rounded hover:bg-green-400 transition duration-200">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7"></path>
                        </svg>
                        Log Out
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex justify-center items-center">
        <div class="text-center">
            <h1 class="text-4xl font-bold mb-4">Welcome to the Dashboard</h1>
            <p class="text-lg text-gray-700">You have successfully logged in.</p>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>