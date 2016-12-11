<div id="main">

	<div id="mainContainer">

		<section id="mainSection">

<article class="mainArticleBox">

	<!--<h1>Dados NÃO agrupados</h1>-->

	<!--<form method="POST" id="formColetaDados" action="/php/r-nao-agrupados.php">-->
	<form method="POST" id="formColetaDados">
								
		<!--<h2>Coleta de Dados</h2>-->
	
		<div id="boxCarregarDados">
			<span>Inserir dados:</span><br>
			<input type="text" name="txtDados" id="txtDados" autofocus="autofocus">
		</div>

		<div class="boxOpcoesDados">
			<span>Tipo de Variável</span><br>
			<input type="radio" name="rdiVariavel" id="rdiQuantitativa" value="1" checked="checked">
			<label for="rdiQuantitativa">Quantitativa</label>
			<input type="radio" name="rdiVariavel" id="rdiQualitativa" value="2">
			<label for="rdiQualitativa">Qualitativa</label>
		</div>

		<div class="boxOpcoesDados">
			<span>Casas Decimais.</span><br>
			<input type="number" name="nbrCasasDecimais" id="nbrCasasDecimais" min="0" max="9" value="2" required="required">
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

		<span id="somatorioFi"></span>
		<span id="somatorioDados"></span>
		<span id="media"></span>
		<span id="mediana"></span>
		<span id="moda"></span>
		<span id="variancia"></span>
		<span id="varianciaRelativa"></span>
		<span id="desvioPadrao"></span>
		<span id="coeficienteVariacao"></span>

	</div>

	<div id="tableFrequencia">

		<h2>Tabela de distribuição de Frequência</h2>

		<table>
			<thead>
				<tr>
					<th>El.</th>
					<th>fi</th>
					<th>fri</th>
					<th>fri%</th>
					<th>faci</th>
					<th>fraci</th>
					<th>fraci%</th>
				</tr>
			</thead>
			<tbody></tbody>
			<tfoot></tfoot>
		</table>

	</div>
	
</article>

		</section>

		<aside id="mainAside">

			<article description="content">

				<h2>Ajuda</h2>

				<div id="boxMessage"></div>

				<p><strong>Inserir dados:</strong></p>
				<ul>
					<li>Insira os dados um a um, ou separados por virgula.<br>Ex: 1, 3, 23, 54, 119</li>
					<li>Use (.) ponto para valores decimais.<br>Ex: 1.2, 2.4, 23.12</li>
					<li>Quanto o tipo de variável for qualitativa, podem ser enviados valores como:<br>A, B, C, D, A, D, C, F, A<br>João, Maria, Joaquim, Joana, João</li>
				</ul>
				<p><strong>Casas Decimais:</strong></p>
				<p>Escolha de 0 até 9 a quantidade de casas decimais que deseja para arredondar os cálculos.</p>

<?php
/*echo "<p><strong>Parâmetro GET:</strong> ";
echo $target;    
echo "</p>";*/
?>


			</article>

		</aside>

	</div>

</div>