$(document).ready (function()
{
    $('table').dataTable
    ({   

        "bAutoWidth": false,
        "bSort" : false,
        "oLanguage": {
                "sUrl": "scripts/dataTables_french.txt"
            }

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