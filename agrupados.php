<div id="main">

	<div id="mainContainer">

		<section id="mainSection">

<article class="mainArticleBox">

	<h1>Dados agrupados</h1>

	<!--<form method="POST" id="formColetaDados" action="/php/r-agrupados.php">-->
	<form method="POST" id="formColetaDados">
								
		<!--<h2>Coleta de Dados</h2>-->
	
		<div id="boxCarregarDados">
			<span>Inserir dados:</span><br>
			<input type="text" name="txtDados" id="txtDados" autofocus="autofocus">
		</div>

		<div class="boxOpcoesDados">
			<span>Casas Decimais.</span>
			<input type="number" name="nbrCasasDecimais" id="nbrCasasDecimais" min="0" max="9" value="2" required="required">
		</div>

		<div class="boxOpcoesDados">
			<span>Fator de Ajuste.</span>
			<input type="number" name="nbrFatorAjuste" id="nbrFatorAjuste" min="-3" max="3" value="0" required="required">
		</div>
		
		<div id="boxEnviarDados">
			<input type="submit" name="sbmtDados" id="sbmtDados" value="Inserir">
			<input type="reset" name="rstDados" id="rstDados" value="Limpar">
		</div>

		<div class="boxExibeDados">
			<span>Dados inseridos</span><br>
			<!--<textarea name="txtaDadosDesordenados" id="txtaDadosDesordenados"></textarea>-->
			<textarea name="txtaDadosDesordenados" id="txtaDadosDesordenados" readonly="readonly"></textarea>
		</div>
		
		<div class="boxExibeDados">
			<span>Dados em ROL</span><br>
			<!--<textarea name="txtaDadosOrdenados" id="txtaDadosOrdenados"></textarea><br>-->
			<textarea name="txtaDadosOrdenados" id="txtaDadosOrdenados" readonly="readonly"></textarea>
		</div>

	</form>

	<div id="boxPopulacao">

		<h2>População</h2>

		<span id="populacaoTamanho"></span>
		<span id="populacaoAmplitudeAmostral"></span>
		<span id="elementoMenor"></span>
		<span id="elementoMaior"></span>
		<span id="populacaoNumeroClasses"></span>
		<span id="populacaoAmplitudeIntervaloClasse"></span>
		<span id="populacaoMedia"></span>
		<span id="populacaoMediana"></span>
		<span id="populacaoModa"></span>
		<span id="populacaoVariancia"></span>
		<span id="populacaoVarianciaRelativa"></span>
		<span id="populacaoDesvioPadrao"></span>
		<span id="populacaoCoeficienteVariacao"></span>

	</div>

	<div id="tableFrequencia">

		<h2>Tabela de distribuição de Frequência</h2>

		<table>
			<thead>
				<tr>
					<th>i</th>
					<th>classe</th>
					<th>Xi</th>
					<th>fi</th>
					<th>Xi*Fi</th>
					<th>fri</th>
					<th>fri%</th>
					<th>faci</th>
					<th>fraci</th>
					<th>fraci%</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>

	</div>
	
</article>

		</section>

		<aside id="mainAside">

			<article description="content">

				<h2>Ajuda</h2>
				<p><strong>Inserir dados:</strong></p>
				<ul>
					<li>Insira os dados um a um, ou separados por virgula.<br>Ex: 1, 3, 23, 54, 119</li>
					<li>Use (.) ponto para valores decimais.<br>Ex: 1.2, 2.4, 23.12</li>
				</ul>
				<p><strong>Casas Decimais:</strong></p>
				<p>Escolha de 0 até 9 a quantidade de casas decimais que deseja para arredondar os cálculos.</p>
				<p><strong>Número de classes:</strong></p>
				<!--<p>Método de Sturges<br>K = 1 + 3,322 x log n</p>-->
				<p>Raiz quadrada de n<br>K = (n)<sup>1/2</sup></p>
				<p><strong>Fator de Ajustes:</strong></p>
				<p>Escolha de -3 até 3 o fator de ajuste do intervalo de classes que melhor represente sua população.</p>


<?php
echo "<p><strong>Parâmetro GET:</strong> ";
echo $target;    
echo "</p>";
?>

				<div id="boxMessage"></div>

			</article>

		</aside>

	</div>

</div>