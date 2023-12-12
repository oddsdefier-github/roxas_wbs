export class DataTableWithPagination {
    constructor (tableName, tableContainerSelector = '#displayClientApplicationTable', filter = []) {
        this.tableName = tableName;

        this.currentSortColumn = "timestamp";
        this.currentSortDirection = 'DESC';

        this.tableContainerSelector = tableContainerSelector;

        this.itemsPerPageKey = `${this.tableContainerSelector}-itemsPerPage`;
        this.currentPageNumberKey = `${this.tableContainerSelector}-currentPageNumber`;

        this.searchKey = `${this.tableContainerSelector}-searchKey`;
        this.filterKey = `${this.tableContainerSelector}-filterKey`;


        this.savedSearch = localStorage.getItem(this.searchKey) || "";
        this.filter = JSON.parse(localStorage.getItem(this.filterKey)) || filter;

        this.itemsPerPage = parseInt(localStorage.getItem(this.itemsPerPageKey), 10) || 10;
        this.currentPageNumber = parseInt(localStorage.getItem(this.currentPageNumberKey), 10) || 1;


        this.startDateKey = `${this.tableContainerSelector}-startDateKey`;
        this.endDateKey = `${this.tableContainerSelector}-endDateKey`;

        this.startDate = localStorage.getItem(this.startDateKey) || "";
        this.endDate = localStorage.getItem(this.endDateKey) || "";


        this.totalItems = 0;
        this.lastPageNumber = 0;

        this.elements = {
            searchInput: $("#table-search"),
            clearSearch: $("#clear-input"),
            searchIcon: $("#search-icon"),
            radioDropDownContainer: $(".dropdown-container"),
            statusFilterBtn: $("#statusFilter"),
            resetFilter: $("#filterReset"),
            tableContainer: $(tableContainerSelector),
            prevBtn: $("#prev"),
            nextBtn: $("#next"),
            startBtn: $("#start"),
            endBtn: $("#end"),
            itemsPerPageSelector: $("#item-per-page"),
            dateRangePicker: $("#date_range_picker")
        };

        this.elements.searchInput.val(this.savedSearch);
        this.elements.itemsPerPageSelector.val(this.itemsPerPage);


        this.bindEvents();
        this.bindFilterEvents();
        this.updateButtonsState();

        this.initializeDateRangePicker();
    }
    bindEvents() {
        let debounceTimeout;
        this.elements.searchInput.on("keyup", () => {
            this.handleClearInput();
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => this.handleSearch(), 300);

        });

        this.elements.resetFilter.on("click", () => { this.handleFilterReset() });
        this.elements.prevBtn.on("click", () => this.handlePageChange("prev"));
        this.elements.nextBtn.on("click", () => this.handlePageChange("next"));
        this.elements.startBtn.on("click", () => this.handlePageChange("start"));
        this.elements.endBtn.on("click", () => this.handlePageChange("end"));


        this.elements.itemsPerPageSelector.change(() => {
            this.itemsPerPage = parseInt(this.elements.itemsPerPageSelector.val(), 10);
            localStorage.setItem(this.itemsPerPageKey, this.itemsPerPage);
            this.lastPageNumber = Math.ceil(this.totalItems / this.itemsPerPage);

            if (this.currentPageNumber > this.lastPageNumber) {
                this.currentPageNumber = this.lastPageNumber;
            }

            this.currentPageNumber = 1;

            this.fetchTableData(this.savedSearch, this.filter, this.currentSortColumn, this.currentSortDirection, this.startDate, this.endDate);
        });


        $(this.tableContainerSelector).on('click', 'th', (event) => this.handleSort(event));

        this.elements.clearSearch.on("click", () => {
            this.elements.searchInput.val("");
            this.handleClearInput();
            this.handleSearch();
        });

        this.applySavedFiltersToUI();
        this.handleClearInput();
        this.elements.resetFilter.prop("disabled", false)
    }


    initializeDateRangePicker() {
        const self = this;

        let start = moment(self.startDate, 'YYYY-MM-DD', true);
        console.log(start)
        let end = moment(self.endDate, 'YYYY-MM-DD', true);

        if (!start.isValid() || !end.isValid()) {
            start = moment().subtract(312, 'days');
            end = moment();
        }

        function callback(start, end) {
            $('#date_range_picker span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

            const startDate = start.format('YYYY-MM-DD');
            const endDate = end.format('YYYY-MM-DD');

            localStorage.setItem(self.startDateKey, startDate);
            localStorage.setItem(self.endDateKey, endDate);

            self.startDate = startDate;
            self.endDate = endDate;

            self.fetchTableData(self.savedSearch, self.filter, self.currentSortColumn, self.currentSortDirection, startDate, endDate);

            console.log('SELF FILTER: ', self.filter)
        }

        this.elements.dateRangePicker.daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Last 10 Months': [moment().subtract(10, 'month').startOf('month'), moment()]
            }
        }, callback);


        this.elements.dateRangePicker.on('apply.daterangepicker', function (ev, picker) {
            const startDate = picker.startDate.format('YYYY-MM-DD');
            const endDate = picker.endDate.format('YYYY-MM-DD');


            localStorage.setItem(self.startDateKey, startDate);
            localStorage.setItem(self.endDateKey, endDate);

            self.startDate = startDate;
            self.endDate = endDate;

            self.fetchTableData(self.savedSearch, self.filter, self.currentSortColumn, self.currentSortDirection, startDate, endDate);

            console.log('SELF FILTER: ', self.filter)
        });

        callback(start, end);
    }

    updateBtnUI() {
        const checkedRadio = this.elements.radioDropDownContainer.find("input[type='radio']:checked");
        const checkedValues = checkedRadio.map((_, radio) => {
            return {
                column: $(radio).data('column'),
                value: radio.value
            };
        }).get();

        const checkedValuesArray = checkedValues.map((checkedValue) => checkedValue.value);
        console.log(checkedValuesArray)
        const statusText = checkedValuesArray.length > 0 ? checkedValuesArray.join(', ') : 'Filter';
        $(".filter_text").text(statusText);
        this.elements.resetFilter.prop("disabled", false)
    }
    applyFilter() {
        const self = this;
        const radios = self.elements.radioDropDownContainer.find("input[type='radio']:checked");
        const selectedFilters = radios.map((_, radio) => {
            return {
                column: $(radio).data('column'),
                value: radio.value
            };
        }).get();

        self.currentPageNumber = 1;

        console.log("SELECTED FILTERS:" + selectedFilters);
        localStorage.setItem(self.filterKey, JSON.stringify(selectedFilters))
        self.filter = selectedFilters;

        self.fetchTableData(self.savedSearch, selectedFilters, self.currentSortColumn, self.currentSortDirection, self.startDate, self.endDate);

        self.updateBtnUI();

        console.log(self.startDate, self.endDate)
    } q

    bindFilterEvents() {
        const radios = this.elements.radioDropDownContainer.find("input[type='radio']");
        radios.on('change', () => {
            this.applyFilter();
        });
    }

    applySavedFiltersToUI() {
        const self = this;
        const checkedValuesArray = [];
        self.filter.forEach(filterObj => {
            let radios = $(`input[data-column='${filterObj.column}'][value='${filterObj.value}']`);
            console.log(radios.length);

            let checkedRadio = filterObj.value;
            checkedValuesArray.push(checkedRadio);

            if (radios.length > 1) {
                radios.each(function () {
                    const radio = $(this);
                    console.log(radio.find(':checked'));
                    radio.trigger('change')
                    radio.prop('checked', true);
                    console.log(radio.prop('checked'));
                });
            } else if (radios.length === 1) {
                radios.prop('checked', true);
            }
        });

        const statusText = checkedValuesArray.length > 0 ? checkedValuesArray.join(', ') : 'Filter';
        $(".filter_text").text(statusText);
    }


    handleFilterReset() {
        localStorage.removeItem(this.searchKey);
        localStorage.removeItem(this.filterKey);
        localStorage.removeItem(this.currentPageNumberKey);
        const radios = this.elements.radioDropDownContainer.find("input[type='radio']");
        radios.prop('checked', false);
        this.applyFilter();
        this.initializeDateRangePicker();
    }


    handleSort(event) {
        const self = this;
        const column = $(event.target).closest('th').attr('data-column-name');
        const isSortable = $(event.target).closest('th').attr('data-sortable') !== 'false';

        if (!isSortable) return;

        if (self.currentSortColumn === column) {
            self.currentSortDirection = self.currentSortDirection === 'ASC' ? 'DESC' : 'ASC';
        } else {
            self.currentSortColumn = column;
            self.currentSortDirection = 'ASC';
        }


        self.fetchTableData(self.savedSearch, self.filter, self.currentSortColumn, self.currentSortDirection, self.startDate, self.endDate);
        console.log(self.startDate, self.endDate)
    }


    updateItemsPerPageOptions() {
        this.elements.itemsPerPageSelector.find('option').each((index, option) => {
            let value = parseInt($(option).val(), 10);
            if (value > this.totalItems) {
                $(option).prop("disabled", true);
            } else {
                $(option).prop("disabled", false);
            }
        });
    }


    handleSearch() {
        localStorage.setItem(this.searchKey, this.elements.searchInput.val());
        this.currentPageNumber = 1;

        const radios = this.elements.radioDropDownContainer.find("input[type='radio']:checked");

        const currentFilters = radios.map((_, radio) => {
            return {
                column: $(radio).data('column'),
                value: radio.value
            };
        }).get();

        this.fetchTableData(this.elements.searchInput.val(), currentFilters, this.currentSortColumn, this.currentSortDirection, this.startDate, this.endDate);
    }

    handleClearInput() {
        let searchTerm = this.elements.searchInput.val().trim();
        if (searchTerm === "") {
            localStorage.removeItem(this.searchKey);
            this.elements.clearSearch.hide();
            this.elements.searchIcon.show();
        } else {
            this.elements.clearSearch.show();
            this.elements.searchIcon.hide();
        }
    }

    updateButtonsState() {
        this.elements.prevBtn.prop("disabled", this.currentPageNumber <= 1);
        this.elements.nextBtn.prop("disabled", this.currentPageNumber >= this.lastPageNumber);
        this.elements.startBtn.prop("disabled", this.currentPageNumber <= 1);
        this.elements.endBtn.prop("disabled", this.currentPageNumber >= this.lastPageNumber);
        $('a[aria-current="page"]').text(this.currentPageNumber);
    }

    fetchTableData(searchTerm, filters, sortColumn, sortDirection, startDate, endDate) {
        const clientID = localStorage.getItem('clientID');
        console.log(clientID);
        // console.log("Page Number:" + this.currentPageNumber);
        // console.log("Search Term:" + searchTerm);
        // console.log("Filters:" + filters);
        // console.log("Sort Column:" + sortColumn)
        // console.log("Sending data to server:", startDate, endDate);
        $.ajax({
            url: "database_actions.php",
            type: 'post',
            dataType: 'html',
            data: {
                action: "getDataTable",
                tableName: this.tableName,
                dataTableParam: {
                    pageNumber: this.currentPageNumber,
                    itemPerPage: this.itemsPerPage,
                    clientID: clientID,
                    searchTerm: searchTerm,
                    filters: filters,
                    sortColumn: sortColumn,
                    sortDirection: sortDirection,
                    startDate: startDate,
                    endDate: endDate
                }
            },
            success: (data, status) => {
                this.elements.tableContainer.html(data);

                // Properly parse the hidden values
                this.totalItems = parseInt($('#totalItemsHidden').val(), 10) || 0;
                this.updateItemsPerPageOptions();
                this.firstItem = parseInt($('input[data-hidden-name="start"]').val(), 10) || 0;
                this.lastItem = parseInt($('input[data-hidden-name="end"]').val(), 10) || 0;

                $('#first_item').text(this.firstItem);
                $('#last_item').text(this.lastItem);
                $('#total_items').text(this.totalItems);

                this.lastPageNumber = Math.ceil(this.totalItems / this.itemsPerPage);
                this.updateButtonsState();

                this.elements.tableContainer.find("tbody tr").addClass("animate-fade-in");
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error("AJAX error:", textStatus, errorThrown);
                this.elements.tableContainer.html("<p>Error fetching data. Please try again later.</p>");  // User-friendly message
            }
        });
    }

    /**
     * Handles page change for the data table with pagination.
     * @param {string} direction - The direction of the page change. Can be "prev", "next", "start", or "end".
     */
    handlePageChange(direction) {
        switch (direction) {
            case "prev":
                if (this.currentPageNumber > 1) this.currentPageNumber--;
                break;
            case "next":
                if (this.currentPageNumber < this.lastPageNumber) this.currentPageNumber++;
                break;
            case "start":
                this.currentPageNumber = 1;
                break;
            case "end":
                this.currentPageNumber = this.lastPageNumber;
                break;
            default:
                console.error("Invalid direction:", direction);
                return;
        }

        localStorage.setItem(this.currentPageNumberKey, this.currentPageNumber);

        // Fetch currently applied filters
        const radios = this.elements.radioDropDownContainer.find("input[type='radio']:checked");
        const currentFilters = radios.map((_, radio) => {
            return {
                column: $(radio).data('column'),
                value: radio.value
            };
        }).get();

        // Pass the filters to fetchTableData
        this.fetchTableData(this.elements.searchInput.val(), currentFilters, this.currentSortColumn, this.currentSortDirection, this.startDate, this.endDate);
    }

}

