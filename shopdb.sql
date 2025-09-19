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
DROP TABLE IF EXISTS employees;
DROP TABLE IF EXISTS system_settings;

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
-- Employees Table
-- =========================
CREATE TABLE employees (
  id INT AUTO_INCREMENT PRIMARY KEY,
  emp_id VARCHAR(10) NOT NULL UNIQUE,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  phone VARCHAR(20),
  status ENUM('Active','Inactive') DEFAULT 'Active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- System Settings Table
-- =========================
CREATE TABLE system_settings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  system_language VARCHAR(50) DEFAULT 'English',
  admin_theme VARCHAR(20) DEFAULT 'Light',
  timezone VARCHAR(50) DEFAULT 'GMT',
  currency VARCHAR(20) DEFAULT 'USD ($)',
  system_font VARCHAR(50) DEFAULT 'Hanken Grotesk',
  allow_signup TINYINT(1) DEFAULT 1,
  user_theme VARCHAR(20) DEFAULT 'Light',
  datetime_format VARCHAR(20) DEFAULT 'DD/MM/YYYY',
  notifications TINYINT(1) DEFAULT 1,
  dashboard_layout VARCHAR(20) DEFAULT 'Spacious',
  update_frequency VARCHAR(20) DEFAULT 'Monthly',
  security_frequency VARCHAR(20) DEFAULT 'Weekly',
  log_format VARCHAR(50) DEFAULT 'CSV,PDF,XLS'
);

-- =========================
-- Default System Settings Row
-- =========================
INSERT INTO system_settings (
  system_language, admin_theme, timezone, currency, system_font, allow_signup, user_theme, datetime_format, notifications, dashboard_layout, update_frequency, security_frequency, log_format
) VALUES (
  'English','Light','GMT','USD ($)','Hanken Grotesk',1,'Light','DD/MM/YYYY',1,'Spacious','Monthly','Weekly','CSV,PDF,XLS'
);

-- =========================
-- Orders Table
-- =========================
CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product VARCHAR(255) NOT NULL,
  product_id INT NULL,
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
-- Sample Employees
-- =========================
INSERT INTO employees (emp_id, name, email, phone, status) VALUES
('EMP001', 'John Doe', 'john@example.com', '+2348012345678', 'Active'),
('EMP002', 'Jane Smith', 'jane@example.com', '+2348098765432', 'Active');

-- =========================
-- Sample Orders
-- =========================
INSERT INTO orders (product, product_id, quantity, deadline, status, value, customer, address) VALUES
('Beef Pack', 1, 2, '2024-09-20', 'Completed', 24000.00, 'John Doe', '12 Broad Street, Lagos'),
('Chicken', 2, 5, '2024-09-22', 'Pending', 25000.00, 'Jane Smith', '45 Allen Avenue, Ikeja'),
('Fish', 3, 3, '2024-09-25', 'Processing', 18000.00, 'Michael Lee', '78 Admiralty Way, Lekki');

-- =========================
-- Sample Payments
-- =========================
INSERT INTO payments (order_id, customer, product, amount, method, txn_id, status) VALUES
(1, 'John Doe', 'Beef Pack', 24000.00, 'Credit Card', 'TXN123456789', 'Successful'),
(2, 'Jane Smith', 'Chicken', 25000.00, 'Bank Transfer', 'TXN987654321', 'Pending'),
(3, 'Michael Lee', 'Fish', 18000.00, 'Credit Card', 'TXN192837465', 'Failed');

-- =========================
-- Sample Activity
-- =========================
INSERT INTO activity (type, message) VALUES
('product', 'New product <b>Beef Pack</b> added'),
('product', 'New product <b>Chicken</b> added'),
('order', 'New order <b>Beef Pack</b> by <b>John Doe</b> added'),
('order', 'New order <b>Chicken</b> by <b>Jane Smith</b> added'),
('payment', 'Payment <b>TXN123456789</b> recorded for <b>John Doe</b>');
