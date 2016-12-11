<?php
//####################################################################################################//
// Recebe os dados do formulario
$dados = $_POST["txtDados"];
$dadosDesordenados = $_POST["txtaDadosDesordenados"];
$dadosOrdenados = $_POST["txtaDadosOrdenados"];
$casasDecimais = $_POST["nbrCasasDecimais"];
$variavel = $_POST["rdiVariavel"];

//####################################################################################################//
//Declarar o array que vai retornar como resultado
$resultado = array();

//####################################################################################################//
// Testa se foram enviados dados nesse momento e se já haviam sido enviados dados
if (!empty($dados) || ($dados == "0")) {

	$dadosDesordenados = (!empty($dadosDesordenados) || ($dadosDesordenados == "0")) ? $dadosDesordenados.", ".$dados : $dados;
	$dadosOrdenados = (!empty($dadosOrdenados) || ($dadosOrdenados == "0")) ? $dadosOrdenados.", ".$dados : $dados;

} elseif (empty($dadosOrdenados) || empty($dadosDesordenados)) {

	// Vai para o fim do script e retorna com erro
	$resultado["error"] = "Nenhum dado enviado";
	goto END;

}

//####################################################################################################//
// Explode os dados das strings para para um array $preRol e ordena os dados do array $rol
$preRol = explode(",", $dadosDesordenados);
$rol = array();

foreach ($preRol as $ordem => $elemento) {

	$rol[$ordem] = trim($elemento);

}

$dadosDesordenados = (count($rol) == 1) ? $rol[0] : implode(", ", $rol);
sort($rol);
$dadosOrdenados = (count($rol) == 1) ? $rol[0] : implode(", ", $rol);

//####################################################################################################//
// Frequencia simples de cada elelemento da populacao
$fi = array_count_values($rol);

//####################################################################################################//
// Tamanho da populacao
$somatorioFi = array_sum($fi);

//####################################################################################################//
// Começa a povoar um array para retornar os dados
$resultado["variavel"] = $variavel;
$resultado["dadosDesordenados"] = $dadosDesordenados;
$resultado["dadosOrdenados"] = $dadosOrdenados;
$resultado["somatorioFi"] = $somatorioFi;

//####################################################################################################//
// Caso a variavel escolhida tenha sido quantitativa são permitidos apenas numeros
if ($variavel == 1) {

	foreach ($rol as $elemento) {

		if (!is_numeric($elemento)) {

			// Vai para o fim do script e retorna com erro
			$resultado["error"] = "Tipo de variável incorreto";
			goto END;

		}

	}

} else {

	goto TABLE;

}

//####################################################################################################//
// Somatorio dos dados
$somatorioDados = array_sum($rol);

//####################################################################################################//
// Media
$media = round($somatorioDados / $somatorioFi, $casasDecimais);

//####################################################################################################//
// Mediana
if (($somatorioFi % 2) == 0) {

	$posicaoMediana = ($somatorioFi / 2) - 1;

} else {

	$posicaoMediana = (($somatorioFi + 1) / 2) - 1;

}

$mediana = $rol[$posicaoMediana];

//####################################################################################################//
// Moda
$fiMaior = max($fi);

$modaElementos = array();

foreach ($fi as $elemento => $elementoFi) {
	
	if ($elementoFi == $fiMaior) {

		$modaElementos[] = $elemento;

	}

}

$moda = (count($modaElementos) == 1) ? $modaElementos[0] : implode("; ", $modaElementos);

//####################################################################################################//
// Variancia
$somatorioXiMediaFi = 0;

foreach ($fi as $elemento => $elementoFi) {
	
	$numerador = (($elemento - $media) ** 2) * $elementoFi;
	$somatorioXiMediaFi += $numerador; 

}

$variancia = round($somatorioXiMediaFi / $somatorioFi, $casasDecimais);

//####################################################################################################//
// Variancia Relativa
$varianciaRelativa = ($media != 0) ? round($variancia / ($media ** 2), $casasDecimais) : 0;

//####################################################################################################//
// Desvio Padrao
$desvioPadrao = round(sqrt($variancia), $casasDecimais);

//####################################################################################################//

// Coeficiente de Variacao
$coeficienteVariacao = ($media != 0) ? round(($desvioPadrao / $media) * 100, $casasDecimais) : 0;

//####################################################################################################//
// Continua o povoando um array para retornar os dados
$resultado["somatorioDados"] = $somatorioDados;
$resultado["media"] = $media;
$resultado["mediana"] = $mediana;
$resultado["moda"] = $moda;
$resultado["variancia"] = $variancia;
$resultado["varianciaRelativa"] = $varianciaRelativa;
$resultado["desvioPadrao"] = $desvioPadrao;
$resultado["coeficienteVariacao"] = $coeficienteVariacao;


//####################################################################################################//
// Ponto para onde o programa deve prosseguir caso a variárel seja qualitativa
TABLE:

//####################################################################################################//
// Define as demais frequencias de cada elemento em arrays
$fri = array();
$frip = array();
$faci = array();
$fraci = array();
$fracip = array();

// Frequencia acumulada inicial
$somaFaci = 0;

foreach ($fi as $elemento => $elementoFi) {

	// Frequencia relativa
	$a = $elementoFi / $somatorioFi;
	$fri[$elemento] = round($a, $casasDecimais);
	
	// Frequencia relativa percentual
	$b = $a * 100;
	$frip[$elemento] = round($b, $casasDecimais);
	
	// Frequencia acumulada
	$somaFaci += $elementoFi;
	$faci[$elemento] = $somaFaci;
	
	// Frequencia relativa acumulada
	$a = $somaFaci / $somatorioFi;
	$fraci[$elemento] = round($a, $casasDecimais);
	
	// Frequencia relativa acumulada percentual
	$b = $a * 100;
	$fracip[$elemento] = round($b, $casasDecimais);

}

//####################################################################################################//
// Conclui o povoamento do array para retornar os dados
$resultado["fi"] = $fi;
$resultado["fri"] = $fri;
$resultado["frip"] = $frip;
$resultado["faci"] = $faci;
$resultado["fraci"] = $fraci;
$resultado["fracip"] = $fracip;

//####################################################################################################//
// Ponto para onde o programa deve prosseguir caso tenham ocorrido erros
END:

//####################################################################################################//
// Retorna os valores em formato json
echo json_encode($resultado);

?>