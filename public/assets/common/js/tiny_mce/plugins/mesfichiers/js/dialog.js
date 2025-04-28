
tinyMCEPopup.requireLangPack();

var MesfichiersDialog = {
	init : function() {
	},
	

	insert : function() 
	{

//var URL = document.getElementById('someval').value;
for (i=0; i<document.formulaire.someval.length; i++) 
{
 if(document.formulaire.someval[i].checked)
 {
  var URL = document.formulaire.someval[i].value;
 }
}//Fin de récupération de la donnée
        var win = tinyMCEPopup.getWindowArg("window");


        win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = URL;

        // are we an image browser
        if (typeof(win.ImageDialog) != "undefined") 
		{

            // we are, so update image dimensions and preview if necessary
            if (win.ImageDialog.getImageData) win.ImageDialog.getImageData();
            if (win.ImageDialog.showPreviewImage) win.ImageDialog.showPreviewImage(URL);

        }




	tinyMCEPopup.close();
}


};

tinyMCEPopup.onInit.add(MesfichiersDialog.init, MesfichiersDialog);






