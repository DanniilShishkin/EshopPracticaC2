CREATE DATABASE IF NOT EXISTS eshop;
USE eshop;


CREATE TABLE catalog (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    pubyear INT NOT NULL
);


CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id VARCHAR(50) UNIQUE NOT NULL,
    customer VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address VARCHAR(255) NOT NULL,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE ordered_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id VARCHAR(50) NOT NULL,
    item_id INT NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (item_id) REFERENCES catalog(id)
);


CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


DELIMITER $$

CREATE PROCEDURE spAddItemToCatalog(
    IN p_title VARCHAR(255),
    IN p_author VARCHAR(255),
    IN p_price DECIMAL(10, 2),
    IN p_pubyear INT
)
BEGIN
    INSERT INTO catalog (title, author, price, pubyear)
    VALUES (p_title, p_author, p_price, p_pubyear);
END$$

CREATE PROCEDURE spGetCatalog()
BEGIN
    SELECT * FROM catalog;
END$$

CREATE PROCEDURE spGetItemsForBasket(
    IN p_item_ids JSON
)
BEGIN
    SELECT id, title, author, price, pubyear
    FROM catalog
    WHERE JSON_CONTAINS(p_item_ids, CAST(id AS JSON));
END$$

CREATE PROCEDURE spSaveOrder(
    IN p_order_id VARCHAR(50),
    IN p_customer VARCHAR(255),
    IN p_email VARCHAR(255),
    IN p_phone VARCHAR(20),
    IN p_address VARCHAR(255)
)
BEGIN
    INSERT INTO orders (order_id, customer, email, phone, address, created)
    VALUES (p_order_id, p_customer, p_email, p_phone, p_address, NOW());
END$$

CREATE PROCEDURE spSaveOrderedItems(
    IN p_order_id VARCHAR(50),
    IN p_item_id INT,
    IN p_quantity INT
)
BEGIN
    INSERT INTO ordered_items (order_id, item_id, quantity)
    VALUES (p_order_id, p_item_id, p_quantity);
END$$

CREATE PROCEDURE spGetOrders()
BEGIN
    SELECT * FROM orders;
END$$

CREATE PROCEDURE spGetOrderedItems(
    IN p_order_id VARCHAR(50)
)
BEGIN
    SELECT oi.id, oi.order_id, oi.item_id, oi.quantity, c.title, c.author, c.price, c.pubyear
    FROM ordered_items oi
    JOIN catalog c ON oi.item_id = c.id
    WHERE oi.order_id = p_order_id;
END$$

CREATE PROCEDURE spSaveAdmin(
    IN p_login VARCHAR(255),
    IN p_password VARCHAR(255),
    IN p_email VARCHAR(255)
)
BEGIN
    INSERT INTO admins (login, password, email, created)
    VALUES (p_login, p_password, p_email, NOW());
END$$

CREATE PROCEDURE spGetAdmin(
    IN p_login VARCHAR(255)
)
BEGIN
    SELECT * FROM admins WHERE login = p_login;
END$$

DELIMITER ;

