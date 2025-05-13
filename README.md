Dưới đây là nội dung chuyển từ hướng dẫn cài đặt sang file `README.md` cho dự án **CO3049_assignment**:  

---

```markdown
# CO3049_assignment

## 1. Cài đặt XAMPP

### Bước 1: Tải và cài đặt XAMPP

- Truy cập trang web chính thức của XAMPP: [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html)  
- Tải và cài đặt phiên bản mới nhất (XAMPP for Windows 8.2.12 (PHP 8.2.12) - cập nhật ngày 08/05/2025).

### Bước 2: Cấu hình thư mục Web Root

- Mặc định, thư mục Web Root của XAMPP là `C:/xampp/htdocs`.  
- Để thay đổi đường dẫn này:  
  1. Mở file `httpd.conf` (mặc định tại: `C:/xampp/apache/conf/httpd.conf`).  
  2. Tìm dòng chứa `C:/xampp/htdocs` và sửa thành đường dẫn tới thư mục Web Root mới của bạn (nếu cần).  

### Bước 3: Tải và sao chép dự án

- Tải thư mục chứa dự án từ GitHub:  
  - [CO304_assignment](https://github.com/huukha04/CO304_assignment)  
  - [CO3049_assignment](https://github.com/huukha04/CO3049_assignment)  
- Đặt các thư mục này vào thư mục Web Root.  

### Bước 4: Khởi động ứng dụng

- Mở trình duyệt và truy cập vào địa chỉ:  
  ```
  http://localhost/CO3049_assignment/public/
  ```

### Bước 5: Quản lý cơ sở dữ liệu

- Truy cập phpMyAdmin để quản lý cơ sở dữ liệu tại:  
  ```
  http://localhost/phpmyadmin/
  ```
- Thêm các file `.sql` để tạo và thiết lập cơ sở dữ liệu cho dự án.  

---

## 2. Cấu hình dự án

### Bước 1: Cấu hình database

- Mở file `CO3049_assignment/app/core/Config.php`.  
- Cập nhật các thông số kết nối cơ sở dữ liệu, đặc biệt là `DBNAME` (tên database).  

### Bước 2: Cấu hình PayOS (Tùy chọn)

- Để sử dụng tính năng thanh toán chuyển khoản:  
  1. Đăng ký dịch vụ tại [PayOS](https://my.payos.vn).  
  2. Thiết lập các giá trị `CLIENT_ID`, `API_KEY`, `CHECKSUM_KEY` tương ứng với thông tin dịch vụ cung cấp trong file `Config.php`.  

---

## 3. Hỗ trợ

- Nếu gặp vấn đề khi cài đặt hoặc sử dụng, vui lòng liên hệ qua email hoặc tạo issue trên GitHub.  

---

## 4. License

- Dự án này được phát hành dưới [MIT License](https://opensource.org/licenses/MIT).  

```

---

Bạn muốn mình giúp chỉnh lại README để trông chuyên nghiệp hơn không? 😊
