<?php
//********************************************************//

// Recebe os dados do formulario
$dados = $_POST["txtDados"];
$dadosDesordenados = $_POST["txtaDadosDesordenados"];
$dadosOrdenados = $_POST["txtaDadosOrdenados"];
$casasDecimais = $_POST["nbrCasasDecimais"];
$fatorAjuste = $_POST["nbrFatorAjuste"];

//********************************************************//

// Testa se não foram enviados dados e se já haviam sido enviados dados
if (!empty($dados)) {

	$dadosDesordenados = (empty($dadosDesordenados)) ? $dados : $dadosDesordenados.", ".$dados;
	$dadosOrdenados = (empty($dadosOrdenados)) ? $dados : $dadosOrdenados.", ".$dados;

}

//********************************************************//

// Explode os dados das strings para para um array $rol
$rol = explode(", ", $dadosOrdenados);

//********************************************************//

// Ordena os dados do array $rol
sort($rol);
$dadosOrdenados = (count($rol) == 1) ? $rol[0] : implode(", ", $rol);
/*echo "<pre>Rol:<br>";
print_r($rol);	
echo "<pre>";*/

//********************************************************//

// Obtem o tamanho da populacao
$populacaoTamanho = count($rol);
//echo "populacaoTamanho = ".$populacaoTamanho."<br>";

//********************************************************//

// Define a Amplitude Amostral
$elementoMaior = max($rol);
$elementoMenor = min($rol);
$populacaoAmplitudeAmostral = $elementoMaior - $elementoMenor;
//echo "populacaoAmplitudeAmostral = ".$populacaoAmplitudeAmostral."<br>";

//********************************************************//

// Define o numero de classes
//$a = log($populacaoTamanho);
//$b = 1 + (3.322 * $a);
$a = sqrt($populacaoTamanho);
$populacaoNumeroClasses = round($a + $fatorAjuste); //round($a);
//echo "populacaoNumeroClasses = ".$populacaoNumeroClasses."<br>";

//********************************************************//

// Define a Amplitude do Intervalo de Classes
$a = $populacaoAmplitudeAmostral / $populacaoNumeroClasses;
$populacaoAmplitudeIntervaloClasse = round($a);
//echo "populacaoAmplitudeIntervaloClasse = ".$populacaoAmplitudeIntervaloClasse."<br>";

//********************************************************//

// Define as classes e os arrays que transportam os dados da tabela de distribuicao de frequencia
$arrayClasses = array();
$arrayXi = array();
$arrayFi = array();
$arrayXiFi = array();
$arrayFri = array();
$arrayFrip = array();
$arrayFaci = array();
$arrayFraci = array();
$arrayFracip = array();

$a = $elementoMenor;
$i = 0;
$j = 0;

// Frequencia acumulada inicial
$faci = 0;

while ($a < $elementoMaior) {

	$b = $a + $populacaoAmplitudeIntervaloClasse;
	$c = 0;

	$i++;

	// Intervalos de Classes
	$arrayClasses[$i] = "$a |--- $b";

	// Ponto medio dos intervalos de classes
	$arrayXi[$i] = ($a + $b) / 2;

	// Frequencia simples
	$sair = 0;

	do {
		
		if (isset($rol[$j]) && ($rol[$j] >= $a) && ($rol[$j] < $b)) {

			$c++;
			$j++;
			
		} else {

			$sair = 1;
		}
	
	} while ($sair != 1);

	$arrayFi[$i] = $c;

	// Ponto medio x frequencia
	$arrayXiFi[$i] = $arrayXi[$i] * $arrayFi[$i];

	// Frequencia relativa
	$d = $c / $populacaoTamanho;
	$arrayFri[$i] = round($d, $casasDecimais);

	// Frequencia relativa percentual
	$e = $d * 100;
	$arrayFrip[$i] = round($e, $casasDecimais);

	// Frequencia acumulada
	$faci += $c;
	$arrayFaci[$i] = $faci;

	// Frequencia relativa acumulada
	$d = $faci / $populacaoTamanho;
	$arrayFraci[$i] = round($d, $casasDecimais);

	// Frequencia relativa acumulada percentual
	$e = $d * 100;
	$arrayFracip[$i] = round($e, $casasDecimais);

	$a += $populacaoAmplitudeIntervaloClasse;

}

