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

// ok
function addNewContract($tour_id = NULL, $customer_id_number = NULL,
  $company_name = NULL, $company_phone = NULL,
  $company_address = NULL, $booking_tickets = 0){
  // check $customer_id_number
  if (isEmpty($customer_id_number)) return 0; // error_message => Customer id number is not present

  // check $company_name, $company_phone, $company_address
  if (isEmpty($company_name)) return 1; // error_message => Company name is not present
  if (isEmpty($company_phone)) return 2; // error_message => Company phone is not present
  if (isEmpty($company_address)) return 3; // error_message => Company address is not present

  // Check $tour_id
  if (isEmpty($tour_id)) return 4; // error_message => Tourid is not present
  $db = new DatabaseConfig;
  $result = $db->existed("tours", "id", $tour_id);

  if (!$result){
    unset($db);
    return 5; // error_message => Tourid is not existed in database
  }

  // check $booking tickets
  if ($booking_tickets <= 0) {
    unset($db);
    return 6; // error_message => booking ticket must be greater than 0
  }
  if ($booking_tickets > $result["available_tickets"]){
    unset($db);
    return 7; // error_message => Available tickets not enough
  }

  $total_money = $booking_tickets * $result["cost"];
  $available_tickets = $result["available_tickets"] - $booking_tickets;

  $query = "INSERT INTO contracts(tour_id, customer_id_number, company_name, company_phone, company_address, booking_tickets, total_money)";
  $query .= "VALUES ('$tour_id', '$customer_id_number', '$company_name', '$company_phone', '$company_address', $booking_tickets, $total_money)";

  $result = $db->query($query);
  if ($result){
    $query = "UPDATE tours SET available_tickets = $available_tickets WHERE id = '$tour_id'";
    $result = $db->query($query);
    unset($db);
    return -1; // ok
  }
  unset($db);
  return 8; // error_message => Error on execution query
}

// checking
function findByCity($city = NULL){
  if (isEmpty($city)) return "City is not present";

  $db = new DatabaseConfig;
  $query = "SELECT tours.* FROM tours, places WHERE places.city = '$city' and tours.place_id = places.id";
  $result = $db->query($query);
  unset($db);

  if (mysql_num_rows($result) == 0) return "Not exist any tours";
  else {
    $data = array();
    while ($row = mysql_fetch_array($result)){
      $rowData = array();
      foreach (DatabaseConfig::$TOURS as $value)
        $rowData[$value] = $row[$value];
      $data[] = $rowData;
    }
    return json_encode($data);
  }
}
?>

