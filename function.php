<?php
require_once "config/database.php";

function isEmpty($variable){
  return $variable == NULL || strlen($variable) == 0;
}

function isValidTimeFormat($time){
  return strtotime($time) != NULL;
}

// checking
function addNewPlace($id = NULL, $name = NULL, $city = NULL,
  $country = NULL, $address = NULL, $services = NULL, $description = NULL){
  // check $name
  if (isEmpty($name)) return 0; // error_message => Name is not present

  // check $city, $country, $address
  if (isEmpty($city)) return 1; // error_message => City is not present
  if (isEmpty($country)) return 2; // error_message => Country is not present
  if (isEmpty($address)) return 3; // error_message => Address is not present

  // check $service
  if (isEmpty($services)) return 4; // error_message => Service is not present

  // check $description
  if (isEmpty($description)) return 5; // error_message => Description is not present

  // check $id
  if (isEmpty($id)) return 6; // error_message => Id is not present

  $db = new DatabaseConfig;
  $result = $db->existed("places", "id", $id);

  if ($result) {
    unset($db);
    return 7; // error_message => Id is existed in databse
  }

  $query = "INSERT INTO places(id, name, city, country, address, services, description)";
  $query .= "VALUES ('$id', '$name', '$city', '$country', '$address', '$services', '$description')";

  $result = $db->query($query);
  unset($db);

  if ($result) return -1; // OK
  else return 8; // error_message => Error on execution query
}
?>
