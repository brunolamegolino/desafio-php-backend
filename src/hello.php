<?php


// header('Content-Type: application/json');

// $data = array('key' => 'valueaaaaaaaaaaaa', 'key2' => 'value2');
// if ($_SERVER['REQUEST_METHOD'] == 'GET') {
//     $data = array('key' => 'valueaaaaaaaaaaaa');
// }
    
// echo json_encode($data);

// echo phpinfo();

echo 'variavel enviada '.($_POST['nome_do_campo'] ?? 'vazio');

echo '
<form method="post" action="hello">
    <!-- Campos do formulário -->
    <input type="text" name="nome_do_campo" />
    <!-- Botão de envio -->
    <input type="submit" value="Enviar" />
</form>';