var max_img_size=2097152;

function verifierTaille()
{
    var input = document.getElementById('excel_mails');

    if(input.files && input.files.length == 1)
    {           
        if (input.files[0].size > max_img_size) 
        {
            alert("Le fichier Excel Mails est plus grand que " + (max_img_size/1024/1024) + "MB");
            return false;
        }
        if(input.files[0].size == 0 ) 
        {
            alert("Le fichier Excel Mails est vide !");
            return false;
        }
    }

    return true;
}

function verifierForm()
{
    return verifierTaille();
}