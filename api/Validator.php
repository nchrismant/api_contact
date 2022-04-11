<?php
namespace App\api;

use App\models\Contact\Contact;

class Validator {

    private $data;

    protected $errors = [];

    public function __construct(array $data = []) {
        $this->data = $data;
    }
    
    public function validates(array $data, ?int $id = null) {
        $this->errors = [];
        $this->data = $data;
        return $this->errors;
    }
    
    public function validate(string $field, string $method, ...$parameters) : bool {
        if(empty($this->data[$field])) {
            $this->errors[$field] = "The $field field is not filled.";
            return false;
        } 
        else {
            return call_user_func([$this, $method], $field, ...$parameters);
        }
    }
    
    public function minLength(string $field, int $length) : bool {
        if (mb_strlen($this->data[$field]) < $length) {
            $this->errors[$field] = "The field must have more than $length characters.";
            return false;
        }
        return true;
    }
    
    public function maxLength(string $field, int $length) : bool {
        if (mb_strlen($this->data[$field]) > $length) {
            $this->errors[$field] = "The field must have less than $length characters.";
            return false;
        }
        return true;
    }
    
  
    public function isMail(string $field) : bool {
        $mail_explode = explode("@",$this->data[$field]);
        if(!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL) && !checkdnsrr(array_pop($mail_explode),"MX")) {
            $this->errors[$field] = "Email address does not appear to be valid.";
            return false;
        }
        return true;
    }
    
    public function existMail(string $field, Contact $table, ?int $id = null) : bool {
        if($table->exists('email', $this->data[$field], "id", $id) === true) {
            $this->errors[$field] = "This email address is already in use.";
            return false;
        }
        return true;
    }    

    public function existPhone(string $field, Contact $table, ?int $id = null) : bool {
        if($table->exists('phone', $this->data[$field], "id", $id) === true) {
            $this->errors[$field] = "This phone number is already in use.";
            return false;
        }
        return true;
    }

}
?>