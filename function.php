<?php
require_once "config/database.php";

function isEmpty($variable){
  return $variable == NULL || strlen($variable) == 0;
}

function isValidTimeFormat($time){
  return strtotime($time) != NULL;
}

// ok
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

// ok
function isExistPlace($id = NULL){
  if (isEmpty($id)) return 0; // error_message => ID is not present

  $db = new DatabaseConfig;
  $result = $db->existed("places", "id", $id);
  unset($db);

  if ($result) return -1; // OK
  else return 1; // error_message => Id is not existed in database
}

// ok
function addNewTour($id = NULL, $place_id = NULL, $start_date = NULL,
  $tickets = 0, $cost = 0, $description = NULL){
  // check $start_date
  if (isEmpty($start_date)) return 0; // error_message => start date is not present
  if (!isValidTimeFormat($start_date)) return 1; //error_message => start_date is not have true format

  // check $ticket, $cost
  if ($tickets <= 0) return 2; // error_message => ticket must be greater than 0
  if ($cost <= 0) return 3; // error_message => $cost must be greater than 0

  // check $description
  if (isEmpty($description)) return 4; // error_message => description is not present

  // check $place_id
  if (isEmpty($place_id)) return 5; // error_message => place id is not present

  $db = new DatabaseConfig;
  $result = $db->existed("places", "id", $place_id);

  if (!$result) {
    unset($db);
    return 6; // error_message => Place id is not existed in database
  }

  // check id
  if (isEmpty($id)) {
    unset($db);
    return 7; // error_message => Id is not present
  }

  $result = $db->existed("tours", "id", $id);
  if ($result) {
    unset($db);
    return 8; // error_message => Id is existed in databse
  }

  $query = "INSERT INTO tours (id, place_id, start_date, tickets, available_tickets, cost, description)";
  $query .= "VALUES ('$id', '$place_id', '$start_date', '$tickets', '$tickets', '$cost', '$description')";

  $result = $db->query($query);
  if ($result) return -1; // ok
  return 9; // error_message => Error on execution query
}

// ok
function isExistTour($id = NULL){
  if (isEmpty($id)) return 0; // error_message => id is not present

  $db = new DatabaseConfig;
  $result = $db->existed("tours", "id", $id);
  unset($db);

  if ($result) return -1; // ok
  return 1; // error_message => ID is not existed in database
}
?>
