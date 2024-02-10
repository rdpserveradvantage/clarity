$(function () {
    $('.js-basic-example').DataTable({
        responsive: true
    });

    //Exportable table
    $('.js-exportable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    
    
    $('#myTable').dataTable( {
            'columnDefs': [
         {
            'targets': 0,
            'checkboxes': true
         }
      ],
      'order': [[1, 'asc']]
    } );
    
    $('.showfundtransfer').DataTable( {
        bPaginate:   false,
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        info: false
        
    } ); 
    
    
});