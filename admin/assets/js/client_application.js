class DataTableWithPagination {
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

        this.bindEvents();
        this.updateButtonsState();
        this.fetchTableData();
        this.initializeTotalItems();
    }

    bindEvents() {
        this.elements.searchInput.on("keyup", () => this.handleSearch());

        // Bind pagination events
        this.elements.prevBtn.on("click", () => this.handlePageChange("prev"));
        this.elements.nextBtn.on("click", () => this.handlePageChange("next"));
        this.elements.startBtn.on("click", () => this.handlePageChange("start"));
        this.elements.endBtn.on("click", () => this.handlePageChange("end"));

        // Handle change of items per page
        this.elements.itemsPerPageSelector.change(() => {
            this.itemsPerPage = this.elements.itemsPerPageSelector.val();
            this.currentPageNumber = 1;
            this.fetchTableData();
            this.initializeTotalItems();
        });
    }

    handleSearch() {
        // Reset to the first page and fetch the table data when a search occurs
        this.currentPageNumber = 1;
        this.fetchTableData();
        this.initializeTotalItems();
    }

    updateButtonsState() {
        this.elements.prevBtn.prop("disabled", this.currentPageNumber <= 1);
        this.elements.nextBtn.prop("disabled", this.currentPageNumber >= this.lastPageNumber);
        this.elements.startBtn.prop("disabled", this.currentPageNumber <= 1);
        this.elements.endBtn.prop("disabled", this.currentPageNumber >= this.lastPageNumber);
        $('a[aria-current="page"]').text(this.currentPageNumber);
    }

    fetchTableData() {
        const itemsPerPage = this.elements.itemsPerPageSelector.val();
        const searchTerm = this.elements.searchInput.val();

        $.ajax({
            url: "database_actions.php",
            type: 'post',
            data: {
                action: "getDataTable",
                tableName: this.tableName,
                dataTableParam: {
                    pageNumber: this.currentPageNumber,
                    itemPerPage: itemsPerPage,
                    searchTerm: searchTerm
                }
            },
            success: (data, status) => {
                this.elements.tableContainer.html(data);

                // Add animation to each row excluding the header
                this.elements.tableContainer.find("tbody tr").addClass("animate-fade-in");

                const first_item = $('input[data-hidden-name="start"]').val();
                const last_item = $('input[data-hidden-name="end"]').val();
                $('#first_item').text(first_item);
                $('#last_item').text(last_item);
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error("AJAX error:", textStatus, errorThrown);
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

        this.fetchTableData();
        this.updateButtonsState();
    }

    initializeTotalItems() {
        // Fetch the total number of items from the server
        $.ajax({
            url: "database_actions.php",
            type: "POST",
            data: {
                action: "getTotalItem",
                tableName: this.tableName
            },
            success: (data) => {
                this.totalItems = JSON.parse(data).totalItem;
                $('#totalItem').text(this.totalItems);
                this.lastPageNumber = Math.ceil(this.totalItems / this.itemsPerPage);
                this.updateButtonsState();
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error("AJAX error:", textStatus, errorThrown);
            }
        });
    }
}


// Instantiate the DataTableWithPagination class
const clientAppTable = new DataTableWithPagination("client_application");
const clientTable = new DataTableWithPagination("client_data", '#displayClientDataTable');

