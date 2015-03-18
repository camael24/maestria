//ouverture sous parties pages items pedas et classes
$('body').on('click','ul li', function(){
//petit coup d'ajax pour générer sous parties
$(this).next('ul').slideToggle();
});



//Génération du pop-up: choix évaluation
$('#evalchx').on('click', function(){
	var liste="";
		for(var i in evals){
			liste+='<h6 data-ideval="'+i+'">'+evals[i]['nom']+'</h6>';
		}
	genererpopup("eval","CHOIX DE L'EVALUATION",'evalchx">',liste);
});

//Au click dans le pop-up choix de l'évaluation
$('#popup').on('click','.evalchx h6', function(){
	IDeval=$(this).data('ideval');
	$('#evalchx').html($(this).html());
//changer l'information évaluation remplie ou pas	
	$('#popup').slideToggle();
});




//Génération du pop-up: choix classe
$('.classe').on('click', function(){
	liste="";
		for(var i in classes){
			liste+='<h6 data-idclasse="'+i+'">'+classes[i]['nom']+'</h6>';
		}
	genererpopup("classe","CHOIX DE LA CLASSE",'classechx">',liste);
});
//Au click dans le pop-up choix classe
$('#popup').on('click','.classechx h6', function(){
	IDclasse=$(this).data('idclasse');
	
	$('#titre .classe').html($(this).html());
	$('#cases').empty();
	if($('#corps').hasClass('evaluer')){gen_case_eleves(IDclasse);}
	
//changer l'information évaluation remplie ou pas	
	$('#popup').slideToggle();
});







//ferme les fenètre pop-up en cas d'erreur de clic
$('#popup').on('click',' .exit', function(){
	$('#popup').slideToggle();
});