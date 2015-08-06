<?php

define('HOST', 'localhost');
define('DB', 'chat');
define('USER', 'root');
define('PASS', '');


/* * ***************************
  FUNÇÃO DO GRAVATAR
  PEGA AVATAR DE USUÁRIOS
 * *************************** */

function gravatar($email, $s = 180, $d = 'mm', $r = 'g', $img = false, $atts = array()) {
    $url = 'http://www.gravatar.com/avatar/';
    $url .= md5(strtolower(trim($email))); //Pega a imagem pelo e-mail cadastrado no sistema se o e-mail for o mesmo do cadastrado no site http://www.gravatar.com
    $url .= "?s=$s&d=$d&r=$r";
    if ($img) {
        $url = '<img src="' . $url . '"';
        foreach ($atts as $key => $val)
            $url .= ' ' . $key . '="' . $val . '"'; //Pega a imagem de sua conta criada no site http://www.gravatar.com, serve muito para wordpress especialmente para mostrar sua imagem quando voçê comenta ou posta algo em um blog.
        $url .= ' />';
    }
    return $url;
}

?>