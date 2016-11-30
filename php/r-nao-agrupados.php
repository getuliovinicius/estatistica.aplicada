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

// Explode os dados das strings para para um array $rol
$rol = explode(", ", $dadosOrdenados);

//********************************************************//

// Ordena os dados do array $rol
sort($rol);
$dadosOrdenados = (count($rol) == 1) ? $rol[0] : implode(", ", $rol);
echo "<pre>Rol:<br>";
print_r($rol);	
echo "<pre>";

//********************************************************//

// Tamanho da populacao
$populacaoTamanho = count($rol);
echo "<pre>Tamanho: ".$populacaoTamanho."</pre>";

//********************************************************//

// Soma dos valores da populacao
$populacaoSomatorio = array_sum($rol);
echo "<pre>Somatorio: ".$populacaoSomatorio."</pre>";

//********************************************************//

// Media
$media = round($populacaoSomatorio / $populacaoTamanho, $casasDecimais);
echo "<pre>Média: ".$media."</pre>";

//********************************************************//

// Mediana
if (($populacaoTamanho % 2) == 0) {

	$posicaoMediana = ($populacaoTamanho / 2) - 1;

} else {

	$posicaoMediana = (($populacaoTamanho + 1) / 2) - 1;

}

$mediana = $rol[$posicaoMediana];
echo "<pre>Posição Mediana: ".$posicaoMediana." Mediana: ".$mediana."</pre>";

//********************************************************//

// Frequencia simples de cada elelemento da populacao
//$arrayFi = array_count_values($rol);
/*echo "<pre>Frequência:<br>";
print_r($arrayFi);	
echo "<pre>";*/

//********************************************************//

// Moda
//$fiMaior = max($arrayFi);

//$modaElementos = array();

//foreach ($arrayFi as $elemento => $elementoFi) {
	
//	if ($elementoFi == $fiMaior) {

//		$modaElementos[] = $elemento;

//	}

//}

//$populacaoModa = (count($modaElementos) == 1) ? $modaElementos[0] : implode(", ", $modaElementos);
/*echo "<pre>Moda:<br>";
print_r($populacaoModa);	
echo "<pre>";*/

//********************************************************//

// Variancia
//$somatorio = 0;

//foreach ($arrayFi as $elemento => $elementoFi) {
	
	//echo "<pre>";
//	$a = $elemento - $populacaoMedia;
	//echo "a = ".$a."<br>";
//	$b = $a ** 2;
	//echo "b = ".$b."<br>";
//	$c = $b * $elementoFi;
	//echo "c = ".$c."<br>";
//	$somatorio += $c; 
	//echo "Somatório = ".$somatorio."</pre>";

//}

//$a = $somatorio / $populacaoTamanho;
//$populacaoVariancia = round($a, $casasDecimais);
//echo "<pre>Variância = ".$populacaoVariancia."</pre>";

//********************************************************//

// Variancia Relativa
//$a = $populacaoMedia ** 2;
//$b = $populacaoVariancia / $a;
//	$populacaoVarianciaRelativa = round($b, $casasDecimais);

//********************************************************//

// Desvio Padrão
//$a = sqrt($populacaoVariancia);
//$populacaoDesvioPadrao = round($a, $casasDecimais);
//echo "<pre>Desvio Padrão = ".$populacaoDesvioPadrao."</pre>";

//********************************************************//

// Coeficiente de Variação
//$a = $populacaoDesvioPadrao / $populacaoMedia;
//$b = $a * 100;
//$populacaoCoeficienteVariacao = round($b, $casasDecimais);

//********************************************************//

// Define as frequencias de cada elemento em arrays
//$arrayFri = array();
//$arrayFrip = array();
//$arrayFaci = array();
//$arrayFraci = array();
//$arrayFracip = array();

// Frequencia acumulada inicial
//$faci = 0;

//foreach ($arrayFi as $elemento => $elementoFi) {

	// Frequencia relativa
//	$a = $elementoFi / $populacaoTamanho;
//	$arrayFri[$elemento] = round($a, $casasDecimais);
	// Frequencia relativa percentual
//	$b = $a * 100;
//	$arrayFrip[$elemento] = round($b, $casasDecimais);
	// Frequencia acumulada
//	$faci += $elementoFi;
//	$arrayFaci[$elemento] = $faci;
	// Frequencia relativa acumulada
//	$a = $faci / $populacaoTamanho;
//	$arrayFraci[$elemento] = round($a, $casasDecimais);
	// Frequencia relativa acumulada percentual
//	$b = $a * 100;
//	$arrayFracip[$elemento] = round($b, $casasDecimais);

//}

//********************************************************//

// Monta um array para retornar os valores
$resultado = array(
	"dadosDesordenados" => $dadosDesordenados,
	"dadosOrdenados" => $dadosOrdenados,
	"populacaoTamanho" => $populacaoTamanho,
	"media" => $media,
	"mediana" => $mediana
//	"populacaoModa" => $populacaoModa,
//	"populacaoVariancia" => $populacaoVariancia,
//	"populacaoVarianciaRelativa" => $populacaoVarianciaRelativa,
//	"populacaoDesvioPadrao" => $populacaoDesvioPadrao,
//	"populacaoCoeficienteVariacao" => $populacaoCoeficienteVariacao,
//	"arrayFi" => $arrayFi,
//	"arrayFri" => $arrayFri,
//	"arrayFrip" => $arrayFrip,
//	"arrayFaci" => $arrayFaci,
//	"arrayFraci" => $arrayFraci,
//	"arrayFracip" => $arrayFracip
);

//********************************************************//

END:

// Retorna os valores em formato json
echo "<pre>";
echo json_encode($resultado);
echo "</pre>";

//********************************************************//
?>