//var $jQuery = jQuery.noConflict(); 
$(function() {

	$('#agrupados a').css('background-color', '#333').css('color', '#EBE9A6').css('text-decoration', 'none');

	$('#formColetaDados').bind('submit', function(event) {

		event.preventDefault();

		var dadosInseridos = $(this).serialize();

		$.ajax({

			type: 'POST',
			url: '/php/r-agrupados.php',
			data: dadosInseridos,
			dataType: 'json',
			beforeSend: function() {
		    	$('#boxMessage').html('Carregando...');
	    	},
	    	error: function() {
				$('#boxMessage').html('Erro no envio dos dados.').css('background-color', '#FFAAAA').css('color', '#550000').css('display', 'block');
			},
			success: function(resultado) {

				if (resultado.error === undefined) {

					$("#boxPopulacao").css('display', 'block');
					$("#tableFrequencia").css('display', 'block');
					$('#boxMessage').html('Dados inseridos com sucesso.').css('background-color', '#A4D899').css('color', '#125005').css('display', 'block');
					$('#sbmtDados').val('Atualizar');
					$('#txtaDadosDesordenados').val(resultado.dadosDesordenados);
					$('#txtaDadosOrdenados').val(resultado.dadosOrdenados);
					$('#somatorioFi').html('<strong>Tamanho:</strong> ' + resultado.somatorioFi).css('display', 'block');
					$('#amplitudeAmostral').html('<strong>Amplitude Amostral:</strong> ' + resultado.amplitudeAmostral).css('display', 'block');
					$('#elementoMenor').html('<strong>Menor elemento:</strong> ' + resultado.elementoMenor).css('display', 'block');
					$('#elementoMaior').html('<strong>Maior elemento:</strong> ' + resultado.elementoMaior).css('display', 'block');
					$('#numeroClasses').html('<strong>Numero de Classes:</strong> ' + resultado.numeroClasses).css('display', 'block');
					$('#amplitudeIntervaloClasse').html('<strong>Amplitude do Intervalo de Classe:</strong> ' + resultado.amplitudeIntervaloClasse).css('display', 'block');
					$('#media').html('<strong>Média:</strong> ' + resultado.media).css('display', 'block');
					$('#mediana').html('<strong>Mediana:</strong> ' + resultado.mediana).css('display', 'block');
					$('#moda').html('<strong>Moda:</strong> ' + resultado.moda).css('display', 'block');
					$('#variancia').html('<strong>Variância:</strong> ' + resultado.variancia).css('display', 'block');
					$('#varianciaRelativa').html('<strong>Variância Relativa:</strong> ' + resultado.varianciaRelativa).css('display', 'block');
					$('#desvioPadrao').html('<strong>Desvio Padrão:</strong> ' + resultado.desvioPadrao).css('display', 'block');
					$('#coeficienteVariacao').html('<strong>Coeficiente de Variação:</strong> ' + resultado.coeficienteVariacao + '%').css('display', 'block');

					var tbody = '';

					$.each(resultado.classes, function(elemento, elementoClasse) {

						tbody += '<tr>';
						tbody += '<td>' + elemento + '</td>';
						tbody += '<td>' + elementoClasse + '</td>';
						tbody += '<td>' + resultado.fi[elemento] + '</td>';
						tbody += '<td>' + resultado.xi[elemento] + '</td>';
						tbody += '<td>' + resultado.xiFi[elemento] + '</td>';
						tbody += '<td>' + resultado.xXi2Fi[elemento] + '</td>';
						tbody += '<td>' + resultado.fri[elemento] + '</td>';
						tbody += '<td>' + resultado.frip[elemento] + '</td>';
						tbody += '<td>' + resultado.faci[elemento] + '</td>';
						tbody += '<td>' + resultado.fraci[elemento] + '</td>';
						tbody += '<td>' + resultado.fracip[elemento] + '</td>';
						tbody += '</tr>';

					});

					$("#tableFrequencia tbody").html(tbody);

				} else {

					$('#boxMessage').html(resultado.error).css('background-color', '#FFAAAA').css('color', '#550000').css('display', 'block');

				}

				$('#txtDados').val('').focus();

			}

		});

	});

	$('#formColetaDados').bind('reset', function(event) {

		event.preventDefault();

		$("#tableFrequencia tbody").html('');
		$('#somatorioFi').html('').css('display', 'none');
		$('#amplitudeAmostral').html('').css('display', 'none');
		$('#elementoMenor').html('').css('display', 'none');
		$('#elementoMaior').html('').css('display', 'none');
		$('#numeroClasses').html('').css('display', 'none');
		$('#amplitudeIntervaloClasse').html('').css('display', 'none');
		$('#media').html('').css('display', 'none');
		$('#mediana').html('').css('display', 'none');
		$('#moda').html('').css('display', 'none');
		$('#variancia').html('').css('display', 'none');
		$('#varianciaRelativa').html('').css('display', 'none');
		$('#desvioPadrao').html('').css('display', 'none');
		$('#coeficienteVariacao').html('').css('display', 'none');
		$("#boxMessage").css('display', 'none');
		$("#boxPopulacao").css('display', 'none');
		$("#tableFrequencia").css('display', 'none');
		$('#sbmtDados').val('Inserir');
		$('#txtaDadosDesordenados').val('');
		$('#txtaDadosOrdenados').val('');
		$('#nbrCasasDecimais').val('2');
		$('#nbrFatorAjuste').val('0');
		$('#txtDados').val('').focus();

	});

});