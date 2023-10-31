export class DataTableWithPagination {
    constructor (tableName, tableContainerSelector = '#displayClientApplicationTable', filter = []) {
        this.tableName = tableName;
        this.filter = filter
        this.currentSortColumn = "timestamp";
        this.currentSortDirection = 'DESC';
        this.tableContainerSelector = tableContainerSelector;

        this.itemsPerPageKey = `${this.tableContainerSelector}-itemsPerPage`;
        this.currentPageNumberKey = `${this.tableContainerSelector}-currentPageNumber`;

        this.itemsPerPage = parseInt(localStorage.getItem(this.itemsPerPageKey), 10) || 10;
        this.currentPageNumber = parseInt(localStorage.getItem(this.currentPageNumberKey), 10) || 1;


        this.totalItems = 0;
        this.lastPageNumber = 0;

        this.elements = {
            searchInput: $("#table-search"),
            clearSearch: $("#clear-input"),
            searchIcon: $("#search-icon"),
            radioDropDownContainer: $(".dropdown-container"),
            statusFilterBtn: $("#statusFilter"),
            tableContainer: $(tableContainerSelector),
            prevBtn: $("#prev"),
            nextBtn: $("#next"),
            startBtn: $("#start"),
            endBtn: $("#end"),
            itemsPerPageSelector: $("#item-per-page")
        };


        this.searchKey = `${this.tableContainerSelector}-searchKey`;
        this.filterKey = `${this.tableContainerSelector}-filterKey`;

        const savedSearch = localStorage.getItem(this.searchKey) || "";
        const savedFilter = JSON.parse(localStorage.getItem(this.filterKey)) || [];

        this.elements.searchInput.val(savedSearch);
        this.filter = savedFilter;


        this.elements.itemsPerPageSelector.val(this.itemsPerPage);

        this.bindEvents();
        this.bindCheckboxEvents();
        this.fetchTableData(savedSearch, savedFilter);
        this.updateButtonsState();
    }
    bindEvents() {
        let debounceTimeout;
        this.elements.searchInput.on("keyup", () => {
            this.handleClearInput();
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => this.handleSearch(), 300);

        });

        // Bind pagination events
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


            const radios = this.elements.radioDropDownContainer.find("input[type='radio']:checked");
            let currentFilters = [];

            if (radios.length > 0) {
                currentFilters = radios.map((_, radio) => {
                    return {
                        column: $(radio).data('column'),
                        value: radio.value
                    };
                }).get();
            }

            this.fetchTableData(this.elements.searchInput.val(), currentFilters, this.currentSortColumn, this.currentSortDirection);

        });


        $(this.tableContainerSelector).on('click', 'th', (event) => this.handleSort(event));

        this.elements.clearSearch.on("click", () => {
            this.elements.searchInput.val("");
            this.handleClearInput();
            this.handleSearch();
        });


        window.addEventListener('beforeunload', () => {
            localStorage.removeItem(this.searchKey);
            localStorage.removeItem(this.filterKey);
        });
    }

    applyFilter() {
        const radios = this.elements.radioDropDownContainer.find("input[type='radio']:checked");
        const selectedFilters = radios.map((_, radio) => {
            return {
                column: $(radio).data('column'),
                value: radio.value
            };
        }).get();
        console.log(selectedFilters)
        this.currentPageNumber = 1;
        localStorage.setItem(this.filterKey, JSON.stringify(selectedFilters))
        this.fetchTableData(this.elements.searchInput.val(), selectedFilters, this.currentSortColumn, this.currentSortDirection);
    }


    bindCheckboxEvents() {
        const radios = this.elements.radioDropDownContainer.find("input[type='radio']");

        radios.on('change', (event) => {
            this.applyFilter();
            const selectedValue = event.currentTarget.value;
            $(".status-text").text(selectedValue);

            // const checkedRadio = this.elements.radioDropDownContainer.find("input[type='radio']:checked");
            // const checkedValues = checkedRadio.map((_, radio) => {
            //     return {
            //         column: $(radio).data('column'),
            //         value: radio.value
            //     };
            // }).get();

            // const checkedValuesArray = checkedValues.map((checkedValue) => checkedValue.value);
            // console.log(checkedValuesArray);
        });
    }

    handleSort(event) {
        const column = $(event.target).attr('data-column-name');
        const isSortable = $(event.target).attr('data-sortable') !== 'false';

        if (!isSortable) return;  // Early exit if the column is not sortable

        console.log(column);
        if (this.currentSortColumn === column) {
            this.currentSortDirection = this.currentSortDirection === 'ASC' ? 'DESC' : 'ASC';
        } else {
            this.currentSortColumn = column;
            this.currentSortDirection = 'ASC';
        }

        const radios = this.elements.radioDropDownContainer.find("input[type='radio']:checked");
        let currentFilters = [];

        if (radios.length > 0) {
            currentFilters = radios.map((_, radio) => {
                return {
                    column: $(radio).data('column'),
                    value: radio.value
                };
            }).get();
        }
        this.fetchTableData(this.elements.searchInput.val(), currentFilters, this.currentSortColumn, this.currentSortDirection);
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
        this.fetchTableData(this.elements.searchInput.val(), currentFilters, this.currentSortColumn, this.currentSortDirection);
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

    fetchTableData(searchTerm = this.searchKey, filters = this.filter, sortColumn = this.currentSortColumn, sortDirection = this.currentSortDirection) {
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
                    searchTerm: searchTerm,
                    filters: filters,
                    sortColumn: sortColumn,
                    sortDirection: sortDirection
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
        this.fetchTableData(this.elements.searchInput.val(), currentFilters, this.currentSortColumn, this.currentSortDirection);
    }

}

