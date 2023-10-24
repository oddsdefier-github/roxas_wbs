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
<aside class="flex flex-col min-h-screen cursor-pointer bg-primary-700 text-gray-50 text-sm pb-5" id="sidebar">
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
                                    <div class="p-2 rounded-md" style="background-color: #3730a3;">
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

                                    <div class="p-2 rounded-md" style="background-color: #3730a3;">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                                        </svg>

                                        </svg>
                                    </div>
                                    <p class="ml-2">Transactions</p>
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                        <li class="my-2">
                            <a href="logs.php" class="tab flex items-center justify-between gap-2 rounded-md px-3 py-2 hover:bg-primary-600">
                                <span class="flex items-center gap-2">
                                    <div class="p-2 rounded-md" style="background-color: #3730a3;">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>

                                    </div>
                                    <p class="ml-2">Payments</p>
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                        <li class="my-2">
                            <a href="logs.php" class="tab flex items-center justify-between gap-2 rounded-md px-3 py-2 hover:bg-primary-600">
                                <span class="flex items-center gap-2">
                                    <div class="p-2 rounded-md" style="background-color: #3730a3;">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                        </svg>

                                    </div>
                                    <p class="ml-2">Notification</p>
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                        <li class="my-2">
                            <a href="logs.php" class="tab flex items-center justify-between gap-2 rounded-md px-3 py-2 hover:bg-primary-600">
                                <span class="flex items-center gap-2">
                                    <div class="p-2 rounded-md" style="background-color: #3730a3;">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                                        </svg>

                                    </div>
                                    <p class="ml-2">Reports</p>
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
                                <div class="p-2 rounded-md" style="background-color: #3730a3;">
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

<script>
    $(document).ready(function() {
        const tabMenu = $(".tab-menu");

        let currentPath = window.location.pathname.split("/")[0];
        currentPath = location.pathname == "/" ? "index.php" : location.pathname.substring(1);
        currentPath = currentPath.substring(currentPath.lastIndexOf("/") + 1);

        $(".tab").each(function() {

            if (currentPath === "/") {
                currentPath = "index.php";
            }
            if ($(this).attr("href") === currentPath) {
                if ($(this).closest("ul").hasClass("submenu-container")) {
                    $(this).closest(".submenu-container").siblings("a").addClass("bg-primary-600 shadow");
                    $(this).closest("ul").toggleClass("open");
                    $(this).addClass("text-primary-300");
                    $(this).find("p").addClass("text-primary-300");

                } else {
                    $(this).addClass("bg-primary-600 shadow");
                    $(this).closest("ul").toggleClass("open");
                }
            }
        });

        const tabSubMenuContainer = $(".submenu-container");
        tabMenu.each(function() {
            $(this).on("click", function(event) {
                event.preventDefault();

                if ($(this).siblings("ul").hasClass('open')) {
                    $(this).siblings("ul").removeClass("open").addClass("close");
                } else {
                    $(this).siblings("ul").removeClass("close").addClass("open");
                }
            });
        })

    });
</script>