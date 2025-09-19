-- =========================
-- Create Database
-- =========================
CREATE DATABASE IF NOT EXISTS shopdb;
USE shopdb;

-- =========================
-- Drop existing tables
-- =========================
DROP TABLE IF EXISTS payments;
DROP TABLE IF EXISTS activity;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS users;

-- =========================
-- Activity Table
-- =========================
CREATE TABLE activity (
  id INT AUTO_INCREMENT PRIMARY KEY,
  type VARCHAR(50) NOT NULL,           -- 'product', 'order', 'payment'
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- Products Table
-- =========================
CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL,
  category VARCHAR(100),
  image VARCHAR(255),
  status ENUM('Available','Out of Stock') DEFAULT 'Available',
  special_offer ENUM('Yes','No') DEFAULT 'No',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL,
  deleted_at TIMESTAMP NULL
);

-- =========================
-- Users Table
-- =========================
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','user') DEFAULT 'user',
  status ENUM('Active','Inactive') DEFAULT 'Active',
  email VARCHAR(255),
  phone VARCHAR(50),
  location VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL,
  deleted_at TIMESTAMP NULL
);

-- =========================
-- Orders Table
-- =========================
CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product VARCHAR(255) NOT NULL,       -- store product name for simplicity
  product_id INT NULL,                 -- link to products table
  customer VARCHAR(255) NOT NULL,
  quantity INT NOT NULL,
  deadline DATE,
  status ENUM('Pending','Processing','Completed','Cancelled') DEFAULT 'Pending',
  value DECIMAL(10,2) NOT NULL,
  address VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
);

-- =========================
-- Payments Table
-- =========================
CREATE TABLE payments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  customer VARCHAR(255) NOT NULL,
  product VARCHAR(255) NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  method ENUM('Credit Card','Bank Transfer','USSD','Wallet','Cash') NOT NULL,
  txn_id VARCHAR(100) NOT NULL UNIQUE,
  status ENUM('Successful','Pending','Failed','Refunded') DEFAULT 'Pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

-- =========================
-- Sample Products
-- =========================
INSERT INTO products (name, description, price, category, image, status, special_offer) VALUES
('Beef Pack', 'Fresh beef pack', 12000.00, 'Meat', 'uploads/beef.jpg', 'Available', 'No'),
('Chicken', 'Farm fresh chicken', 5000.00, 'Meat', 'uploads/chicken.jpg', 'Available', 'Yes'),
('Fish', 'Fresh fish from the market', 6000.00, 'Seafood', 'uploads/fish.jpg', 'Available', 'No');

-- =========================
-- Sample Users
-- =========================
INSERT INTO users (username, password, role, status, email, phone, location) VALUES
('admin', '$2y$10$adminhashplaceholder', 'admin', 'Active', 'admin@example.com', '08011112222', 'Lagos'),
('user1', '$2y$10$user1hashplaceholder', 'user', 'Active', 'user1@example.com', '08033334444', 'Ikeja');

-- =========================
-- Sample Orders
-- =========================
INSERT INTO orders (product, product_id, quantity, deadline, status, value, customer, address) VALUES
('Beef Pack', 1, 2, '2024-09-20', 'Completed', 24000.00, 'John Doe', '12 Broad Street, Lagos'),
('Chicken', 2, 5, '2024-09-22', 'Pending', 25000.00, 'Jane Smith', '45 Allen Avenue, Ikeja'),
('Fish', 3, 3, '2024-09-25', 'Processing', 18000.00, 'Michael Lee', '78 Admiralty Way, Lekki'),
-- Meat-Sharing Orders
('Beef Pack', 1, 3, '2024-09-26', 'Pending', 36000.00, 'Alice Johnson', '23 Victoria Island, Lagos'),
('Chicken', 2, 2, '2024-09-27', 'Processing', 10000.00, 'Bob Smith', '56 Lekki Phase 1, Lagos'),
('Beef Pack', 1, 1, '2024-09-28', 'Pending', 12000.00, 'Cynthia Brown', '78 Ikoyi, Lagos');

-- =========================
-- Sample Payments
-- =========================
INSERT INTO payments (order_id, customer, product, amount, method, txn_id, status) VALUES
(1, 'John Doe', 'Beef Pack', 24000.00, 'Credit Card', 'TXN123456789', 'Successful'),
(2, 'Jane Smith', 'Chicken', 25000.00, 'Bank Transfer', 'TXN987654321', 'Pending'),
(3, 'Michael Lee', 'Fish', 18000.00, 'Credit Card', 'TXN192837465', 'Failed'),
(1, 'John Doe', 'Beef Pack', 24000.00, 'Bank Transfer', 'TXN564738291', 'Successful'),
(2, 'Jane Smith', 'Chicken', 25000.00, 'Credit Card', 'TXN837465920', 'Successful'),
-- Payments for Meat-Sharing Orders
(4, 'Alice Johnson', 'Beef Pack', 36000.00, 'USSD', 'TXN555666777', 'Pending'),
(5, 'Bob Smith', 'Chicken', 10000.00, 'Credit Card', 'TXN888999000', 'Processing'),
(6, 'Cynthia Brown', 'Beef Pack', 12000.00, 'Wallet', 'TXN111222333', 'Pending');

-- =========================
-- Sample Activity
-- =========================
INSERT INTO activity (type, message) VALUES
('product', 'New product <b>Beef Pack</b> added'),
('product', 'New product <b>Chicken</b> added'),
('order', 'New order <b>Beef Pack</b> by <b>John Doe</b> added'),
('order', 'New order <b>Chicken</b> by <b>Jane Smith</b> added'),
('order', 'New order <b>Beef Pack</b> by <b>Alice Johnson</b> added'),
('payment', 'Payment <b>TXN123456789</b> recorded for <b>John Doe</b>'),
('payment', 'Payment <b>TXN555666777</b> recorded for <b>Alice Johnson</b>');
