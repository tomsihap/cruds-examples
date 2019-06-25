<?php

const DB_HOST = 'localhost';
const DB_NAME = 'flightswf3';
const DB_PORT = '8889';
const DB_USER = 'root';
const DB_PSWD = 'root';
$bdd = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8;port=' . DB_PORT, DB_USER, DB_PSWD);