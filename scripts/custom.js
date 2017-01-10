 /* Validação de Formularios */
 $(".form-validate").validate({
 	rules: {
 		carga_horaria: {
 			number: true
 		}, 
 		capacidade: {
 			number: true,
 			horariosAula: true

 		}
 	},
 	errorPlacement: function(error, element){
 		if (element.attr("name") == "cursos[]"){
 			error.appendTo('.cursos-group');
 		} else {
			error.insertAfter( element ); // standard behaviour
		}
 	},
 	messages: {
 		'cursos[]': {
 			required: "Selecione pelo menos 1 curso"
 		}
 	}
 });

/* Abrir Modal */
 function abrirModal(modalId){
 	$(modalId).modal('show');
 }

 $(function() {
 	//Horarios Disponíveis - Adicionar/Editar Sala
	function trocarStatusHorarioSala(){
 		$(this).toggleClass("disponivel").toggleClass("indisponivel");
 		if($(this).find("input").val() == 0) $(this).find("input").val("1");
 		else if($(this).find("input").val() == 1) $(this).find("input").val("0");
 		return false;
 	}

	$("#tabela-horarios-disponiveis-sala tbody tr td").bind("mousedown", function(){
 		$("#tabela-horarios-disponiveis-sala tbody tr td").bind("mouseenter", trocarStatusHorarioSala);
	});

 	$("*").on("mouseup", function(){
 		$("#tabela-horarios-disponiveis-sala tbody tr td").unbind("mouseenter", trocarStatusHorarioSala);
 	});
 	
 	$("#tabela-horarios-disponiveis-sala tbody tr td").bind("mousedown", trocarStatusHorarioSala);

 	//Horarios  - Adicionar/Editar Aula	
 	$("#tabela-horarios-aula tbody tr").on("contextmenu", "td.disponivel", function(event) {
 		_tempos = parseInt($("#aulaTempos").val());
		_tempoCorrente = $(this).parent().index();
 		_diaCorrente = $(this).index();

 		var i = 1;
		for(i=0; i<_tempos; i++){
 			_elem = $("#tabela-horarios-aula tbody tr").eq(_tempoCorrente - i).find("td").eq(_diaCorrente);
 			if(_elem.length){
 				if(_elem.find("input").val() == "1"){
 					_elem.find("input").val("0");
 					break;
 				}
 			}else{
 				break;
 			}
		}
		i = _tempoCorrente - i;


		for(j=0; j<_tempos; j++){
 			_elem = $("#tabela-horarios-aula tbody tr").eq(i + j).find("td").eq(_diaCorrente);
 			if(_elem.length){
 				if(_elem.hasClass('disponivel')){
 					_elem.toggleClass('disponivel').toggleClass('indisponivel');
 				}else{
 					break;
 				}
 			}else{
 				break;
 			}
		}

 		return false;
 	});

 	$("#tabela-horarios-aula tbody tr").on("contextmenu", "td.indisponivel", function(event) {
 		return false;
 	});
 	$("#tabela-horarios-aula").on("contextmenu", ".inselecionavel", function(event) {
 		return false;
 	});

 	$("#tabela-horarios-aula tbody tr td").bind("click", function(){
 		if($(this).hasClass('inselecionavel')) return false;

 		_conflito = 0;

 		_tempos = parseInt($("#aulaTempos").val());
 		_temposTotais = 18;

 		_tempoCorrente = $(this).parent().index() + 1;
 		_diaCorrente = $(this).index();

 		_excesso = _tempoCorrente + _tempos - (_temposTotais + 1);
 		if (_excesso < 0) _excesso = 0;

 		_foraExcesso = _tempos - _excesso;

 		//Verificando conflito
 		for(i=0; i<_foraExcesso; i++){
 			_elem = $("#tabela-horarios-aula tbody tr").eq($(this).parent().index() + i).find("td").eq(_diaCorrente);
 			_conflito += _elem.hasClass('disponivel');
		}

		for(i=1; i<=_excesso; i++){
			_conflito += _elem.hasClass('disponivel');
		}

		if(_conflito == 0){
			$("#tabela-horarios-aula tbody tr td.hover").toggleClass("hover");

			_primeiro = 1;

			for(i=_excesso; i>=1; i--){
				_elem = $("#tabela-horarios-aula tbody tr").eq($(this).parent().index() - i).find("td").eq(_diaCorrente);
	 			_elem.toggleClass("disponivel").toggleClass("indisponivel");
		 		
		 		if(_primeiro){
			 		_elem.find("input").val("1");
			 		_primeiro = 0;
			 	}
			}

	 		for(i=0; i<_foraExcesso; i++){
	 			_elem = $("#tabela-horarios-aula tbody tr").eq($(this).parent().index() + i).find("td").eq(_diaCorrente);
	 			_elem.toggleClass("disponivel").toggleClass("indisponivel");

	 			if(_primeiro){
			 		_elem.find("input").val("1");
			 		_primeiro = 0;
			 	}
			}
		}else{
			_msg = "";
			if(_conflito == 1)
				_msg  = "Um dos tempos já está selecionado. Houve um conflito.";
			else 
				_msg  =  _conflito + " dos tempos já estão selecionados. Houve um conflito.";

			$("#modal-aula-conflito .modal-body").html(_msg);
			abrirModal('#modal-aula-conflito');
		}

		$(this).trigger("mouseover");

		return false;

 	});

 	$("#aulaTempos").bind("change", function(){
 		$("#tabela-horarios-aula tbody tr td.disponivel").toggleClass("disponivel").toggleClass("indisponivel");
 		$("#tabela-horarios-aula tbody tr td input").val("0");
 	});

 	$("#tabela-horarios-aula tbody tr td").bind("mouseover", function(){
 		_tempos = parseInt($("#aulaTempos").val());
 		_temposTotais = 18;

 		_tempoCorrente = $(this).parent().index() + 1;
 		_diaCorrente = $(this).index();

 		_excesso = _tempoCorrente + _tempos - (_temposTotais + 1);
 		if (_excesso < 0) _excesso = 0;

 		_foraExcesso = _tempos - _excesso;

 		for(i=0; i<_foraExcesso; i++){
			$("#tabela-horarios-aula tbody tr").eq($(this).parent().index() + i).find("td").eq(_diaCorrente).toggleClass("hover");
		}

		for(i=1; i<=_excesso; i++){
			$("#tabela-horarios-aula tbody tr").eq($(this).parent().index() - i).find("td").eq(_diaCorrente).toggleClass("hover");
		}
 	});

 	$("#tabela-horarios-aula tbody tr td").bind("mouseout", function(){
		$("#tabela-horarios-aula tbody tr td.hover").toggleClass("hover");
 	});

 	/* Verificação de aulas sem horários selecionados */
 	$(".btn-salvar").bind("click", function(){
 		_retorno = false;

 		if($("#tabela-horarios-aula").length == 0) 
 			_retorno = true;
 		else{
 			if($("#tabela-horarios-aula input[value='1']").length == 0) 
 				_retorno = false;
 			else
 				_retorno = true;
 		}

 		if (!_retorno){
 			if($("#modal-editar-aula").length > 0){
 				$("#modal-editar-aula").removeClass("fade");
 				$("#modal-editar-aula").modal("hide");
 			}
 			abrirModal("#modal-aula-vazio");
 			return false;
 		}else{
 			return true;
 		}
 	});

 	/* Ajax - Agregar Aulas */
 	$("#departarmento_ajax").bind("change", function(){
 		_departamento = $(this).val();
 		if(_departamento != ""){
		 	$.post('../../../ajax/agregar.php', {idDepartamento: _departamento, acao: "departamento"}, function(data) {
				$("#disciplina_ajax").html(data);
			});
		}else{
			$("#disciplina_ajax").html('<option value="">Selecione um Departamento</option>');
		}
		$("#turma_ajax").html('<option value="">Selecione uma Disciplina</option>');
		$("#aula_ajax").html('<option value="">Selecione uma Turma</option>');
		$("#idAgregacao").val("");
		$("#agregar-informacoes").hide();
 	});

 	$("#disciplina_ajax").bind("change", function(){
 		_disciplina = $(this).val();
 		if(_disciplina != ""){
		 	$.post('../../../ajax/agregar.php', {idDisciplina: _disciplina, acao: "disciplina"}, function(data) {
				$("#turma_ajax").html(data);
			});
		}else{
			$("#turma_ajax").html('<option value="">Selecione uma Disciplina</option>');
		}
		$("#aula_ajax").html('<option value="">Selecione uma Turma</option>');
		$("#idAgregacao").val("");
		$("#agregar-informacoes").hide();
 	});

 	$("#turma_ajax").bind("change", function(){
 		_turma = $(this).val();
 		if(_turma != ""){
		 	$.post('../../../ajax/agregar.php', {idTurma: _turma, acao: "turma"}, function(data) {
				$("#aula_ajax").html(data);
			});
		}else{
			$("#aula_ajax").html('<option value="">Selecione uma Turma</option>');
		}
		$("#idAgregacao").val("");
		$("#agregar-informacoes").hide();
 	});

 	$("#aula_ajax").bind("change", function(){
 		_aula= $(this).val();
 		if(_aula != ""){
 			$("#agregar-informacoes").show();
		 	$.post('../../../ajax/agregar.php', {idAula: _aula, acao: "aula"}, function(data) {
				dados = data.split("|||");

				$("#agregar-informacoes #tabela-agregacao-recursos-detalhes tbody").html(dados[1]);
				
				tempos = $.parseJSON(dados[2]);

				var dias = ["SEG", "TER", "QUA", "QUI", "SEX", "SAB", "DOM"];
				var horarios = ["M", "T", "N"];

				for(var i = 0; i<7; i++){
					for(var j = 0; j<3; j++){
						for(var k = 1; k<=6;k++){
							if(tempos[dias[i]][horarios[j] + k] == 1){
								$("#tabela-horarios-aula-detalhes tbody tr").eq(6*j + k - 1).find("td").eq(i+1).removeClass("indisponivel").addClass("disponivel");
							}else{
								$("#tabela-horarios-aula-detalhes tbody tr").eq(6*j + k - 1).find("td").eq(i+1).removeClass("disponivel").addClass("indisponivel");
							}
						}
					}
				}

				agregacoes = $.parseJSON(dados[3]);

				_informacoes = "<b>Tempos de Aula:</b> " + dados[4];
				_informacoes += '<div class="page-header"><h4>Turmas Agregadas</h4></div>';
				
				$.each(agregacoes, function(key, value) {
					_informacoes += "<b>Disciplina:</b> " + value["disciplina"] + "<br>";
					_informacoes += "<b>Turma:</b> " + value["turma"] + "<br>";
					_informacoes += "<b>Aula:</b> " + value["descricao"] + "<br><br>";
				});

				$("#agregar-informacoes div#info").html(_informacoes);

				$("#idAgregacao").val(dados[0]);

			});
		}else{
			$("#agregar-informacoes").hide();
		}
 	});

 });