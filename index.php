<?php
/*
 * DESCRIÇÃO: Software para cálculo estatístico (Trabalho acadêmico).
 * DATA: -----------
 * @author Getulio Vinicius <getuliovinits@gmail.com>
 */

$target = (isset($_GET['q'])) ? $_GET['q'] : "home";

include 'header.php';

include $target.'.php';

include 'footer.php';

?>