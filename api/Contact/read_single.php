<?php 
  use App\config\Database;
  use App\models\Contact\Contact;

  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Contact.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog contact object
  $contact = new Contact($db);

  // Get ID
  if(isset($_GET['id'])) {
    if($contact->exists('id', $_GET['id'])) {
      $contact->setId($_GET['id']);
    } else {
      echo json_encode(
        array('errors' => 'This contact does not exist.')
      );
      die();
    }
  } else {
    echo json_encode(
      array('errors' => 'You must specified an id.')
    );
    die();
  }
  
  // Get contact
  $contact->read_single();

  // Create array
  $contact_arr = array(
    'id' => $contact->getId(),
    'name' => $contact->getName(),
    'firstname' => $contact->getFirstname(),
    'email' => $contact->getEmail(),
    'phone' => $contact->getPhone(),
    'adress' => $contact->getAdress(),
    'age' => $contact->getAge()
  );

  // Make JSON
  echo(json_encode($contact_arr));
?>