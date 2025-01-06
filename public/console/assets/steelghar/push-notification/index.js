"use strict";
var KTDatatablesServerSide = (function () {
    var table;
    var dt;

    var initDatatable = function () {
        dt = $("#brandTable").DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            order: [[0, "desc"]],

            rowCallback: function (nRow, aData, iDisplayIndex) {
                var oSettings = this.fnSettings();
                $("td:first", nRow).html(
                    oSettings._iDisplayStart + iDisplayIndex + 1
                );
                return nRow;
            },
            ajax: {
                url: BASE_URL + "/push-notifications",
            },
            columns: [
                { data: "id" },
                { data: "title" },
                { data: "message" },
                { data: "count" },
                { data: "created_at" },
            ],

        });

        table = dt.$;

        dt.on("draw", function () {
            KTMenu.createInstances();
        });
    };

    var handleSearchDatatable = function () {
        const filterSearch = document.querySelector("[data-table-search]");
        filterSearch.addEventListener("keyup", function (e) {
            dt.search(e.target.value).draw();
        });
    };

    return {
        init: function () {
            initDatatable();
            handleSearchDatatable();
        },
    };
})();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatablesServerSide.init();
});
