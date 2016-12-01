<?php
//********************************************************//

// Recebe os dados do formulario
$dados = $_POST["txtDados"];
$dadosDesordenados = $_POST["txtaDadosDesordenados"];
$dadosOrdenados = $_POST["txtaDadosOrdenados"];
$casasDecimais = $_POST["nbrCasasDecimais"];

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
//echo "<pre>Rol:<br>";
//print_r($rol);	
//echo "<pre>";

//********************************************************//

// Tamanho da populacao
$somatorioFi = count($rol);
//echo "<pre>Somatorio fi: ".$somatorioFi."</pre>";

//********************************************************//

// Soma dos valores da populacao
$somatorioDados = array_sum($rol);
//echo "<pre>Somatorio dados: ".$somatorioDados."</pre>";

//********************************************************//

// Media
$media = round($somatorioDados / $somatorioFi, $casasDecimais);
//echo "<pre>Média: ".$media."</pre>";

//********************************************************//

// Mediana
if (($somatorioFi % 2) == 0) {

	$posicaoMediana = ($somatorioFi / 2) - 1;

} else {

	$posicaoMediana = (($somatorioFi + 1) / 2) - 1;

}

$mediana = $rol[$posicaoMediana];
//echo "<pre>Posição Mediana: ".$posicaoMediana." Mediana: ".$mediana."</pre>";

//********************************************************//

// Frequencia simples de cada elelemento da populacao
$fi = array_count_values($rol);
//echo "<pre>fi<br>";
//print_r($fi);	
//echo "<pre>";

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
//echo "<pre>Moda: ".$moda."<pre>";

//********************************************************//

// Variancia
$somatorioXiMediaFi = 0;

foreach ($fi as $elemento => $elementoFi) {
	
	$numerador = (($elemento - $media) ** 2) * $elementoFi;
	//echo "<pre>((".$elemento." - ".$media.")²) * ".$elementoFi." = ".$a."</pre>";
	$somatorioXiMediaFi += $numerador; 
	//echo "<pre>Somatório = ".$somatorioXiMediaFi."</pre>";

}

$variancia = round($somatorioXiMediaFi / $somatorioFi, $casasDecimais);
//echo "<pre>Variância = ".$variancia."</pre>";

//********************************************************//

// Variancia Relativa
$varianciaRelativa = round($variancia / ($media ** 2), $casasDecimais);
//echo "<pre>Variância Relativa = ".$varianciaRelativa."</pre>";

//********************************************************//

// Desvio Padrao
$desvioPadrao = round(sqrt($variancia), $casasDecimais);
//echo "<pre>Desvio Padrão = ".$desvioPadrao."</pre>";

//********************************************************//

// Coeficiente de Variacao
$coeficienteVariacao = round(($desvioPadrao / $media) * 100, $casasDecimais);
//echo "<pre>Coeficiente de Variação = ".$coeficienteVariacao."</pre>";

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

END:

// Retorna os valores em formato json
//echo "<pre>";
echo json_encode($resultado);
//echo "</pre>";

//********************************************************//
?>