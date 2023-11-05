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
        <div class="h-16 text-white w-full">
            <div class="grid grid-cols-4 gap-10 h-full justify-center items-start px-5">
                <div class="w-16 h-16 col-span-1 grid place-items-end justify-center">
                    <img data-profile-picture class="w-10 h-10 rounded-full cursor-pointer p-1 ring-2 ring-primary-300" src="<?php echo BASE_URL ?>/cat.png">
                </div>
                <div class="h-full col-span-3 flex flex-col justify-end items-start px-1">
                    <h5 class="font-medium text-xs truncate"><?php echo $_SESSION['user_name']; ?></h5>
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
                            <a href="" class="tab-menu flex items-center justify-between px-3 py-2 rounded-md hover:bg-primary-600">
                                <div class="flex items-center gap-2">
                                    <div class="p-2 rounded-md" style="background-color: #3730a3;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor" class="w-4 h-4">
                                            <path d="M256 464c-114.69 0-208-93.31-208-208S141.31 48 256 48s208 93.31 208 208-93.31 208-208 208zm0-384c-97 0-176 79-176 176s79 176 176 176 176-78.95 176-176S353.05 80 256 80z" />
                                            <path d="M323.67 292c-17.4 0-34.21-7.72-47.34-21.73a83.76 83.76 0 01-22-51.32c-1.47-20.7 4.88-39.75 17.88-53.62S303.38 144 323.67 144c20.14 0 38.37 7.62 51.33 21.46s19.47 33 18 53.51a84 84 0 01-22 51.3C357.86 284.28 341.06 292 323.67 292zm55.81-74zM163.82 295.36c-29.76 0-55.93-27.51-58.33-61.33-1.23-17.32 4.15-33.33 15.17-45.08s26.22-18 43.15-18 32.12 6.44 43.07 18.14 16.5 27.82 15.25 45c-2.44 33.77-28.6 61.27-58.31 61.27zM420.37 355.28c-1.59-4.7-5.46-9.71-13.22-14.46-23.46-14.33-52.32-21.91-83.48-21.91-30.57 0-60.23 7.9-83.53 22.25-26.25 16.17-43.89 39.75-51 68.18-1.68 6.69-4.13 19.14-1.51 26.11a192.18 192.18 0 00232.75-80.17zM163.63 401.37c7.07-28.21 22.12-51.73 45.47-70.75a8 8 0 00-2.59-13.77c-12-3.83-25.7-5.88-42.69-5.88-23.82 0-49.11 6.45-68.14 18.17-5.4 3.33-10.7 4.61-14.78 5.75a192.84 192.84 0 0077.78 86.64l1.79-.14a102.82 102.82 0 013.16-20.02z" />
                                        </svg>
                                    </div>

                                    <p class="ml-2">Management</p>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </a>

                            <ul class="px-3 submenu-container">
                                <li class="my-2">
                                    <a href="clients.php" class="tab flex items-center  justify-between gap-2 rounded-md px-5 py-2 hover:text-primary-300 group">
                                        <span class="gap-2 flex items-center">
                                            <div class="p-1 rounded-md">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M12 12m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                </svg>
                                            </div>
                                            <p class="text-gray-100 text-xs group-hover:text-primary-300">Clients</p>
                                        </span>
                                    </a>
                                </li>
                                <li class="my-2">
                                    <a href="rates.php" class="tab flex items-center  justify-between gap-2 rounded-md px-5 py-2 hover:text-primary-300 group">
                                        <span class="gap-2 flex items-center">
                                            <div class="p-1 rounded-md">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M12 12m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                </svg>
                                            </div>
                                            <p class="text-gray-100 text-xs group-hover:text-primary-300">Rates</p>
                                        </span>
                                    </a>
                                </li>
                                <li class="my-2">
                                    <a href="charges.php" class="tab flex items-center  justify-between gap-2 rounded-md px-5 py-2 hover:text-primary-300 group">
                                        <span class="gap-2 flex items-center">
                                            <div class="p-1 rounded-md">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M12 12m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                </svg>
                                            </div>
                                            <p class="text-gray-100 text-xs group-hover:text-primary-300">Charges</p>
                                        </span>
                                    </a>
                                </li>
                            </ul>

                        </li>

                        <li class="my-2">
                            <a href="" class="tab-menu flex items-center justify-between px-3 py-2 rounded-md hover:bg-primary-600">
                                <div class="flex items-center gap-2">
                                    <div class="p-2 rounded-md" style="background-color: #3730a3;">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v6m3-3H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                                        </svg>
                                    </div>
                                    <p class="ml-2">Application</p>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </a>

                            <ul class="px-3 submenu-container">
                                <li class="my-2">
                                    <a href="client_application_form.php" class="tab flex items-center  justify-between gap-2 rounded-md px-5 py-2 hover:text-primary-300 group">
                                        <span class="gap-2 flex items-center">
                                            <div class="p-1 rounded-md">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M12 12m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                </svg>
                                            </div>
                                            <p class="text-gray-100 text-xs group-hover:text-primary-300">New</p>
                                        </span>
                                    </a>
                                </li>
                                <li class="my-2">
                                    <a href="clients_application_table.php" class="tab flex items-center  justify-between gap-2 rounded-md px-5 py-2 hover:text-primary-300 group">
                                        <span class="gap-2 flex items-center">
                                            <div class="p-1 rounded-md">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M12 12m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                </svg>
                                            </div>
                                            <p class="text-gray-100 text-xs group-hover:text-primary-300">Application</p>
                                        </span>
                                    </a>
                                </li>
                            </ul>

                        </li>
                        <li class="my-2">
                            <a href="transactions.php" class="tab flex items-center justify-between px-3 py-2 rounded-md hover:bg-primary-600">
                                <div class="flex items-center gap-2">
                                    <div class="p-2 rounded-md" style="background-color: #3730a3;">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5L7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                                        </svg>
                                    </div>
                                    <p class="ml-2">Transaction</p>
                                </div>
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
<script src="./assets/libs/jquery/dist/jquery.min.js"></script>
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