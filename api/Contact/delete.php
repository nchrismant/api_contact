<?php

  use App\config\Database;
  use App\models\Contact\Contact;

  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Contact.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog contact object
  $contact = new Contact($db);

  // Get raw contacted data
  $data = json_decode(file_get_contents("php://input"));
  if($contact->exists('id', $data->id)) {
    // Set ID to delete
    $contact->setId($data->id);

    // Delete contact
    if($contact->delete()) {
      echo json_encode(
        array('message' => 'Contact Deleted')
      );
    } else {
      echo json_encode(
        array('message' => 'Contact Not Deleted')
      );
    }
  } else {
    echo json_encode(
      array('message' => 'This contact does not exist.')
    );
  }
?>