1. Trong đường dẫn (app/core/config.php) thay tên database cũng như các thông tin tuong ứng.
2. file .sql nằm ở database/db.sql
3. Gọi controller bằng ROOT/<filenamme>/<method>
4. Mỗi file trong models tương ứng với 1 table trong database
5. Để dùng gửi mail qua mail() làm theo hướng dẫn https://www.w3docs.com/snippets/php/how-to-configure-xampp-to-send-email-from-localhost-with-php.html
*Note
auth_username=localhost.manager2000@gmail.com
auth_password=trab cmpk wefm gggd
6. PSR-4 Autoloading thì tên clas phải viết hoa giống tên file.php để autoload