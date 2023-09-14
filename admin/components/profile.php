<style>
    .profile {
        border-radius: 100%;
    }
</style>
<div class="flex items-center border-l border-gray-400 px-5 gap-3">
    <div>
        <h5 class="text-blue-600 font-medium"> <?php echo $_SESSION['admin_name']; ?></h5>
    </div>
    <div class="flex items-center ml-3">
        <div>
            <button type="button" class="profile flex text-sm bg-gray-800 overflow-clip focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                <!-- <span class="sr-only">Open user menu</span> -->
                <div class="overflow-clip w-10 h-10">
                    <img id="thumbnail" src="../cat.png" alt="user photo">
                </div>
            </button>
        </div>
        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow-md dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
            <div class="px-4 py-3" role="none">
                <p class="text-sm text-gray-900 dark:text-white" role="none">
                    <?php echo $_SESSION['admin_name']; ?>
                </p>
                <p class="text-xs font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                    capstone.com
                </p>
            </div>
            <ul class="py-1" role="none">
                <li>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Dashboard</a>
                </li>
                <li>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Settings</a>
                </li>
                <li>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Earnings</a>
                </li>
                <li>
                    <a id="signout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer" role="menuitem">Sign out</a>
                </li>
            </ul>
        </div>
    </div>
</div>