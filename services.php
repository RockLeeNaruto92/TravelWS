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

// addNewTour
$server->register("addNewTour",
  array("id" => "xsd:string", "place_id" => "xsd:string",
    "start_date" => "xsd:string", "tickets" => "xsd:integer",
    "cost" => "xsd:integer", "description" => "xsd:string"), // input params
  array("return" => "xsd:integer"), // output
  "urn:travels", // namespace
  "urn:travels#addNewTour",
  "rpc",
  "encoded",
  "Add new tour"
  );

// isExistTour
$server->register("isExistTour",
  array("id" => "xsd:string"), // input params
  array("return" => "xsd:integer"), // output
  "urn:travels", // namespace
  "urn:travels#isExistTour",
  "rpc",
  "encoded",
  "Check tour with id is exist or not"
  );

// addNewContract
$server->register("addNewContract",
  array("tour_id" => "xsd:string", "customer_id_number" => "xsd:string",
    "company_name" => "xsd:string", "company_phone" => "xsd:string",
    "company_address" => "xsd:string", "booking_tickets" => "xsd:integer"), // input params
  array("return" => "xsd:integer"), // output
  "urn:travels", // namespace
  "urn:travels#addNewContract",
  "rpc",
  "encoded",
  "Add new contract"
  );

// findByCity
$server->register("findByCity",
  array("city" => "xsd:string"), // input params
  array("return" => "xsd:string"), // output
  "urn:travels", // namespace
  "urn:travels#findByCity",
  "rpc",
  "encoded",
  "Find all tours in a city"
  );

// deploy services
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : "";
$server->service($HTTP_RAW_POST_DATA);
?>
