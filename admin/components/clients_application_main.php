<div class="px-10">
    <div>
        <div class="sticky top-0 mb-4 bg-white border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">New Client</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg" id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">Applicants</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg" id="settings-tab" data-tabs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">Recent</button>
                </li>
                <!-- <li role="presentation">
                    <button class="inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg" id="contacts-tab" data-tabs-target="#contacts" type="button" role="tab" aria-controls="contacts" aria-selected="false">Contacts</button>
                </li> -->
            </ul>
        </div>
        <div id="myTabContent">
            <div class="hidden p-4 rounded-lg dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <?php include 'client_application_form.php'; ?>
            </div>
            <div class="hidden w-full p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                <?php include 'clients_main.php'; ?>
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Settings tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
                <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Contacts tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
            </div>
        </div>
    </div>


</div>