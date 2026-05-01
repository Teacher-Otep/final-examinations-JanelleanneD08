CREATE DATABASE IF NOT EXISTS dbstudents;
USE dbstudents;

-- Create the students table
CREATE TABLE IF NOT EXISTS students (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    surname VARCHAR(100) NOT NULL,
    middlename VARCHAR(100) NULL DEFAULT NULL,
    address TEXT NULL DEFAULT NULL,
    contact_number VARCHAR(20) NULL DEFAULT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
