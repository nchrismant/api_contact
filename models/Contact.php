<?php
namespace App\models\Contact;

class Contact {
    private $conn;
    private $table = 'contacts';

    public ?int $id;
    private string $name;
    private string $firstname;
    private string $email;
    private string $phone;
    private string $adress;
    private int $age;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Get the value of id
     */ 
    public function getId() {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName() {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of firstname
     */ 
    public function getFirstname() {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */ 
    public function setFirstname($firstname) {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of phone
     */ 
    public function getPhone() {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */ 
    public function setPhone($phone) {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of adress
     */ 
    public function getAdress() {
        return $this->adress;
    }

    /**
     * Set the value of adress
     *
     * @return  self
     */ 
    public function setAdress($adress) {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get the value of age
     */ 
    public function getAge() {
        return $this->age;
    }

    /**
     * Set the value of age
     *
     * @return  self
     */ 
    public function setAge($age) {
        $this->age = $age;

        return $this;
    }

    public function read() {
        // Create query
        $query = 'SELECT * FROM contacts';
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
  
        // Execute query
        $stmt->execute();
  
        return $stmt;
    }

    public function exists (string $field, $value, string $primaryName="id", ?int $except = null) : bool {
        $sql = "SELECT COUNT($primaryName) FROM {$this->table} WHERE $field = ?";
        $params = [$value];
        if ($except !== null) {
            $sql .= " AND id != ?";
            $params[] = $except;
        }
        $query = $this->conn->prepare($sql);
        $query->execute($params);
        return (int)$query->fetch(\PDO::FETCH_NUM)[0] > 0;
    }
    

    // Get Single contact
    public function read_single() {
        // Create query
        $query = 'SELECT * FROM contacts WHERE id = ? LIMIT 0,1';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Set properties
        $this->name = $row['name'];
        $this->firstname = $row['firstname'];
        $this->email = $row['email'];
        $this->phone = $row['phone'];
        $this->adress = $row['adress'];
        $this->age = $row['age'];
    }

  // Create contact
  public function create() {
        // Create query
        $query = 'INSERT INTO ' . $this->table . ' SET name = :name, firstname = :firstname, email = :email, phone = :phone, adress = :adress, age = :age';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        if(isset($this->adress)) {
            $this->adress = htmlspecialchars(strip_tags($this->adress));
        }
        $this->age = htmlspecialchars($this->age);

        // Bind data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':adress', $this->adress);
        $stmt->bindParam(':age', $this->age);

        // Execute query
        if($stmt->execute()) {
          return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  // Update contact
  public function update() {
        // Create query
        $query = 'UPDATE ' . $this->table . '
                              SET name = :name, firstname = :firstname, email = :email, phone = :phone, adress = :adress, age = :age
                              WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->adress = htmlspecialchars(strip_tags($this->adress));
        $this->age = htmlspecialchars($this->age);
        $this->id = htmlspecialchars($this->id);

        // Bind data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':adress', $this->adress);
        $stmt->bindParam(':age', $this->age);
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if($stmt->execute()) {
          return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
  }

  // Delete contact
  public function delete() {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->id = htmlspecialchars($this->id);

        // Bind data
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if($stmt->execute()) {
          return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
  }

}
?>