export class DataTableWithPagination {
    constructor (tableName, tableContainerSelector = '#displayClientApplicationTable') {
        this.tableName = tableName;

        this.itemsPerPageKey = `${this.tableName}-itemsPerPage`;
        this.currentPageNumberKey = `${this.tableName}-currentPageNumber`;

        this.itemsPerPage = parseInt(localStorage.getItem(this.itemsPerPageKey), 10) || 5;

        this.currentPageNumber = parseInt(localStorage.getItem(this.currentPageNumberKey), 10) || 1;

        this.totalItems = 0;
        this.lastPageNumber = 0;

        this.elements = {
            searchInput: $("#table-search"),
            clearSearch: $("#clear-input"),
            searchIcon: $("#search-icon"),
            tableContainer: $(tableContainerSelector),
            prevBtn: $(`nav[data-table-name='${this.tableName}'] #prev`),
            nextBtn: $(`nav[data-table-name='${this.tableName}'] #next`),
            startBtn: $(`nav[data-table-name='${this.tableName}'] #start`),
            endBtn: $(`nav[data-table-name='${this.tableName}'] #end`),
            itemsPerPageSelector: $(`nav[data-table-name='${this.tableName}'] #item-per-page`)
        };


        
        this.elements.itemsPerPageSelector.val(this.itemsPerPage);

        this.bindEvents();
        // this.handlePageChange('start');
        this.fetchTableData();
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
        this.elements.prevBtn.on("click", () => {
            this.handlePageChange("prev");
        });

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
            this.fetchTableData(this.elements.searchInput.val());
        });

        this.elements.clearSearch.on("click", () => {
            this.elements.searchInput.val("");
            this.handleClearInput();
            this.handleSearch();
        })
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
        this.currentPageNumber = 1;
        this.fetchTableData(this.elements.searchInput.val());
    }

    handleClearInput() {
        let searchTerm = this.elements.searchInput.val().trim();
        if (searchTerm === "") {
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
        $(`nav[data-table-name='${this.tableName}'] a[aria-current="page"]`).text(this.currentPageNumber);
    }

    fetchTableData(searchTerm = "") {
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
                    searchTerm: searchTerm
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
        this.fetchTableData(this.elements.searchInput.val());
    }
}

