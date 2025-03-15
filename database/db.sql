SET time_zone = '+07:00';  -- Việt Nam (UTC+7)



CREATE TABLE IF NOT EXISTS poster (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Mã poster tự tăng
    expiration_date DATE NOT NULL,  -- Ngày hết hạn của poster
    url VARCHAR(255) NOT NULL  -- Đường dẫn URL của poster (ảnh)
);


CREATE TABLE IF NOT EXISTS movie (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Mã phim tự tăng
    title VARCHAR(255) NOT NULL,  -- Tên phim
    description TEXT NOT NULL,  -- Mô tả nội dung phim
    premiere_date DATE NOT NULL,  -- Ngày khởi chiếu
    expiration_date DATE NOT NULL,  -- Ngày hết hạn (có thể là ngày ngừng chiếu)
    time INT NOT NULL,  -- Thời lượng phim (tính bằng phút, VD: 137 phút)
    category_code VARCHAR(10) NOT NULL,  -- Mã phân loại phim (VD: T18, T19)
    url VARCHAR(255) NOT NULL,  -- Đường dẫn URL của phim (trang web)
    rating FLOAT NOT NULL,  -- Điểm đánh giá trung bình (VD: 8.7)
    vote_count INT NOT NULL,  -- Số lượt đánh giá (VD: 29)
    country VARCHAR(100) NOT NULL,  -- Quốc gia sản xuất (VD: Mỹ)
    producer VARCHAR(255) NOT NULL,  -- Nhà sản xuất (VD: Plan B Entertainment, Warner Bros)
    genre VARCHAR(255) NOT NULL,  -- Thể loại phim (VD: Hài, Hành Động, Giả Tưởng, Phiêu Lưu)
    director VARCHAR(255) NOT NULL,  -- Đạo diễn phim (VD: Bong Joon Ho)
    cast TEXT NOT NULL  -- Danh sách diễn viên chính (VD: Robert Pattinson, Mark Ruffalo, Steven Yeun)
);


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('customer', 'admin') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
