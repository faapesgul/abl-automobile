-- Tabel Customer
CREATE TABLE customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) UNIQUE NOT NULL,
    address TEXT
);

-- Tabel Product (Mobil)
CREATE TABLE automobiles (
    automobile_id INT AUTO_INCREMENT PRIMARY KEY,
    make VARCHAR(50) NOT NULL,   -- Merek (Toyota, Honda, dll.)
    model VARCHAR(50) NOT NULL,  -- Model (Camry, Civic, dll.)
    year INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    status ENUM('available', 'sold') DEFAULT 'available'
);

-- Tabel Order (Penjualan)
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    automobile_id INT NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_price DECIMAL(10,2) NOT NULL,
    payment_method ENUM('cash', 'credit') NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id),
    FOREIGN KEY (automobile_id) REFERENCES Automobiles(automobile_id)
);
