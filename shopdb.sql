-- Create Database
CREATE DATABASE IF NOT EXISTS shopdb;
USE shopdb;

-- Drop tables if already exist (to avoid duplicates when re-importing)
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS orders;

-- Products Table
CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL, -- price per KG
  weight_kg DECIMAL(10,2) DEFAULT 1.00, -- weight in KG
  category VARCHAR(100),
  image VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Orders Table
CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT,
  customer_name VARCHAR(255),
  quantity INT,
  total_price DECIMAL(10,2),
  status ENUM('Pending','Processing','Completed') DEFAULT 'Pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Insert sample products
INSERT INTO products (name, description, price, weight_kg, category, image) VALUES
('Beef Pack', 'Fresh beef pack', 12000.00, 2.50, 'Meat', 'uploads/beef.jpg'),
('Chicken', 'Farm fresh chicken', 5000.00, 1.80, 'Meat', 'uploads/chicken.jpg'),
('Fish', 'Fresh fish from the market', 6000.00, 3.00, 'Seafood', 'uploads/fish.jpg');

-- Insert sample orders
INSERT INTO orders (product_id, quantity, total_price, customer_name, status)
VALUES
(1, 2, 24000.00, 'John Doe', 'Completed'),
(2, 5, 25000.00, 'Jane Smith', 'Pending'),
(3, 3, 18000.00, 'Michael Lee', 'Processing');
