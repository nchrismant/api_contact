<?php

  use App\config\Database;
  use App\models\Contact\Contact;

  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Contact.php';

  // Instantiate DB & connect
  $database = new Database;
  $db = $database->connect();

  // Instantiate blog contact object
  $contact = new Contact($db);

  // Blog contact query
  $result = $contact->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any contacts
  if($num > 0) {
    // contact array
    $contacts_arr = array();
    // $contacts_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $contact_item = array(
        'id' => $id,
        'name' => $name,
        'firstname' => $firstname,
        'email' => $email,
        'phone' => $phone,
        'adress' => $adress,
        'age' => $age
      );

      // Push to "data"
      array_push($contacts_arr, $contact_item);
      // array_push($contacts_arr['data'], $contact_item);
    }

    // Turn to JSON & output
    echo json_encode($contacts_arr);

  } else {
    // No contacts
    echo json_encode(
      array('message' => 'No contacts Found')
    );
  }
?>