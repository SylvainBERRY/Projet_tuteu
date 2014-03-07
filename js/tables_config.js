$(document).ready (function()
{
    $('table').dataTable
    ({   

        "bAutoWidth": false,
        "sSortAscending": true,
        "oLanguage": {
                "sUrl": "../../js/dataTables_french.txt"
            },
        "aoColumnDefs": [
          { 'bSortable': false, 'aTargets': [ 0 ] }
       ],
        "sScrollY": "300px",
        "bPaginate": false,
        "bScrollCollapse": true

    });

    $('input#select_tout').on('click',selectTout);

});

function selectTout()
{
    if($('input#select_tout').attr('checked'))
        $('td > input[type="checkbox"]').attr('checked', true);
    else
        $('td > input[type="checkbox"]').attr('checked', false);

}