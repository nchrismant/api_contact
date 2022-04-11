<?php

  use App\api\Contact\ContactValidator;
  use App\config\Database;
  use App\models\Contact\Contact;

  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Contact.php';
  include_once './ContactValidator.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog contact object
  $contact = new Contact($db);

  // Get raw contacted data
  $data = json_decode(file_get_contents("php://input"), true);
  $validator = new ContactValidator($data);
  $errors = $validator->validates($data);
  if(!isset($data['name'], $data['firstname'], $data['email'], $data['phone'], $data['adress'], $data['age'])) {
    echo json_encode(
      array('errors' => 'All the fields are not filled.',
            'data' => 'Data contacts are : name, firstname, email, phone, adress and age.'),
    );
    die();
  }
  if(!is_int($data['age'])) {
    $errors['age'] = "Age must be an integer.";
  }
  if(empty($errors)) {
    $contact->setName($data['name']);
    $contact->setFirstname($data['firstname']);
    $contact->setEmail($data['email']);
    $contact->setPhone($data['phone']);
    $contact->setAdress($data['adress']);
    $contact->setAge($data['age']);

    // Create contact
    if($contact->create()) {
      echo json_encode(
        array('message' => 'Contact Created')
      );
    } else {
      echo json_encode(
        array('message' => 'Contact Not Created')
      );
    }
  } else {
    echo json_encode(
      array('message' => 'Contact Not Created',
            'errors' => $errors),
    );
  }
?>