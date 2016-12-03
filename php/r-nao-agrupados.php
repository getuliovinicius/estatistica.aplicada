<?php
//********************************************************//

// Recebe os dados do formulario
$dados = $_POST["txtDados"];
$dadosDesordenados = $_POST["txtaDadosDesordenados"];
$dadosOrdenados = $_POST["txtaDadosOrdenados"];
$casasDecimais = $_POST["nbrCasasDecimais"];
$variavel = $_POST["slctVariavel"];

//********************************************************//

// Testa se foram enviados dados nesse momento e se já haviam sido enviados dados
if (!empty($dados)) {

	$dadosDesordenados = (empty($dadosDesordenados)) ? $dados : $dadosDesordenados.", ".$dados;
	$dadosOrdenados = (empty($dadosOrdenados)) ? $dados : $dadosOrdenados.", ".$dados;

} elseif (empty($dadosOrdenados) || empty($dadosDesordenados)) {
	
	// Vai para o fim do script e retorna com erro
	$resultado = array("error" => "Nenhum dado enviado");
	goto END;

}

//********************************************************//

// Explode os dados das strings para para um array $preRol e ordena os dados do array $rol
$preRol = explode(",", $dadosDesordenados);
$rol = array();

foreach ($preRol as $ordem => $elemento) {

	$rol[$ordem] = trim($elemento);

}

$dadosDesordenados = (count($rol) == 1) ? $rol[0] : implode(", ", $rol);

sort($rol);

$dadosOrdenados = (count($rol) == 1) ? $rol[0] : implode(", ", $rol);

//********************************************************//

// Frequencia simples de cada elelemento da populacao
$fi = array_count_values($rol);

//********************************************************//

// Tamanho da populacao
$somatorioFi = array_sum($fi);

//********************************************************//

// Soma dos valores da populacao
if ($variavel == 1) {

	$somatorioDados = array_sum($rol);

} elseif ($variavel == 2) {

	$somatorioDados = array_sum($fi);

} else {

	// Vai para o fim do script e retorna com erro
	$resultado = array("error" => "Tipo de variável não informado.");
	goto END;

}

if ($somatorioDados == 0) {

	// Vai para o fim do script e retorna com erro
	$resultado = array("error" => "Tipo de variável incorreto.");
	goto END;

}

//********************************************************//

// Media
$media = round($somatorioDados / $somatorioFi, $casasDecimais);

//********************************************************//

// Mediana
if (($somatorioFi % 2) == 0) {

	$posicaoMediana = ($somatorioFi / 2) - 1;

} else {

	$posicaoMediana = (($somatorioFi + 1) / 2) - 1;

}

$mediana = $rol[$posicaoMediana];

//********************************************************//

// Moda
$fiMaior = max($fi);

$modaElementos = array();

foreach ($fi as $elemento => $elementoFi) {
	
	if ($elementoFi == $fiMaior) {

		$modaElementos[] = $elemento;

	}

}

$moda = (count($modaElementos) == 1) ? $modaElementos[0] : implode("; ", $modaElementos);

//********************************************************//

// Variancia
$somatorioXiMediaFi = 0;

foreach ($fi as $elemento => $elementoFi) {
	
	$numerador = (($elemento - $media) ** 2) * $elementoFi;
	$somatorioXiMediaFi += $numerador; 

}

$variancia = round($somatorioXiMediaFi / $somatorioFi, $casasDecimais);

//********************************************************//

// Variancia Relativa
$varianciaRelativa = round($variancia / ($media ** 2), $casasDecimais);

//********************************************************//

// Desvio Padrao
$desvioPadrao = round(sqrt($variancia), $casasDecimais);

//********************************************************//

// Coeficiente de Variacao
$coeficienteVariacao = round(($desvioPadrao / $media) * 100, $casasDecimais);

//********************************************************//

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

//********************************************************//

// Monta um array para retornar os valores
$resultado = array(
	"variavel" => $variavel,
	"dadosDesordenados" => $dadosDesordenados,
	"dadosOrdenados" => $dadosOrdenados,
	"somatorioFi" => $somatorioFi,
	"somatorioDados" => $somatorioDados,
	"media" => $media,
	"mediana" => $mediana,
	"moda" => $moda,
	"variancia" => $variancia,
	"varianciaRelativa" => $varianciaRelativa,
	"desvioPadrao" => $desvioPadrao,
	"coeficienteVariacao" => $coeficienteVariacao,
	"fi" => $fi,
	"fri" => $fri,
	"frip" => $frip,
	"faci" => $faci,
	"fraci" => $fraci,
	"fracip" => $fracip
);

//********************************************************//

// Retorna os valores em formato json

END:

echo json_encode($resultado);

//********************************************************//
?>