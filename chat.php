<?php
session_start();
include_once "defines.php";
require_once('classes/BD.class.php');
BD::conn();

if (!isset($_SESSION['email_logado'], $_SESSION['id_user'])) {
    header("Location: index.php");
}

$pegaUser = BD::conn()->prepare("SELECT * FROM `usuarios` WHERE `email` = ?");
$pegaUser->execute(array($_SESSION['email_logado']));
$dadosUser = $pegaUser->fetch();

if (isset($_GET['acao']) && $_GET['acao'] == 'sair') {
    unset($_SESSION['email_logado']);
    unset($_SESSION['id_user']);
    session_destroy();
    header("Location: index.php");
}
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
    <head>
        <meta charset=UTF-8>
        <title>Chat estilo face 2.0</title>
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/jquery_play.js"></script>
        <script type="text/javascript">
            $.noConflict();
        </script>

    </head>

    <body>
        <span class="user_online" id="<?php echo $dadosUser['id']; ?>"></span>
        <h2>Bem vindo, <?php echo $dadosUser['nome']; ?></h2>
        <a href="?acao=sair">Sair</a>
        <aside id="users_online">
            <ul>
                <?php
                $pegaUsuarios = BD::conn()->prepare("SELECT * FROM `usuarios` WHERE `id` != ?");
                $pegaUsuarios->execute(array($_SESSION['id_user']));
                while ($row = $pegaUsuarios->fetch()) {
                    $foto = ($row['foto'] == '') ? 'default.jpg' : $row['foto'];
                    $blocks = explode(',', $row['blocks']);
                    $agora = date('Y-m-d H:i:s');
                    if (!in_array($_SESSION['id_user'], $blocks)) {
                        $status = 'on';
                        if ($agora >= $row['limite']) {
                            $status = 'off';
                        }
                        ?>
                        <li id="<?php echo $row['id']; ?>">
                            <div class="imgSmall"><img src="fotos/<?php echo $foto; ?>" border="0" /></div>
                            <a href="#" id="<?php echo $_SESSION['id_user'] . ':' . $row['id']; ?>" class="comecar"><?php echo utf8_encode($row['nome']); ?></a>
                            <span id="<?php echo $row['id']; ?>" class="status <?php echo $status; ?>"></span>
                        </li>
                    <?php }
                } ?>
            </ul>
        </aside>

        <aside id="chats">

        </aside>
        <script type="text/javascript" src="js/functions.js"></script>
    </body>
</html>
<!---<div class="window" id="janela_x">
        <div class="header_window"><a href="#" class="close">X</a> <span class="name">Fulano de tal</span> <span id="5" class="status on"></span></div>
        <div class="body">
                <div class="mensagens">
                        <ul>
                                
                        </ul>
                </div>
                <div class="send_message" id="3:5">
                        <input type="text" name="mensagem" class="msg" id="3:5" />
                </div>
        </div>
</div>-->