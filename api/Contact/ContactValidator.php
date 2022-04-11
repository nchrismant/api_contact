<?php
namespace App\api\Contact;

include_once '../Validator.php';
use App\config\Database;
use App\models\Contact\Contact;
use App\api\Validator;

class ContactValidator extends Validator {

    public function validates(array $data , ?int $id = null) {
        $database = new Database();
        $pdo = $database->connect();
        parent::validates($data, $id);
        $this->validate('email', 'isMail');
        $this->validate('email', 'existMail', new Contact($pdo), $id);
        $this->validate('phone', 'minLength', 10);
        $this->validate('phone', 'maxLength', 10);
        $this->validate('phone', 'existPhone', new Contact($pdo), $id);
        return $this->errors;
    }
}
?>