
<?php
class Auth
{
    use Controller;

    public function index() {
        $user = $_SESSION['USER'] ?? null;
        if ($user && isset($user->type)) {
            if ($user->type == "admin") {
                redirect('admin/home');
            } else if ($user->type == "customer") {
                redirect('customer/home');
            }
        }
    
        $this->view('auth/home');
        
    }
    public function get_otp_register() {
        header('Content-Type: application/json'); 
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            echo json_encode(["error" => "Phương thức không hợp lệ"]);
            exit;
        }
    
        $otpModel = new OtpModel;
        $userModel = new UserModel;
    
        // Kiểm tra email đã tồn tại hay chưa
        if ($userModel->get_user($_POST)) {
            echo json_encode(["success" => false, "message" => "Email đã tồn tại"]);
            exit;
        }
    
        // Gửi OTP
        $otp = $otpModel->send_otp($_POST);
    
        // Trả về JSON gọn gàng
        if ($otp === true) {
            echo json_encode(["success" => true, "message" => "OTP của bạn đã được gửi"]);
        } else {
            echo json_encode(["success" => false, "message" => "OTP của bạn gửi không thành công"]);
        }
        exit;
    }
    public function register() {
        $data = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userModel = new UserModel;
            $otpModel = new OtpModel;
            if ($otpModel->verify_otp($_POST)) {
                $userModel->insert($_POST);
                redirect('auth/login');
            }

            $data['errors'] = $otpModel->message;

        }

        $this->view('auth/register', $data);
    }      
    public function login() {
        $data = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new UserModel;
            $arr['email'] = $_POST['email'] ?? null;
            $arr['user_name'] = $_POST['user_name'] ?? null;

            $row = $user->get_user($arr);

            if ($row) {
                if ($row->password === $_POST['password']) {
                    $_SESSION['USER'] = $row;
                    redirect('auth/home');
                }
            }

            $user->message['error'] = "Wrong email or password";
            $data['errors'] = $user->message;
        }
        $this->view('auth/login', $data);
        
    }

    
    public function get_otp_forgot() {
        header('Content-Type: application/json'); 
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            echo json_encode(["error" => "Phương thức không hợp lệ"]);
            exit;
        }
    
        $otpModel = new OtpModel;
        $userModel = new UserModel;
    
        // Kiểm tra email đã tồn tại hay chưa
        if (!$userModel->get_user($_POST)) {
            echo json_encode(["success" => false, "message" => "Tài khoản không tồn tại"]);
            exit;
        }
    
        // Gửi OTP
        $otp = $otpModel->send_otp($_POST);
    
        // Trả về JSON gọn gàng
        if ($otp === true) {
            echo json_encode(["success" => true, "message" => "OTP của bạn đã được gửi"]);
        } else {
            echo json_encode(["success" => false, "message" => "OTP của bạn gửi không thành công"]);
        }
        exit;
    }
    public function forgot_password() {
        $data = [];
        $userModel = new UserModel;
        $otpModel = new OtpModel;
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Kiểm tra xem có dữ liệu hợp lệ không
            if (empty($_POST['email'])) {
                $data['errors'][] = "Vui lòng nhập email.";
            } else {
                $user = $userModel->get_user($_POST);
                
                if (!$user) {
                    $data['errors'][] = "Email không tồn tại.";
                } else {
                    $otpVerified = $otpModel->verify_otp($_POST);
                    
                    if ($otpVerified) {
                        $_SESSION['USER'] = $user->user;
                        redirect('auth/reset_password');
                        exit; // Đảm bảo không chạy tiếp
                    } else {
                        $data['errors'][] = "OTP không chính xác.";
                    }
                }
            }
        }
    
        $this->view('auth/forgot_password', $data);
    }
    
    public function reset_password() {
        $data = [];
        $user_name = $_SESSION['USER']->user_name ?? null;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($_POST['new_password'] !== $_POST['confirm_password']) {
                $data['errors'][] = "Mật khẩu không khớp.";
            } else {
                $userModel = new UserModel;
                $password = ['password' => $_POST['new_password']];
                $user = $userModel->get_user(['user_name' => $user_name]);
                if ($user) {
                    $userModel->update($user->id, $password);
                    session_destroy();
                    
                    redirect('auth/login');
                }
            }
            $data['errors'][] = "Lỗi";
        }
        
        $this->view('auth/reset_password', $data);
    }

    public function logout() {
        session_destroy();
        redirect('auth/home');
    }
    
}
