CREATE DATABASE homeguardian;
USE homeguardian;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50),
  email VARCHAR(100),
  password VARCHAR(255)
);

CREATE TABLE home_status (
  id INT PRIMARY KEY,
  water BOOLEAN,
  electricity BOOLEAN,
  camera BOOLEAN
);

CREATE TABLE activities (
  id INT AUTO_INCREMENT PRIMARY KEY,
  message VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO home_status VALUES (1, 0, 1, 1);
