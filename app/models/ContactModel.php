<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactModel
{
    use Model;
    private $mail;

    public function __construct() {
        $this->allowedColumns = [];
        $this->table = 'contact';
        $this->message = '';

        $this->mail = new PHPMailer(true);

        // Cấu hình SMTP
        $this->mail->isSMTP();
        $this->mail->Host       = 'smtp.gmail.com'; // Gmail SMTP
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = 'localhost.2211412@gmail.com'; // Gmail
        $this->mail->Password   = 'fpmr ocgt jsov deox'; // App password - nên đổi lại ngay
        $this->mail->SMTPSecure = 'tls';
        $this->mail->Port       = 587;
        $this->mail->CharSet = 'UTF-8';
        $this->mail->setFrom('localhost.2211412@gmail.com', 'Hệ thống rạp CINEMA');
    }

    public function comfirmContact($data) {
        try {
            $recipientEmail = $data['email'];
            $recipientName = $data['name'];
            $subject = $data['subject'];
            $message = $data['message'];

            // Clone mail object để tránh lỗi gửi lại nhiều lần
            $mail = clone $this->mail;

            $mail->addAddress($recipientEmail, $recipientName);
            $mail->isHTML(true);
            $mail->Subject = 'Phản hồi yêu cầu của bạn';
            $mail->Body = "
                <div style='max-width: 600px; margin: auto; border: 1px solid #e0e0e0; border-radius: 8px; font-family: Arial, sans-serif; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);'>
                    <div style='background-color: #007BFF; padding: 20px; color: white; text-align: center;'>
                        <h2 style='margin: 0;'>CINEMA</h2>
                    </div>
                    <div style='padding: 20px; background-color: #ffffff; color: #333;'>
                        <p style='font-size: 16px;'><strong>Xin chào, $recipientName!</strong></p>
                        <p style='font-size: 15px;'>Cảm ơn bạn đã liên hệ với chúng tôi.</p>
                        <h3 style='color: #007BFF; margin-top: 20px;'>Thông tin bạn đã gửi:</h3>
                        <div style='margin-top: 15px; background-color: #f1f1f1; padding: 15px; border-radius: 6px; font-size: 14px; line-height: 1.6;'>
                            <div><strong>Chủ đề:</strong> $subject</div>
                            <div><strong>Nội dung:</strong> $message</div>
                        </div>
                        <p style='margin-top: 25px; font-size: 14px;'>Chúng tôi sẽ phản hồi bạn trong thời gian sớm nhất. Vui lòng không trả lời email này.</p>
                    </div>
                    <div style='background-color: #f9f9f9; text-align: center; padding: 12px; font-size: 12px; color: #999;'>
                        © 2025 CINEMA. All rights reserved.
                    </div>
                </div>
            ";
        

            $mail->AltBody = strip_tags($message);

            $mail->send();
        } catch (Exception $e) {
            echo "Không gửi được email. Lỗi: {$mail->ErrorInfo}";
        }
    }


    public function sendInfoOrder($data) {
        
    }
}
