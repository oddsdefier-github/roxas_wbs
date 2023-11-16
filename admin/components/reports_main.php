<div class="px-10 py-10">
    <div class="flex justify-center items-start" style="">
        <div class="shadow-lg bg-white rounded-md" style="width: 40rem;">
            <div class="py-5 px-6 rounded-t pb-4 border-b flex justify-start items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M17 17m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                    <path d="M17 13v4h4" />
                    <path d="M12 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M11.5 21h-6.5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v2m0 3v4" />
                </svg>
                <p class="text-lg font-bold">Reports</p>
            </div>
            <div class="py-5 px-6">
                <div class="flex gap-2 justify-start items-center mb-3">
                    <div class="flex flex-col gap-1">
                        <p class="font-medium text-gray-500">Category</p>
                        <select name="report_category" id="report_category" class="col-span-3 block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:max-w-xs sm:text-sm sm:leading-6">
                            <option value="application_revenue">Application Revenue</option>
                            <option value="billing_revenue">Billing Revenue</option>
                            <option value="all_revenue">All Revenue</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-2 justify-start items-center">
                    <div class="flex flex-col gap-1">
                        <p class="font-medium text-gray-500">Report Range</p>
                        <div id="reportrange" class="col-span-3 w-full md:w-auto flex items-center justify-center py-3 px-4 text-sm font-medium group text-gray-700 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                            <span class="ml-2"></span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="p-6 flex justify-end items-center">
                <button id="gen_report" class="flex justify-center items-center gap-1 rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9.883 2.207a1.9 1.9 0 0 1 2.087 1.522l.025 .167l.005 .104v4a1 1 0 0 1 -.641 .933l-.107 .035a3.1 3.1 0 1 0 3.73 3.953l.05 -.173a1 1 0 0 1 .855 -.742l.113 -.006h3.8a2 2 0 0 1 2 2a1 1 0 0 1 -.026 .226a10 10 0 1 1 -12.27 -11.933l.27 -.067l.11 -.02z" stroke-width="0" fill="currentColor" />
                        <path d="M14.775 2.526a.996 .996 0 0 1 .22 -.026l.122 .007l.112 .02l.103 .03a10 10 0 0 1 6.003 5.817l.108 .294a1 1 0 0 1 -.824 1.325l-.119 .007h-4.5a1 1 0 0 1 -.76 -.35a8 8 0 0 0 -.89 -.89a1 1 0 0 1 -.342 -.636l-.008 -.124v-4.495l.006 -.118c.005 -.042 .012 -.08 .02 -.116l.03 -.103a.998 .998 0 0 1 .168 -.299l.071 -.08c.03 -.028 .058 -.052 .087 -.075l.09 -.063l.088 -.05l.103 -.043l.112 -.032z" stroke-width="0" fill="currentColor" />
                    </svg>
                    Generate</button>
            </div>
        </div>
    </div>
</div>