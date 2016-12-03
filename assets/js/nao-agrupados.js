//var $jQuery = jQuery.noConflict();
$(function() {

	$('#nao-agrupados a').css('background-color', '#333').css('color', '#EBE9A6').css('text-decoration', 'none');

	$('#formColetaDados').bind('submit', function(event) {

		event.preventDefault();

		var dadosInseridos = $(this).serialize();

		$.ajax({

			type: 'POST',
			url: '/php/r-nao-agrupados.php',
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

					//console.log(resultado);
					$("#boxPopulacao").css('display', 'block');
					$("#tableFrequencia").css('display', 'block');
					$('#boxMessage').html('Dados inseridos com sucesso.').css('background-color', '#A4D899').css('color', '#125005').css('display', 'block');
					$('#sbmtDados').val('Atualizar');
					$('#txtaDadosDesordenados').val(resultado.dadosDesordenados);
					$('#txtaDadosOrdenados').val(resultado.dadosOrdenados);
					$('#somatorioFi').html('<strong>Somatório fi:</strong> ' + resultado.somatorioFi).css('display', 'block');
					
					if (resultado.variavel == 1) {
					
						$('#somatorioDados').html('<strong>Somatório dos dados:</strong> ' + resultado.somatorioDados).css('display', 'block');
						$('#media').html('<strong>Média:</strong> ' + resultado.media).css('display', 'block');
						$('#mediana').html('<strong>Mediana:</strong> ' + resultado.mediana).css('display', 'block');
						$('#moda').html('<strong>Moda:</strong> ' + resultado.moda).css('display', 'block');
						$('#variancia').html('<strong>Variância:</strong> ' + resultado.variancia).css('display', 'block');
						$('#varianciaRelativa').html('<strong>Variância Relativa:</strong> ' + resultado.varianciaRelativa).css('display', 'block');
						$('#desvioPadrao').html('<strong>Desvio Padrão:</strong> ' + resultado.desvioPadrao).css('display', 'block');
						$('#coeficienteVariacao').html('<strong>Coeficiente de Variação:</strong> ' + resultado.coeficienteVariacao + '%').css('display', 'block');
					
					} else {

						$('#somatorioDados').html('').css('display', 'none');
						$('#media').html('').css('display', 'none');
						$('#mediana').html('').css('display', 'none');
						$('#moda').html('').css('display', 'none');
						$('#variancia').html('').css('display', 'none');
						$('#varianciaRelativa').html('').css('display', 'none');
						$('#desvioPadrao').html('').css('display', 'none');
						$('#coeficienteVariacao').html('').css('display', 'none');

					}
					
					var tbody = '';

					$.each(resultado.fi, function(elemento, elementoFi) {

						tbody += '<tr>';
						tbody += '<td>' + elemento + '</td>';
						tbody += '<td>' + elementoFi + '</td>';
						tbody += '<td>' + resultado.fri[elemento] + '</td>';
						tbody += '<td>' + resultado.frip[elemento] + '%</td>';
						tbody += '<td>' + resultado.faci[elemento] + '</td>';
						tbody += '<td>' + resultado.fraci[elemento] + '</td>';
						tbody += '<td>' + resultado.fracip[elemento] + '%</td>';
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
		$('#somatorioDados').html('').css('display', 'none');
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
		$('#slctVariavel').val('0');
		$('#txtDados').val('').focus();

	});

});