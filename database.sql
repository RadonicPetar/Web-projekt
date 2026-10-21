CREATE DATABASE IF NOT EXISTS hardware_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE hardware_store;
CREATE TABLE IF NOT EXISTS users (
 users_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 users_name VARCHAR(100) NOT NULL,
 users_lname VARCHAR(100) NOT NULL,
 users_pwd VARCHAR(255) NOT NULL,
 users_email VARCHAR(254) NOT NULL UNIQUE
);
CREATE TABLE IF NOT EXISTS products (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 title VARCHAR(255) NOT NULL,
 description TEXT NOT NULL,
 price DECIMAL(10,2) NOT NULL,
 img VARCHAR(255) NOT NULL UNIQUE,
 type VARCHAR(100) NOT NULL
);
INSERT IGNORE INTO products (title,description,price,img,type) VALUES
('Intel Core i5-12600K','Intel Core processor. Sample product.',220,'i512600k.png','Processor'),
('NVIDIA GeForce RTX 3060','GeForce graphics card. Sample product.',300,'rtx3060.png','Video Card'),
('AMD Radeon RX 7900 XT','Radeon graphics card. Sample product.',800,'Rx7900xt.png','Video Card'),
('AM5 Motherboard','Motherboard for AM5 processors. Sample product.',200,'am5-motherboard.png','Motherboard'),
('ARMOR V715','Computer case. Sample product.',70,'ARMORV715.png','Case'),
('Corsair Power Supply','Computer power supply. Sample product.',100,'corsairps.png','Power supply'),
('Corsair RAM','RAM module. Sample product.',60,'corsairram.png','RAM'),
('SSD 1 TB','1 TB solid-state drive. Sample product.',75,'ssdata1tb.png','Storage');
