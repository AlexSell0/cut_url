<?php
// const DB_HOST = "127.0.0.1"; //localhost

define("SITE_NAME", "Cut your URL");
define("HOST", "http://" . $_SERVER["HTTP_HOST"]);

define("DB_HOST", "127.0.0.1");
define("DB_NAME", "cut_url");
define("DB_USER", "root");
define("DB_PASS", "root");

define("URL_CHARS", "abcdefghijklmnopqrstuvwxyz-0123456789");

session_start();

// define("DB_HOST", "https://alexsell0.github.io/cut_url/");
// define("DB_NAME", "alex_sell_testbd");
// define("DB_USER", "alexsell");
// define("DB_PASS", "j.mCaKkvm56KUCu");