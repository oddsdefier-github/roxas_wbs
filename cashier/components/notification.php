<button id="dropdownNotificationButton" data-dropdown-toggle="dropdownNotification" class="relative inline-flex items-center text-sm font-medium text-center text-gray-500 hover:text-gray-900 focus:outline-none dark:hover:text-white dark:text-gray-400" type="button">
    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 14 20">
        <path d="M12.133 10.632v-1.8A5.406 5.406 0 0 0 7.979 3.57.946.946 0 0 0 8 3.464V1.1a1 1 0 0 0-2 0v2.364a.946.946 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C1.867 13.018 0 13.614 0 14.807 0 15.4 0 16 .538 16h12.924C14 16 14 15.4 14 14.807c0-1.193-1.867-1.789-1.867-4.175ZM3.823 17a3.453 3.453 0 0 0 6.354 0H3.823Z" />
    </svg>

    <div class="notif-count absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-3 -right-2 dark:border-gray-900" style="display: none;">
        <span></span>
    </div>

</button>

<!-- Dropdown menu -->
<div id="dropdownNotification" class="z-20 hidden w-full max-w-sm bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-800 dark:divide-gray-700" aria-labelledby="dropdownNotificationButton">
    <div class="block px-4 py-2 font-medium text-center text-gray-700 rounded-t-lg bg-gray-50 dark:bg-gray-800 dark:text-white">
        Notifications
    </div>
    <div class="divide-y divide-gray-100 overflow-y-auto max-h-[50vh] hover:scroll-auto scroll-smooth " id="notification_container">
        <!-- <a href="https://www.facebook.com" target="_blank" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700">
            <div class="flex-shrink-0">
                <img class="rounded-full w-11 h-11" src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGZpbGw9Im5vbmUiIHZpZXdCb3g9IjAgMCAyNCAyNCIgc3Ryb2tlLXdpZHRoPSIxLjUiIHN0cm9rZT0iY3VycmVudENvbG9yIiBjbGFzcz0idy02IGgtNiI+DQogIDxwYXRoIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgZD0iTTEwLjEyNSAyLjI1aC00LjVjLS42MjEgMC0xLjEyNS41MDQtMS4xMjUgMS4xMjV2MTcuMjVjMCAuNjIxLjUwNCAxLjEyNSAxLjEyNSAxLjEyNWgxMi43NWMuNjIxIDAgMS4xMjUtLjUwNCAxLjEyNS0xLjEyNXYtOU0xMC4xMjUgMi4yNWguMzc1YTkgOSAwIDAxOSA5di4zNzVNMTAuMTI1IDIuMjVBMy4zNzUgMy4zNzUgMCAwMTEzLjUgNS42MjV2MS41YzAgLjYyMS41MDQgMS4xMjUgMS4xMjUgMS4xMjVoMS41YTMuMzc1IDMuMzc1IDAgMDEzLjM3NSAzLjM3NU05IDE1bDIuMjUgMi4yNUwxNSAxMiIgLz4NCjwvc3ZnPg0K' alt="Confirm Icon">
            </div>
            <div class="w-full pl-3">
                <div class="text-gray-500 text-sm mb-1.5 dark:text-gray-400">New client has been confirmed by <span class="font-semibold text-gray-900 dark:text-white">Jeffry James Paner</span></div>
                <div class="text-xs text-blue-600 dark:text-blue-500">a few moments ago</div>
            </div>
        </a> -->
    </div>
    <button id="view_all_notifications" class="block w-full py-2 text-sm font-medium text-center text-gray-900 rounded-b-lg bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white">
        <div class="inline-flex items-center ">
            <svg class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">
                <path d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
            </svg>
            View all
        </div>
    </button>
</div>