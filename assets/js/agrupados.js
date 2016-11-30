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
				$('#boxMessage').html('Erro no envio dos dados.').css('background-color', '#D3696C').css('display', 'block');
			},
			success: function(resultado) {
				//console.log(resultado);
				$('#boxMessage').html('Dados inseridos com sucesso.').css('background-color', '#A7BB89').css('display', 'block');
				$('#txtDados').val('');
				$('#sbmtDados').val('Atualizar');
				$('#txtaDadosDesordenados').val(resultado.dadosDesordenados);
				$('#txtaDadosOrdenados').val(resultado.dadosOrdenados);
				$('#populacaoTamanho').html('<strong>Tamanho:</strong> ' + resultado.populacaoTamanho);
				$('#populacaoAmplitudeAmostral').html('<strong>Amplitude Amostral:</strong> ' + resultado.populacaoAmplitudeAmostral);
				$('#elementoMenor').html('<strong>Menor elemento:</strong> ' + resultado.elementoMenor);
				$('#elementoMaior').html('<strong>Maior elemento:</strong> ' + resultado.elementoMaior);
				$('#populacaoNumeroClasses').html('<strong>Numero de Classes:</strong> ' + resultado.populacaoNumeroClasses);
				$('#populacaoAmplitudeIntervaloClasse').html('<strong>Amplitude do Intervalo de Classe:</strong> ' + resultado.populacaoAmplitudeIntervaloClasse);
				$('#populacaoMedia').html('<strong>Média:</strong> ' + resultado.populacaoMedia);
				$('#populacaoMediana').html('<strong>Mediana:</strong> ' + resultado.populacaoMediana);
				//$('#populacaoModa').html('<strong>Moda:</strong> ' + resultado.populacaoModa);
				//$('#populacaoVariancia').html('<strong>Variância:</strong> ' + resultado.populacaoVariancia);
				//$('#populacaoVarianciaRelativa').html('<strong>Variância Relativa:</strong> ' + resultado.populacaoVarianciaRelativa);
				//$('#populacaoDesvioPadrao').html('<strong>Desvio Padrão:</strong> ' + resultado.populacaoDesvioPadrao);
				//$('#populacaoCoeficienteVariacao').html('<strong>Coeficiente de Variação:</strong> ' + resultado.populacaoCoeficienteVariacao + '%');
				
				var tbody = '';

				$.each(resultado.arrayClasses, function(elemento, elementoClasse) {

					tbody += '<tr>';
					tbody += '<td>' + elemento + '</td>';
					tbody += '<td>' + elementoClasse + '</td>';
					tbody += '<td>' + resultado.arrayXi[elemento] + '</td>';
					tbody += '<td>' + resultado.arrayFi[elemento] + '</td>';
					tbody += '<td>' + resultado.arrayXiFi[elemento] + '</td>';
					tbody += '<td>' + resultado.arrayFri[elemento] + '</td>';
					tbody += '<td>' + resultado.arrayFrip[elemento] + '</td>';
					tbody += '<td>' + resultado.arrayFaci[elemento] + '</td>';
					tbody += '<td>' + resultado.arrayFraci[elemento] + '</td>';
					tbody += '<td>' + resultado.arrayFracip[elemento] + '</td>';
					tbody += '</tr>';

				});

				$("#tableFrequencia tbody").html(tbody);

			}

		});

	});

});