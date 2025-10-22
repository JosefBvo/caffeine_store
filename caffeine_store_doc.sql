--Database code 

--Contains SQL used to create database for caffeine store project 

--Users table
CREATE TABLE Users (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NULL,
    address VARCHAR(255) NULL,
    role ENUM('customer', 'admin') DEFAULT 'customer'
);


--SKU (Products) table
CREATE TABLE SKU (
    skuID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stockQuantity INT NOT NULL DEFAULT 0
);

--Orders table
CREATE TABLE Orders (
    orderID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT NOT NULL,
    orderDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) NOT NULL DEFAULT 'Pending',
    FOREIGN KEY (userID) REFERENCES Users(userID)
);


--OrderLines table
CREATE TABLE OrderLines (
    orderLineID INT AUTO_INCREMENT PRIMARY KEY,
    orderID INT NOT NULL,
    skuID INT NOT NULL,
    quantity INT NOT NULL CHECK (quantity > 0),
    FOREIGN KEY (orderID) REFERENCES Orders(orderID),
    FOREIGN KEY (skuID) REFERENCES SKU(skuID)
);

--view order totals 
CREATE VIEW v_OrderTotals AS
SELECT 
    o.orderID,
    o.userID,
    CONCAT(u.firstName, ' ', u.lastName) AS customerName,
    o.orderDate,
    o.status,
    SUM(ol.quantity * s.price) AS totalPrice
FROM Orders o
JOIN Users u ON o.userID = u.userID
JOIN OrderLines ol ON o.orderID = ol.orderID
JOIN SKU s ON ol.skuID = s.skuID
GROUP BY o.orderID;

--view product sales 
CREATE VIEW v_ProductSales AS
SELECT 
    s.skuID,
    s.name AS productName,
    SUM(ol.quantity) AS totalSold,
    SUM(ol.quantity * s.price) AS totalRevenue
FROM SKU s
JOIN OrderLines ol ON s.skuID = ol.skuID
GROUP BY s.skuID;

--view customer order history 
CREATE VIEW v_CustomerOrderHistory AS
SELECT 
    u.userID,
    CONCAT(u.firstName, ' ', u.lastName) AS customerName,
    o.orderID,
    o.orderDate,
    o.status,
    SUM(ol.quantity * s.price) AS totalSpent
FROM Users u
JOIN Orders o ON u.userID = o.userID
JOIN OrderLines ol ON o.orderID = ol.orderID
JOIN SKU s ON ol.skuID = s.skuID
GROUP BY o.orderID;

INSERT INTO Users (firstName, lastName, username, email, password, phone, address, role)
VALUES
('enutrof', 'namor', 'namorenutrof', 'namorenutrof@example.com', 'adminpass123', '888-888-8888', '2077 Admin street', 'admin'),
('Bob', 'bobington', 'bob_customer', 'bob.bobington@example.com', 'custpass456', '888-888-8887', '2023 Customer Rd', 'customer');


INSERT INTO SKU (name, description, price, stockQuantity)
VALUES
('Ospuze Energy Drink ', 'A 12oz can of high-caffeine energy drink', 2.99, 150),
('Coffee that makes u scream', '1 lb bag of dark roast coffee beans.', 21.99, 60);

INSERT INTO Orders (userID, orderDate, status)
VALUES
(1, '2025-10-22 09:30:00', 'Completed'),  -- enutrof's order
(2, '2025-10-22 10:00:00', 'Completed');  -- Bob's ord

INSERT INTO OrderLines (orderID, skuID, quantity)
VALUES
(1, 1, 30),  -- enutrof bought 30 energy drinks
(2, 2, 1);  -- Bob bought 1 bag of coffee beans