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

// Obtem o tamanho da populacao
$somatorioFi = count($rol);
//echo "somatorioFi = ".$somatorioFi."<br>";

//********************************************************//

// Define a Amplitude Amostral
$elementoMaior = max($rol);
$elementoMenor = min($rol);
$amplitudeAmostral = $elementoMaior - $elementoMenor;
//echo "amplitudeAmostral = ".$amplitudeAmostral."<br>";

//********************************************************//

// Define o numero de classes
//$a = log($somatorioFi);
//$b = 1 + (3.322 * $a);
$a = sqrt($somatorioFi);
$numeroClasses = round($a + $fatorAjuste); //round($a);
//echo "numeroClasses = ".$numeroClasses."<br>";

//********************************************************//

// Define a Amplitude do Intervalo de Classes
$a = $amplitudeAmostral / $numeroClasses;
$amplitudeIntervaloClasse = round($a);
//echo "amplitudeIntervaloClasse = ".$amplitudeIntervaloClasse."<br>";

//********************************************************//

// Define as classes e os arrays que transportam os dados da tabela de distribuicao de frequencia
$classes = array();
$xi = array();
$fi = array();
$xiFi = array();
$fri = array();
$frip = array();
$faci = array();
$fraci = array();
$fracip = array();

$a = $elementoMenor;
$i = 0;
$j = 0;

// Frequencia acumulada inicial
$somaFaci = 0;

while ($a < $elementoMaior) {

	$b = $a + $amplitudeIntervaloClasse;
	$c = 0;

	$i++;

	// Intervalos de Classes
	$classes[$i] = "$a |--- $b";

	// Ponto medio dos intervalos de classes
	$xi[$i] = ($a + $b) / 2;

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

	$fi[$i] = $c;

	// Ponto medio x frequencia
	$xiFi[$i] = $xi[$i] * $fi[$i];

	// Frequencia relativa
	$d = $c / $somatorioFi;
	$fri[$i] = round($d, $casasDecimais);

	// Frequencia relativa percentual
	$e = $d * 100;
	$frip[$i] = round($e, $casasDecimais);

	// Frequencia acumulada
	$somaFaci += $c;
	$faci[$i] = $somaFaci;

	// Frequencia relativa acumulada
	$d = $somaFaci / $somatorioFi;
	$fraci[$i] = round($d, $casasDecimais);

	// Frequencia relativa acumulada percentual
	$e = $d * 100;
	$fracip[$i] = round($e, $casasDecimais);

	$a += $amplitudeIntervaloClasse;

}

//echo "<pre>Classes:<br>";
//print_r($classes);
//echo "<br>Frequência:<br>";
//print_r($fi);	
//echo "<pre>";

//********************************************************//

// Media
$a = array_sum($xiFi);
$b = $a / $somatorioFi;
$media= round($b, $casasDecimais);
/*echo "<pre>Média: ".$populacaoMedia."</pre>";*/

//********************************************************//

// Mediana
$a = array_sum($fi) / 2;
$limiteInferior = $elementoMenor;
$somatorioFiAnteriores = 0;
$i= 1;

while ($a > $faci[$i]) {

	$limiteInferior += $amplitudeIntervaloClasse;
	$somatorioFiAnteriores += $fi[$i];
	$i ++;
	$frequenciaClasseMediana = $fi[$i];

}

if ($i == 1) {

	$frequenciaClasseMediana = $fi[$i];

}

$c = $limiteInferior + ((($a - $somatorioFiAnteriores) / $frequenciaClasseMediana) * $amplitudeIntervaloClasse);
$mediana = round($c, $casasDecimais);

/*echo "<pre>Posição Mediana: ".$posicaoMediana." Mediana: ".$mediana."</pre>";*/

//********************************************************//

// Moda
//$fiMaior = max($fi);
//
//$modaElementos = array();
//
//foreach ($fi as $elemento => $elementoFi) {
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
//foreach ($fi as $elemento => $elementoFi) {
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
//$a = $somatorio / $somatorioFi;
//$populacaoVariancia = round($a, $casasDecimais);
//echo "<pre>Variância = ".$populacaoVariancia."</pre>";

//********************************************************//

// Variancia Relativa
//$a = $media** 2;
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
	"somatorioFi" => $somatorioFi,
	"elementoMenor" => $elementoMenor,
	"elementoMaior" => $elementoMaior,
	"amplitudeAmostral" => $amplitudeAmostral,
	"numeroClasses" => $numeroClasses,
	"amplitudeIntervaloClasse" => $amplitudeIntervaloClasse,
	"media" => $media,
	"mediana" => $mediana,
//	"populacaoModa" => $populacaoModa,
//	"populacaoVariancia" => $populacaoVariancia,
//	"populacaoVarianciaRelativa" => $populacaoVarianciaRelativa,
//	"populacaoDesvioPadrao" => $populacaoDesvioPadrao,
//	"populacaoCoeficienteVariacao" => $populacaoCoeficienteVariacao,
	"classes" => $classes,
	"xi" => $xi,
	"fi" => $fi,
	"xiFi" => $xiFi,
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