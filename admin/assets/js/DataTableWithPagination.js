export class DataTableWithPagination {
    constructor (tableName, tableContainerSelector = '#displayClientApplicationTable') {
        this.currentPageNumber = 1;
        this.totalItems = 0;
        this.lastPageNumber = 0;
        this.itemsPerPage = 5;
        this.tableName = tableName;

        this.elements = {
            searchInput: $("#table-search"),
            tableContainer: $(tableContainerSelector),
            prevBtn: $("#prev"),
            nextBtn: $("#next"),
            startBtn: $("#start"),
            endBtn: $("#end"),
            itemsPerPageSelector: $('select[data-table-utilities="itemPerPage"]')
        };

        this.elements.prevBtn.on("click", () => {
            console.log("Prev button was clicked");
        });

        this.bindEvents();
        this.updateButtonsState();
        this.fetchTableData();
        this.handlePageChange('start');
    }

    bindEvents() {
        let debounceTimeout;
        this.elements.searchInput.on("keyup", () => {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => this.handleSearch(), 300);
        });

        // Bind pagination events
        this.elements.prevBtn.on("click", () => this.handlePageChange("prev"));
        this.elements.nextBtn.on("click", () => this.handlePageChange("next"));
        this.elements.startBtn.on("click", () => this.handlePageChange("start"));
        this.elements.endBtn.on("click", () => this.handlePageChange("end"));

        // Handle change of items per page
        this.elements.itemsPerPageSelector.change(() => {
            this.itemsPerPage = this.elements.itemsPerPageSelector.val();
            this.currentPageNumber = 1;
            this.fetchTableData(this.elements.searchInput.val());
        });
    }

    handleSearch() {
        this.currentPageNumber = 1;
        this.fetchTableData(this.elements.searchInput.val());
    }

    updateButtonsState() {
        this.elements.prevBtn.prop("disabled", this.currentPageNumber <= 1);
        this.elements.nextBtn.prop("disabled", this.currentPageNumber >= this.lastPageNumber);
        this.elements.startBtn.prop("disabled", this.currentPageNumber <= 1);
        this.elements.endBtn.prop("disabled", this.currentPageNumber >= this.lastPageNumber);
        $('a[aria-current="page"]').text(this.currentPageNumber);
    }

    fetchTableData(searchTerm = "") {
        $.ajax({
            url: "database_actions.php",
            type: 'post',
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
                this.updateButtonsState();
                this.elements.tableContainer.html(data);

                this.totalItems = parseInt($('#totalItemsHidden').val()) || 0;

                this.firstItem = $('input[data-hidden-name="start"]').val();
                this.lastItem = $('input[data-hidden-name="end"]').val();

                $('#first_item').text(this.firstItem);
                $('#last_item').text(this.lastItem);

                $('#totalItem').text(this.totalItems);

                this.lastPageNumber = Math.ceil(this.totalItems / this.itemsPerPage);

                this.elements.tableContainer.find("tbody tr").addClass("animate-fade-in");
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error("AJAX error:", textStatus, errorThrown);
            }
        });
    }

    handlePageChange(direction) {

        console.log("Inside handlePageChange method");
        console.log("Direction received:", direction);


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

        this.fetchTableData(this.elements.searchInput.val());
    }
}

