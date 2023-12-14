<?php


$db=pg_connect('host=localhost dbname=basdat user=postgres password=roufth29');
if( !$db ){
    die("Gagal terhubung dengan database: " . pg_connect_error());
}

$pdo = new PDO('pgsql:host=localhost;dbname=basdat', 'postgres', 'roufth29');
?>