<?php

    try {  
        $conn = new PDO("mysql:dbname=apirest_test;host=localhost", "root", "");
    } catch (PDOException $e) {
        echo "erro ao acessar bando de dados. ERROR:" . $e->getMessage();
    }