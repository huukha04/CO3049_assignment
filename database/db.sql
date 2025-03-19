SET time_zone = '+07:00';  -- Việt Nam (UTC+7)



CREATE TABLE IF NOT EXISTS poster (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    description TEXT,
    url VARCHAR(255) NOT NULL,
    start_date DATE NOT NULL,
    expiration_date DATE NOT NULL,
    status ENUM('Coming', 'Showing', 'Ended') DEFAULT 'Coming'
);

CREATE TABLE IF NOT EXISTS deal (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    description TEXT,
    url VARCHAR(255) NOT NULL,
    start_date DATE NOT NULL,
    expiration_date DATE NOT NULL,
    status ENUM('Coming', 'Showing', 'Ended') DEFAULT 'Coming'
);

CREATE TABLE IF NOT EXISTS new (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    url VARCHAR(255) NOT NULL,
    start_date DATE NOT NULL,
    expiration_date DATE NOT NULL,
    status ENUM('Coming', 'Showing', 'Ended') DEFAULT 'Coming'
);



CREATE TABLE IF NOT EXISTS movie (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Mã phim tự tăng
    status ENUM('Coming', 'Showing', 'Ended') DEFAULT 'Coming',
    premiere_date DATE NOT NULL,  -- Ngày khởi chiếu
    expiration_date DATE NOT NULL,  -- Ngày hết hạn (có thể là ngày ngừng chiếu)
    title VARCHAR(255) NOT NULL,  -- Tên phim
    category_code VARCHAR(10) NOT NULL,  -- Mã phân loại phim (VD: T18, T19)
    url VARCHAR(255) NOT NULL,  -- Đường dẫn URL của phim (trang web)

    trailer VARCHAR(255),
    description TEXT ,  -- Mô tả nội dung phim
    time INT,  -- Thời lượng phim (tính bằng phút, VD: 137 phút)
    rating FLOAT ,  -- Điểm đánh giá trung bình (VD: 8.7)
    vote_count INT ,  -- Số lượt đánh giá (VD: 29)
    year INT NOT NULL,  -- Năm sản xuất (VD: 2021)
    country VARCHAR(100) ,  -- Quốc gia sản xuất (VD: Mỹ)
    producer VARCHAR(255) ,  -- Nhà sản xuất (VD: Plan B Entertainment, Warner Bros)
    genre VARCHAR(255) ,  -- Thể loại phim (VD: Hài, Hành Động, Giả Tưởng, Phiêu Lưu)
    director VARCHAR(255) ,  -- Đạo diễn phim (VD: Bong Joon Ho)
    cast TEXT  -- Danh sách diễn viên chính (VD: Robert Pattinson, Mark Ruffalo, Steven Yeun)
);

CREATE TABLE IF NOT EXISTS `user` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    
    role ENUM('customer', 'admin') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    rank ENUM('bronze', 'silver', 'gold') DEFAULT 'bronze',
    point INT DEFAULT 0,
    avatar VARCHAR(255),
    phone VARCHAR(20),
    address VARCHAR(255),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    status ENUM('Active', 'Inactive') DEFAULT 'Active'
);
