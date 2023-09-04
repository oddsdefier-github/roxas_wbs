<style>
    .profile {
        border-radius: 100%;
    }
</style>

<header class="z-10">
    <nav class="flex h-16 items-center justify-between border-b border-gray-200 px-16">
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
        <div class="flex h-full items-center justify-center gap-3">
            <div class="mr-3 flex h-full items-center justify-center gap-3">
                <div class="group flex h-full items-center justify-center hover:border-b-2 hover:border-primary-600">
                    <a href="" class="font-medium group-hover:text-primary-600">Admin</a>
                </div>
                <!-- <div class="group flex h-full items-center justify-center hover:border-b-2 hover:border-primary-600">
                    <a href="index.html" class="font-medium group-hover:text-primary-600">Home</a>
                </div> -->
            </div>
            <?php include 'profile.logo.php' ?>
        </div>
    </nav>
</header>