<?php
//servidor, usuário, senha e nome do banco de dados
  $DBhost = "localhost";
  $DBuser = "username";
  $DBpass = "password";
  $DBname = "DBname";
  
  $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
     if ($DBcon->connect_errno) 
     {
         die("ERRO: ".$DBcon->connect_error);
     }