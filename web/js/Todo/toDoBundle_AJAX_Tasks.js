$(function(){
	function traitement_formulaire(e){
		var id = $("#sss_todobundle_tachetype_id").val();
		var urlTotale = 'http://localhost' +$('#addForm').attr('action');
		var url = urlTotale.replace("http://localhost/SSS/Tools/web/app_dev.php/ToDo/", "");
		if(id != null){
			urlTotale = urlTotale + '/'+ id;
		}

		window.console.log(url);
		$.post(url , getValueForm(), function(data){
			formulaireCallback();
		});

		e.preventDefault();
	}
	function getValueForm()
	{
		var title, resume, mainTask;
		title = $("#sss_todobundle_tachetype_titre").val();
		resume = $("#sss_todobundle_tachetype_description").val();
		mainTask = $("#sss_todobundle_tachetype_tachePrincipale").val();
		return {titre: title, description: resume, tachePrincipale: mainTask};
	}
	function formulaireCallback(){
		closeOverlay();
		getTasks();
	}
	function openOverlay(){
		$('#addOverlay').show();
		$('#add').hide();
	}
	function closeOverlay(){
		$('#addOverlay').hide();
		$('#add').show();
		clearValueInOverlay();
	}
	function clearValueInOverlay(){
		$('#sss_todobundle_tachetype_titre')
			.val("");
		$('#sss_todobundle_tachetype_description')
			.val("");
		$('#sss_todobundle_tachetype_id')
			.val("");
		$('#sss_todobundle_tachetype_tachePrincipale')
			.val("");
	}
	function putValueInOverlay(article){
		var text;
		text = article
				.children()
				.filter($('.task_title'))
				.html();
		$('#sss_todobundle_tachetype_titre')
			.val(text);
		text = article
				.children()
				.filter($('.task_description'))
				.html();
		$('#sss_todobundle_tachetype_description')
			.val(text);
		text = article
				.children()
				.filter($('.task_under'))
				.val();
		$('#sss_todobundle_tachetype_tachePrincipale')
			.val(text);
		text = article
				.attr('id');
		$('#sss_todobundle_tachetype_id')
			.val(text);

	}

	function getTasks(){
		$('#liste_tasks').load('http://localhost/SSS/Tools/web/app_dev.php/ToDo/getTasks');
		$('#task_loading').css('display', 'none');

	}
	$('#add').click(openOverlay);
	$('#close').click(closeOverlay);
	$('body').on('click', '.update', function(){
		openOverlay();
		putValueInOverlay($(this));
	});
	$('#addForm').submit(function(e){
		traitement_formulaire(e);
	});
	getTasks();
	setInterval(getTasks, 60000);
});
