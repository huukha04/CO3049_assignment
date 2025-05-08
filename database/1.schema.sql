DROP DATABASE IF EXISTS db;
CREATE DATABASE db;
USE db;

-- Thiết lập múi giờ Việt Nam (UTC+7)
SET time_zone = '+07:00';  -- Việt Nam (UTC+7)

-- Bảng Users (Khách hàng và Quản trị viên)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE ,
    email VARCHAR(100) UNIQUE ,
    password VARCHAR(100) ,
    role ENUM('admin', 'customer') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    name VARCHAR(100),
    phone VARCHAR(20),
    address VARCHAR(255),
    id_card VARCHAR(50),
    point INT DEFAULT 0,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS user_token (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    selector CHAR(20) NOT NULL,
    hashed_validator CHAR(64) NOT NULL,
    type ENUM('activation', 'reset', 'login') NOT NULL,
    expires_at DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (selector)
);

CREATE TABLE IF NOT EXISTS media (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255),
    title VARCHAR(255),
    description TEXT,
    type ENUM('movie', 'poster', 'deal') default 'movie',
    status ENUM('showing', 'hidden') DEFAULT 'hidden',

    start_date DATE ,
    end_date DATE ,
    duration INT,  -- Thời lượng phim (phút)
    genre VARCHAR(100),  -- Thể loại phim
    trailer VARCHAR(500),  -- URL trailer phim
    language VARCHAR(50),  -- Ngôn ngữ phim
    country VARCHAR(100),  -- Quốc gia sản xuất
    classification ENUM('P', 'K', 'T13', 'T16', 'T18', 'C') DEFAULT 'C',  -- Phân loại phim

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng Cinema (Rạp chiếu phim)
CREATE TABLE IF NOT EXISTS cinema (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) ,
    location VARCHAR(255) ,
    open_time TIME ,
    close_time TIME 
);

-- Bảng Room (Phòng chiếu)
CREATE TABLE IF NOT EXISTS room (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cinema_id INT ,
    name VARCHAR(100)
);

-- Bảng Seat (Ghế ngồi)
CREATE TABLE IF NOT EXISTS seat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_id INT,
    code VARCHAR(10),
    row INT,
    col INT,  
    type ENUM('standard', 'vip', 'couple', 'maintenance', 'none') DEFAULT 'standard',  
    price DECIMAL(10,2)
);

-- Bảng Showtime (Suất chiếu)
CREATE TABLE IF NOT EXISTS showtime (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_id INT,
    media_id INT ,
    date DATE ,

    start_time DATETIME ,
    end_time DATETIME
);

CREATE TABLE IF NOT EXISTS product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cinema_id INT,
    name VARCHAR(100),
    price DECIMAL(10,2),
    type ENUM('popcorn', 'drink', 'food', 'combo', 'other') DEFAULT 'other',
    status ENUM('available', 'unavailable') DEFAULT 'available',
    quantity INT DEFAULT 999,
    has_stock BOOLEAN DEFAULT FALSE
);

CREATE TABLE IF NOT EXISTS `order` (
    user_id INT,
    email VARCHAR(255) ,
    name VARCHAR(100),
    order_code INT  PRIMARY KEY,
    total_price DECIMAL(10,2) ,
    status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS orderDetail (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_code INT ,
    showtime_id INT,
    seat_id INT,
    product_id INT,
    quantity INT ,
    status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS payment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_code INT ,
    total_price DECIMAL(10,2) ,
    status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE IF NOT EXISTS contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT,
    name VARCHAR(100),
    email VARCHAR(255) ,
    phone VARCHAR(20),
    subject VARCHAR(255),
    message TEXT,
    status ENUM('pending', 'in_progress', 'completed') DEFAULT 'pending',
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);








