CREATE TABLE contacts (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  firstname VARCHAR(255) NOT NULL,
  email VARCHAR(250) NOT NULL UNIQUE,
  phone VARCHAR(250) NOT NULL UNIQUE,
  adress VARCHAR(255) NOT NULL,
  age INT NOT NULL,
  PRIMARY KEY (id)
);

INSERT INTO contacts (id, name, firstname, email, phone, adress, age) VALUES
(1, 'Smith', 'Sam', 'sam.smith@gmail.com', '0105256787', '7th Down Street', 25),
(2, 'Williams', 'Kevin', 'kevin.williams@gmail.com', '0625487956', '9th Top Street', 36),
(3, 'Martin', 'Jack', 'jack.martin@gmail.com', '0852658777', '8th London River', 20),
(4, 'Henry', 'Evelyn', 'evelyn.henry@hotmail.fr', '0625756912', '15th Campus Road', 24),
(5, 'Jackson', 'Mary', 'mary.jackson@hotmail.fr', '0756842651', '1st East Street', 42),
(6, 'Jones', 'Kevin', 'kevin.jones@gmail.com', '0155522367', '10th Down Street', 52);