<?php
//####################################################################################################//
// Recebe os dados do formulario
$dados = $_POST["txtDados"];
$dadosDesordenados = $_POST["txtaDadosDesordenados"];
$dadosOrdenados = $_POST["txtaDadosOrdenados"];
$casasDecimais = $_POST["nbrCasasDecimais"];
$fatorAjuste = $_POST["nbrFatorAjuste"];

//echo $dados;

//####################################################################################################//
//Declarar o array que vai retornar como resultado
$resultado = array();

//####################################################################################################//
// Testa se não foram enviados dados e se já haviam sido enviados dados
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

	if (!is_numeric($rol[$ordem])) {

		// Vai para o fim do script e retorna com erro
		$resultado["error"] = "Tipo de dado incorreto";
		goto END;

	}

}

$dadosDesordenados = (count($rol) == 1) ? $rol[0] : implode(", ", $rol);
sort($rol);
$dadosOrdenados = (count($rol) == 1) ? $rol[0] : implode(", ", $rol);

//####################################################################################################//
// Obtem o tamanho da populacao
$somatorioFi = count($rol);

//####################################################################################################//

// Define a Amplitude Amostral
$elementoMaior = max($rol);
$elementoMenor = min($rol);
$amplitudeAmostral = $elementoMaior - $elementoMenor;

//####################################################################################################//
// Define o numero de classes
//$a = log($somatorioFi);
//$b = 1 + (3.322 * $a);
$numeroClasses = round(sqrt($somatorioFi) + $fatorAjuste);

//####################################################################################################//
// Define a Amplitude do Intervalo de Classes
$amplitudeIntervaloClasse = round(($amplitudeAmostral / $numeroClasses));

//####################################################################################################//
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

$classe = 1;
$j = 0;

$a = $elementoMenor;

// Frequencia acumulada inicial
$somaFaci = 0;

while ($classe <= $numeroClasses) {

	$b = $a + $amplitudeIntervaloClasse;
	$c = 0;

	// Intervalos de Classes
	$classes[$classe] = "$a |--- $b";

	// Ponto medio dos intervalos de classes
	$xi[$classe] = ($a + $b) / 2;

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

	$fi[$classe] = $c;

	// elementos x frequencia
	$xiFi[$classe] = $xi[$classe] * $fi[$classe];

	// Frequencia relativa
	$d = $c / $somatorioFi;
	$fri[$classe] = round($d, $casasDecimais);

	// Frequencia relativa percentual
	$e = $d * 100;
	$frip[$classe] = round($e, $casasDecimais);

	// Frequencia acumulada
	$somaFaci += $c;
	$faci[$classe] = $somaFaci;

	// Frequencia relativa acumulada
	$d = $somaFaci / $somatorioFi;
	$fraci[$classe] = round($d, $casasDecimais);

	// Frequencia relativa acumulada percentual
	$e = $d * 100;
	$fracip[$classe] = round($e, $casasDecimais);

	$a += $amplitudeIntervaloClasse;

	$classe++;

}

//####################################################################################################//
// Media
$media = round(array_sum($xiFi) / $somatorioFi, $casasDecimais);

//####################################################################################################//
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

$c = ($frequenciaClasseMediana != 0) ? $limiteInferior + ((($a - $somatorioFiAnteriores) / $frequenciaClasseMediana) * $amplitudeIntervaloClasse) : 0;
$mediana = round($c, $casasDecimais);

//####################################################################################################//
// Moda
$fiMaior = max($fi);

$modaElementos = array();

foreach ($fi as $elemento => $elementoFi) {
	
	if ($elementoFi == $fiMaior) {

		$modaElementos[] = $xi[$elemento];

	}

}

$moda = (count($modaElementos) == 1) ? $modaElementos[0] : implode(", ", $modaElementos);

//####################################################################################################//
// Variancia
$somatorio = 0;

foreach ($fi as $elemento => $elementoFi) {
	
	$xXi2Fi[$elemento] = (($media - $xi[$elemento]) ** 2) * $elementoFi;
	$somatorio += $xXi2Fi[$elemento];

}

$variancia = round($somatorio / $somatorioFi, $casasDecimais);

//####################################################################################################//
// Variancia Relativa
$varianciaRelativa = ($media != 0) ? round($variancia / ($media ** 2), $casasDecimais) : 0;

//####################################################################################################//
// Desvio Padrão
$desvioPadrao = round(sqrt($variancia), $casasDecimais);

//####################################################################################################//
// Coeficiente de Variação
$coeficienteVariacao = ($media != 0) ? round(($desvioPadrao / $media) * 100, $casasDecimais) : 0;

//####################################################################################################//
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
	"moda" => $moda,
	"variancia" => $variancia,
	"varianciaRelativa" => $varianciaRelativa,
	"desvioPadrao" => $desvioPadrao,
	"coeficienteVariacao" => $coeficienteVariacao,
	"classes" => $classes,
	"fi" => $fi,
	"xi" => $xi,
	"xiFi" => $xiFi,
	"xXi2Fi" => $xXi2Fi,
	"fri" => $fri,
	"frip" => $frip,
	"faci" => $faci,
	"fraci" => $fraci,
	"fracip" => $fracip
);

//####################################################################################################//
// Ponto para onde o programa deve prosseguir caso tenham ocorrido erros
END:

//####################################################################################################//
// Retorna os valores em formato json
echo json_encode($resultado);

?>