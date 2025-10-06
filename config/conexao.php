<?php 

$dblocal = 'localhost';
$dbuser = 'root';
$dbpassword = '';
$dbname = 'forum';

$conexao = mysqli_connect($dblocal, $dbuser, $dbpassword, $dbname);

if(mysqli_connect_errno()) {
    print('Falha na conesão com o banco de dados: ' + mysqli_connect_error());
    exit;
}


?>