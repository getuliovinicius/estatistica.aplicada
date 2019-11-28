<?php
/**
 * DESCRIÇÃO: Software para cálculo estatístico (Trabalho acadêmico).
 * DATA: 2016-11-29
 * @package estatistica.aplicada
 * @version 1.0
 * @author Getulio Vinicius <getuliovinits@gmail.com>
 * @license GNU General Public License version 3 or later; see LICENSE
 */

/**
 * Para o Apache
 */
#$target = (isset($_GET['q'])) ? $_GET['q'] : "home";

/**
 * Para o Nginx
 */
$url = explode('/', $_SERVER['REQUEST_URI']);
$target = (isset($url[1])) ? $url[1] : "home";

include 'php/header.php';

include 'php/'.$target.'.php';

include 'php/footer.php';

?>
