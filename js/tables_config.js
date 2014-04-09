$(document).ready (function()
{
    $('table').dataTable
    ({   

        "bAutoWidth": false,
        "sSortAscending": true,
        "oLanguage": 
        {
            "sProcessing":     "Traitement en cours...",
            "sSearch":         "Rechercher&nbsp;:",
            "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
            "sInfo":           "_START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            "sInfoEmpty":      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoPostFix":    "",
            "sLoadingRecords": "Chargement en cours...",
            "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
            "sEmptyTable":     "Aucune donnée disponible dans le tableau",
            "oPaginate": {
                "sFirst":      "Premier",
                "sPrevious":   "Pr&eacute;c&eacute;dent",
                "sNext":       "Suivant",
                "sLast":       "Dernier"
            },
            "oAria": {
                "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
            }
        },
        "aoColumnDefs": [
          { 'bSortable': false, 'aTargets': [ 0 ] }
       ],
        "sScrollY": "500px",
        "bPaginate": false,
        "bScrollCollapse": true,
        "bInfo": false

    });

    $('input#select_tout').on('click',selectTout);
    $('input.select').on('click',select);
    var nb_etudiant = 100;
});

function selectTout()
{
    if($('input#select_tout').attr('checked'))
    {
            $('td > input[type="checkbox"]').attr('checked', true);
            nb_etudiant=100;
            MajNbEtudiant();
    }
    else
    {
        $('td > input[type="checkbox"]').attr('checked', false);
        nb_etudiant=0;
        MajNbEtudiant();
    }
    
}

function select()
{
    if(!this.checked)
    {
        $('input#select_tout').attr('checked', false);
        nb_etudiant--;
    }
    else
    {
        nb_etudiant++;
    }
    MajNbEtudiant();
}

function MajNbEtudiant()
{
    if(nb_etudiant==100)
        $('#nb').html("Tous les étudiants sont sélectionnés");
    else
        $('#nb').html(nb_etudiant+" étudiant(s) sélectionnés");
}
