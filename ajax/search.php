<?php
//turn off error_reports
//error_reporting(0);
include "../functions/search.php";
include "../functions/getData.php";
include "../functions/lang.php";
include "../po_parser/src/Sepia/PoParser.php";
//include "lang/lang_de.php"; //FIXME: add possibility to change language

// define path to home directory 
define("PATH", "../");

Lang::defineLanguage();

$search = new Search();

$search->getData();
$search->loadXML();
$search->sortResult("ref");
$search->showResult();
?>