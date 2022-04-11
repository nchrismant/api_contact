<?php

  use App\api\Contact\ContactValidator;
  use App\config\Database;
  use App\models\Contact\Contact;

  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Contact.php';
  include_once './ContactValidator.php';

  // Instantiate DB & connect
  $database = new Database;
  $db = $database->connect();

  // Instantiate blog contact object
  $contact = new Contact($db);

  // Get raw contacted data
  $data = json_decode(file_get_contents("php://input"), true);
  $validator = new ContactValidator($data);
  if(!isset($data['id'], $data['name'], $data['firstname'], $data['email'], $data['phone'], $data['adress'], $data['age'])) {
    echo json_encode(
      array('errors' => 'All the fields are not filled.',
            'data' => 'Data contacts are : id, name, firstname, email, phone, adress and age.'),
    );
    die();
  }
  $errors = $validator->validates($data, $data['id']);
  if(!is_int($data['age'])) {
    $errors['age'] = "Age must be an integer";
  }
  if(empty($errors)) {
    // Set ID to update
    $contact->setId($data['id']);

    $contact->setName($data['name']);
    $contact->setFirstname($data['firstname']);
    $contact->setEmail($data['email']);
    $contact->setPhone($data['phone']);
    $contact->setAdress($data['adress']);
    $contact->setAge($data['age']);

    // Update contact
    if($contact->update()) {
      echo json_encode(
        array('message' => 'Contact Updated')
      );
    } else {
      echo json_encode(
        array('message' => 'Contact Not Updated')
      );
    }
  } else {
    echo json_encode(
      array('message' => 'Contact Not Updated',
            'errors' => $errors),
    );
  }
?>