<?php 

$dblocal = 'localhost';
$dbuser = 'root';
$dbpassword = '';
$dbname = 'forum';

$conexao = mysqli_connect($dblocal, $dbuser, $dbpassword, $dbname);

if (mysqli_connect_errno()) {
    die('Falha na conexão com o banco de dados: ' . mysqli_connect_error());
}


?>