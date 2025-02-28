-- Create the database
CREATE DATABASE BancoFassil;

USE BancoFassil;

-- Table Person
CREATE TABLE
    Person (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        phone VARCHAR(20)
    );

-- Table User
CREATE TABLE
    User (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL, -- Hash bcrypt
        personId INT UNIQUE NOT NULL,
        hasCard BOOLEAN DEFAULT FALSE,
        enabledForOnlinePurchases BOOLEAN DEFAULT FALSE,
        status ENUM ('AC', 'IN', 'B') DEFAULT 'AC' COMMENT 'AC: Active, IN: Inactive, B: Blocked',
        FOREIGN KEY (personId) REFERENCES Person (id) ON DELETE CASCADE
    );

-- Table Office
CREATE TABLE
    Office (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        address VARCHAR(100) NOT NULL,
        type ENUM ('C', 'A') NOT NULL COMMENT 'C: Central, A: Agency'
    );

-- Table Account
CREATE TABLE
    Account (
        id INT AUTO_INCREMENT PRIMARY KEY,
        currentBalance DECIMAL(10, 2) DEFAULT 0.00,
        type ENUM ('CA', 'CC') NOT NULL COMMENT 'CA: Current Account, CC: Savings Account',
        status ENUM ('AC', 'IN') DEFAULT 'AC' COMMENT 'AC: Active, IN: Inactive',
        personId INT NOT NULL,
        officeId INT NOT NULL,
        FOREIGN KEY (personId) REFERENCES Person (id) ON DELETE CASCADE,
        FOREIGN KEY (officeId) REFERENCES Office (id) ON DELETE CASCADE
    );

-- Table Card
CREATE TABLE
    Card (
        id INT AUTO_INCREMENT PRIMARY KEY,
        cardNumber VARCHAR(16) UNIQUE NOT NULL,
        expirationDate VARCHAR(5) NOT NULL COMMENT 'Format: MM/YY',
        cardType ENUM ('D', 'C') NOT NULL COMMENT 'D: Debit, C: Credit',
        cvv VARCHAR(3) NOT NULL,
        pin VARCHAR(4) NOT NULL COMMENT 'Hash',
        accountId INT UNIQUE NOT NULL,
        failedAttempts INT DEFAULT 0,
        FOREIGN KEY (accountId) REFERENCES Account (id) ON DELETE CASCADE
    );

-- Table Transaction
CREATE TABLE
    Transaction (
        id INT AUTO_INCREMENT PRIMARY KEY,
        type ENUM ('D', 'W', 'P') NOT NULL COMMENT 'D: Deposit, W: Withdrawal, P: Payment',
        previousBalance DECIMAL(10, 2) NOT NULL,
        newBalance DECIMAL(10, 2) NOT NULL,
        amount DECIMAL(10, 2) NOT NULL,
        commentSystem VARCHAR(255) COMMENT 'System-generated comments',
        description VARCHAR(255) COMMENT 'User-provided description',
        accountId INT NOT NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (accountId) REFERENCES Account (id) ON DELETE CASCADE
    );

-- Table Token
CREATE TABLE
    Token (
        id INT AUTO_INCREMENT PRIMARY KEY,
        token VARCHAR(255) UNIQUE NOT NULL,
        type ENUM ('ATM', 'OL') NOT NULL COMMENT 'ATM: Automatic Teller Machine, OL: Online',
        expirationDate DATETIME NOT NULL,
        userId INT NOT NULL,
        FOREIGN KEY (userId) REFERENCES User (id) ON DELETE CASCADE
    );

-- Indexes for better performance
CREATE INDEX idx_person_email ON Person (email);

CREATE INDEX idx_user_username ON User (username);

CREATE INDEX idx_user_personId ON User (personId);

CREATE INDEX idx_card_cardNumber ON Card (cardNumber);

CREATE INDEX idx_token_token ON Token (token);

/**
DROPS EN REVERSA COMMENT
DROP INDEX idx_token_token ON Token;
DROP INDEX idx_card_cardNumber ON Card;
DROP INDEX idx_user_personId ON User;
DROP INDEX idx_user_username ON User;
DROP INDEX idx_person_email ON Person;
DROP TABLE Token;
DROP TABLE Transaction;
DROP TABLE Card;
DROP TABLE Account;
DROP TABLE Office;
DROP TABLE User;
DROP TABLE Person;


DROP DATABASE BancoFassil;
*/