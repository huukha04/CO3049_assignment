<?php
class OtpModel {
    use Model;
    public function __construct() {
        $this->allowedColumns = [
            'code',
            'time',
            'email'
        ];
        $this->table = 'otp';
    }

    public function send_otp($data) {
        date_default_timezone_set("Asia/Ho_Chi_Minh"); 
        
        $arr['email'] = $data['email'];
        $arr['code'] = rand(100000, 999999);
        $arr['time'] = date("Y-m-d H:i:s");

        $query = "SELECT * FROM $this->table WHERE email = :email";
        $params = ['email' => $arr['email']];
        $otp = $this->get_first($query, $params);

        if (!$otp) {
           $this->insert($arr);
        } else {
           $this->update($otp->id, $arr);
        }

        $params = [
            'code' => $arr['code'], 
            'email' => $arr['email']
        ];


        // Gửi email
        $to = $arr['email'];
        $subject = "OTP Verification";
        $message = "Your OTP is: " . $arr['code'];
        $headers = "From: no-reply@example.com\r\n";
        
        if (mail($to, $subject, $message, $headers)) {
            return true;
        } else {
            $this->message['error'] = "OTP not sent";
            return false;
        }
    }
    
    public function verify_otp($data) {
        $arr['email'] = $data['email'];
        $arr['code'] = $data['code'];
        $arr['time'] = date("Y-m-d H:i:s", time() + 60 * 5);
        $query = "SELECT * FROM $this->table WHERE email = :email";
        $params = ['email' => $arr['email']];
        $otp = $this->get_first($query, $params); 

        if (!$otp) {
            $this->message['error'] = "OTP error";
            return false;
        }
        if ($otp->code === $arr['code'] && $otp->time > date("Y-m-d H:i:s")) {
            $this->delete($otp->id);
            return true;
        } else {
            $this->message['error'] = "OTP error";
            return false;
        }

        
    }
    
}