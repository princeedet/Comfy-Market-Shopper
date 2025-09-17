-- Create Database
CREATE DATABASE IF NOT EXISTS shopdb;
USE shopdb;

-- Drop tables if already exist
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS users;

-- Products Table
CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL,
  category VARCHAR(100),
  image VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Users Table (with location)
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','user') DEFAULT 'user',
  status ENUM('Active','Inactive') DEFAULT 'Active',
  email VARCHAR(255),
  phone VARCHAR(50),
  location VARCHAR(255),          -- Added location column
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Orders Table
CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT NOT NULL,
  customer_name VARCHAR(255) NOT NULL,
  customer_email VARCHAR(255),
  customer_phone VARCHAR(50),
  delivery_address VARCHAR(255),
  quantity INT NOT NULL,
  total_price DECIMAL(10,2) NOT NULL,
  status ENUM('Pending','Processing','Completed') DEFAULT 'Pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Sample products
INSERT INTO products (name, description, price, category, image) VALUES
('Beef Pack', 'Fresh beef pack', 12000.00, 'Meat', 'uploads/beef.jpg'),
('Chicken', 'Farm fresh chicken', 5000.00, 'Meat', 'uploads/chicken.jpg'),
('Fish', 'Fresh fish from the market', 6000.00, 'Seafood', 'uploads/fish.jpg');

-- Sample users (with location)
INSERT INTO users (username, password, role, status, email, phone, location) VALUES
('admin', '$2y$10$adminhashplaceholder', 'admin', 'Active', 'admin@example.com', '08011112222', 'Lagos'),
('user1', '$2y$10$user1hashplaceholder', 'user', 'Active', 'user1@example.com', '08033334444', 'Ikeja');

-- Sample orders
INSERT INTO orders (product_id, quantity, total_price, customer_name, customer_email, customer_phone, delivery_address, status) VALUES
(1, 2, 24000.00, 'John Doe', 'john@example.com', '08012345678', '12 Broad Street, Lagos', 'Completed'),
(2, 5, 25000.00, 'Jane Smith', 'jane@example.com', '08098765432', '45 Allen Avenue, Ikeja', 'Pending'),
(3, 3, 18000.00, 'Michael Lee', 'michael@example.com', '08123456789', '78 Admiralty Way, Lekki', 'Processing');
