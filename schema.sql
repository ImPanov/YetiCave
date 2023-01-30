DROP DATABASE IF EXISTS yeticave;
CREATE DATABASE yeticave
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_0900_ai_ci;

USE yeticave;

CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(128) NOT NULL,
    character_code VARCHAR(128) UNIQUE
);

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    user_name VARCHAR(128),
    user_password CHAR(128),
    email VARCHAR(128) NOT NULL UNIQUE,
    contacts TEXT,
    date_registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE lots (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    title VARCHAR(256),
    lot_description TEXT,
    img VARCHAR(256),
    start_price INT,
    date_finish DATE,
    step INT,
    user_id INT,
    winner_id INT,
    category_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (winner_id) REFERENCES users(id)
);

CREATE TABLE bets (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    date_bet TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    price_bet INT,
    user_id INT,
    lot_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (lot_id) REFERENCES lots(id)
);