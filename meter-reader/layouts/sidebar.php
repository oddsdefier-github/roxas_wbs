<style>
    .submenu-container {
        max-height: 0px;
        overflow: hidden;
    }

    @keyframes show {
        0% {
            max-height: 0px;
        }

        100% {
            max-height: 500px;
        }
    }

    @keyframes hide {
        0% {
            max-height: 500px;
        }

        100% {
            max-height: 0px;
        }
    }


    .submenu-container.open {
        animation: show 0.768s forwards;
    }

    .submenu-container.close {
        animation: hide 0.5s forwards;
    }
</style>
<aside class="flex flex-col min-h-screen cursor-pointer text-gray-50 text-sm pb-5" id="sidebar" style="background-color: #1e1b4b">
    <div class="h-full w-64">
        <div class="h-16 text-white pr-10">
            <div class="flex gap-3 h-full items-end justify-center">
                <div>
                    <img data-profile-picture class=" w-10 h-10 rounded-full cursor-pointer p-1 ring-2 ring-primary-300" src="<?php echo BASE_URL ?>/cat.png" alt="User dropdown">
                </div>
                <div class="flex flex-col justify-center items-start">
                    <h5 class="font-medium text-xs truncate"><?php echo $_SESSION['admin_name']; ?></h5>
                    <h6 class="font-medium text-xs" style="color: #a5b4fc;"><?php echo $_SESSION['user_role']; ?></h6>
                </div>
            </div>
        </div>
        <div class="px-5">
            <div class="mt-5">
                <ul class="">
                    <li class="py-2 px-3 font-medium uppercase text-xs" style="color: #a5b4fc">Main</li>
                    <ul class="">
                        <li class="my-2">
                            <a href="dashboard.php" class="tab flex items-center justify-between px-3 py-2 rounded-md hover:bg-primary-600">
                                <div class="flex items-center gap-2">
                                    <div class="p-2 rounded-md" style="background-color: #4338ca;">
                                        <svg xmlns=" http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                                        </svg>
                                    </div>

                                    <p class="ml-2">Dashboard</p>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                        <li class="my-2">
                            <a href="billing.php" class="tab flex items-center justify-between gap-2 rounded-md px-3 py-2 hover:bg-primary-600">
                                <span class="flex items-center gap-2">

                                    <div class="p-2 rounded-md" style="background-color: #4338ca;">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                        </svg>
                                    </div>
                                    <p class="ml-2">Billing</p>
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                        <li class="my-2">
                            <a href="logs.php" class="tab flex items-center justify-between gap-2 rounded-md px-3 py-2 hover:bg-primary-600">
                                <span class="flex items-center gap-2">
                                    <div class="p-2 rounded-md" style="background-color: #4338ca;">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                        </svg>
                                    </div>
                                    <p class="ml-2">Logs</p>
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </ul>
                <ul class="w-full">
                    <li class="py-2 px-3 font-medium uppercase text-xs" style="color: #a5b4fc">Settings</li>
                    <li class="my-2">
                        <a href="" class="tab flex items-center justify-between gap-2 rounded-md px-3 py-2 hover:bg-primary-600">
                            <span class="flex items-center gap-2">
                                <div class="p-2 rounded-md" style="background-color: #4338ca;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <span class="ml-2">Profile</span>
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </li>
                    <li class="my-2">
                        <a href="" class="tab flex items-center justify-between gap-2 rounded-md px-3 py-2 hover:bg-primary-600">
                            <span class="flex items-center gap-2">
                                <div class="p-2 rounded-md" style="background-color: #4338ca;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z" />
                                    </svg>
                                </div>
                                <span class="ml-2">Barcode</span>
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="flex-1 text-white">
        <div class="flex gap-3 h-full items-end justify-center px-5">
            <button data-button-type="open-modal" data-modal-name="sign_out" class="flex w-full items-center justify-center px-3 py-2 shadow-md ring-1 ring-primary-500 rounded-md hover:bg-primary-600">
                <p class="text-base pointer-events-none">Sign out</p>
            </button>
        </div>
    </div>
</aside>