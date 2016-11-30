//var $jQuery = jQuery.noConflict(); 
$(function() {

	$('#nao-agrupados a').css('background-color', '#333').css('color', '#EBE9A6').css('text-decoration', 'none');

	/*$('#formColetaDados').bind('submit', function(event) {

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
					$('#boxMessage').html('Dados inseridos com sucesso.').css('background-color', '#A4D899').css('color', '#125005').css('display', 'block');
					$('#sbmtDados').val('Atualizar');
					$('#txtaDadosDesordenados').val(resultado.dadosDesordenados);
					$('#txtaDadosOrdenados').val(resultado.dadosOrdenados);
					$('#populacaoTamanho').html('<strong>Tamanho:</strong> ' + resultado.populacaoTamanho);
					$('#populacaoMedia').html('<strong>Média:</strong> ' + resultado.populacaoMedia);
					$('#populacaoMediana').html('<strong>Mediana:</strong> ' + resultado.populacaoMediana);
					$('#populacaoModa').html('<strong>Moda:</strong> ' + resultado.populacaoModa);
					$('#populacaoVariancia').html('<strong>Variância:</strong> ' + resultado.populacaoVariancia);
					$('#populacaoVarianciaRelativa').html('<strong>Variância Relativa:</strong> ' + resultado.populacaoVarianciaRelativa);
					$('#populacaoDesvioPadrao').html('<strong>Desvio Padrão:</strong> ' + resultado.populacaoDesvioPadrao);
					$('#populacaoCoeficienteVariacao').html('<strong>Coeficiente de Variação:</strong> ' + resultado.populacaoCoeficienteVariacao + '%');
					
					var tbody = ''

					$.each(resultado.arrayFi, function(elemento, elementoFi) {

						tbody += '<tr>';
						tbody += '<td>' + elemento + '</td>';
						tbody += '<td>' + elementoFi + '</td>';
						tbody += '<td>' + resultado.arrayFri[elemento] + '</td>';
						tbody += '<td>' + resultado.arrayFrip[elemento] + '</td>';
						tbody += '<td>' + resultado.arrayFaci[elemento] + '</td>';
						tbody += '<td>' + resultado.arrayFraci[elemento] + '</td>';
						tbody += '<td>' + resultado.arrayFracip[elemento] + '</td>';
						tbody += '</tr>';

					});

					$("#tableFrequencia tbody").html(tbody);

				} else {

					$('#boxMessage').html(resultado.error).css('background-color', '#FFAAAA').css('color', '#550000').css('display', 'block');

				}

				$('#txtDados').val('').focus();

			}

		});

	});*/

});