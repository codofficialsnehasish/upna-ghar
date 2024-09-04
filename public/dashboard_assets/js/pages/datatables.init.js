$(document).ready(function(){
    $("#datatable").DataTable(),
    $("#datatable-buttons").DataTable({
        lengthChange:!1,
        buttons:["copy","excel","pdf","colvis"]
    }).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"),
    $(".dataTables_length select").addClass("form-select form-select-sm")



    $("#datatable-search").DataTable({
        initComplete: function () {
            this.api()
                .columns()
                .every(function (index) {

                    if (index !== 1) { return; }

                    let column = this;
                    let select = document.createElement('select');
                    select.add(new Option(''));
                    column.header().replaceChildren(select);
                    select.addEventListener('change', function () {
                        column
                            .search(select.value, {exact: true})
                            .draw();
                    });
        
                    column
                        .data()
                        .unique()
                        .sort()
                        .each(function (d, j) {    
                            select.add(new Option(d));
                        });
                });
        }
    });
});