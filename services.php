<?php
ini_set('display_errors',1);
require_once "config/database.php";
require_once "lib/nusoap/nusoap.php";
require_once "function.php";

// config server's services
$server = new soap_server;
$server->configureWSDL("travels", "urn:travels");

// addNewPlace
$server->register("addNewPlace",
  array("id" => "xsd:string", "name" => "xsd:string",
    "city" => "xsd:string", "country" => "xsd:string",
    "address" => "xsd:string", "services" => "xsd:string",
    "description" => "xsd:string"), // input params
  array("return" => "xsd:integer"), // output
  "urn:travels", // namespace
  "urn:travels#addNewPlace",
  "rpc",
  "encoded",
  "Add new place"
  );

// isExistPlace
$server->register("isExistPlace",
  array("id" => "xsd:string"), // input params
  array("return" => "xsd:integer"), // output
  "urn:travels", // namespace
  "urn:travels#isExistPlace",
  "rpc",
  "encoded",
  "Check place with id is exist or not"
  );

// deploy services
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : "";
$server->service($HTTP_RAW_POST_DATA);
?>