//echo "<pre>Classes:<br>";
//print_r($arrayClasses);
//echo "<br>Frequência:<br>";
//print_r($arrayFi);	
//echo "<pre>";

//********************************************************//

// Media
$a = array_sum($arrayXiFi);
$b = $a / $populacaoTamanho;
$populacaoMedia = round($b, $casasDecimais);
/*echo "<pre>Média: ".$populacaoMedia."</pre>";*/

//********************************************************//

// Mediana
$a = array_sum($arrayFi) / 2;
$limiteInferior = $elementoMenor;
$somatorioFiAnteriores = 0;
$i = 1;

while ($a > $arrayFaci[$i]) {

	$limiteInferior += $populacaoAmplitudeIntervaloClasse;
	$somatorioFiAnteriores += $arrayFi[$i];
	$i ++;
	$frequenciaClasseMediana = $arrayFi[$i];

}

$c = $limiteInferior + ((($a - $somatorioFiAnteriores) / $frequenciaClasseMediana) * $populacaoAmplitudeIntervaloClasse);
$populacaoMediana = round($c, $casasDecimais);

/*echo "<pre>Posição Mediana: ".$posicaoMediana." Mediana: ".$populacaoMediana."</pre>";*/

//********************************************************//

// Moda
//$fiMaior = max($arrayFi);
//
//$modaElementos = array();
//
//foreach ($arrayFi as $elemento => $elementoFi) {
//	
//	if ($elementoFi == $fiMaior) {
//
//		$modaElementos[] = $elemento;
//
//	}
//
//}
//
//$populacaoModa = (count($modaElementos) == 1) ? $modaElementos[0] : implode(", ", $modaElementos);
/*echo "<pre>Moda:<br>";
print_r($populacaoModa);	
echo "<pre>";*/

//********************************************************//

// Variancia
//$somatorio = 0;
//
//foreach ($arrayFi as $elemento => $elementoFi) {
//	
//	//echo "<pre>";
//	$a = $elemento - $populacaoMedia;
//	//echo "a = ".$a."<br>";
//	$b = $a ** 2;
//	//echo "b = ".$b."<br>";
//	$c = $b * $elementoFi;
//	//echo "c = ".$c."<br>";
//	$somatorio += $c; 
//	//echo "Somatório = ".$somatorio."</pre>";
//
//}
//
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

// Monta um array para retornar os valores
$resultado = array(
	"dadosDesordenados" => $dadosDesordenados,
	"dadosOrdenados" => $dadosOrdenados,
	"populacaoTamanho" => $populacaoTamanho,
	"elementoMenor" => $elementoMenor,
	"elementoMaior" => $elementoMaior,
	"populacaoAmplitudeAmostral" => $populacaoAmplitudeAmostral,
	"populacaoNumeroClasses" => $populacaoNumeroClasses,
	"populacaoAmplitudeIntervaloClasse" => $populacaoAmplitudeIntervaloClasse,
	"populacaoMedia" => $populacaoMedia,
	"populacaoMediana" => $populacaoMediana,
//	"populacaoModa" => $populacaoModa,
//	"populacaoVariancia" => $populacaoVariancia,
//	"populacaoVarianciaRelativa" => $populacaoVarianciaRelativa,
//	"populacaoDesvioPadrao" => $populacaoDesvioPadrao,
//	"populacaoCoeficienteVariacao" => $populacaoCoeficienteVariacao,
	"arrayClasses" => $arrayClasses,
	"arrayXi" => $arrayXi,
	"arrayFi" => $arrayFi,
	"arrayXiFi" => $arrayXiFi,
	"arrayFri" => $arrayFri,
	"arrayFrip" => $arrayFrip,
	"arrayFaci" => $arrayFaci,
	"arrayFraci" => $arrayFraci,
	"arrayFracip" => $arrayFracip
);

//********************************************************//

// Retorna os valores em formato json
echo json_encode($resultado);

//********************************************************//
?>