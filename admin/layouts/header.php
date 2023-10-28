<header class="border-b border-gray-900/10">
    <nav class="flex h-16 items-center justify-between border-b border-zinc-100 px-10">
        <div>
            <button id="toggle-button" class="appearance-none p-1 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="h-5 w-5 stroke-gray-800" id="arrow-left">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                </svg>

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="hidden h-5 w-5 stroke-gray-800" id="arrow-right">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                </svg>
            </button>
        </div>
        <div class="flex h-full items-center justify-center gap-5">
            <?php include 'toggle_outline.php'; ?>
            <?php include './components/notification.php'; ?>
            <div>
                <img data-profile-picture id="avatarButton" type="button" data-dropdown-toggle="userDropdown" data-dropdown-placement="bottom-start" class=" w-10 h-10 rounded-full cursor-pointer" src="<?php echo BASE_URL ?>/cat.png" alt="User dropdown">

                <!-- Dropdown menu -->
                <div id="userDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                    <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                        <div>
                            <h5 class="font-medium"><?php echo $_SESSION['admin_name']; ?></h5>
                        </div>
                        <div class="font-medium truncate">
                            <h6 class="font-medium text-xs text-gray-400"><?php echo $_SESSION['user_role']; ?></h6>
                        </div>
                    </div>
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="avatarButton">
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
                        </li>
                    </ul>
                    <div class="py-1 cursor-pointer">
                        <button data-button-type="open-modal" data-modal-name="sign_out" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</button>
                    </div>
                </div>
            </div>

        </div>
    </nav>
</header>