<?php

class MainController {
    use Controller;
    use CSV;
    public function __construct() {
        (new UserTokenModel())->isLogin();
    }
    public function home() {
        $this->view('main/home');
    }
    public function contact() {
        $this->view('main/contact');
    }
    public function about() {
        $this->view('main/about');
    }
    public function media() {
        $this->view('main/media');
    }
    public function booking() {
        $this->view('main/booking');
    }
    public function cinema() {
        $this->view('main/cinema');
    }
    public function payment() {
        $this->view('main/payment');
    }




    

    public function getMedia() {
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            unset($_GET['url']);
            $mediaModel = new MediaModel();
            $result = $mediaModel->where($_GET);
            if($result != false) {
                echo json_encode(['status' => true, 'data' => $result]);
                exit;
            }
        }
        echo json_encode(['status' => false, 'message' => 'Invalid request']);
        exit;
    }

    public function getCinema() {
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            unset($_GET['url']);
            $cinemaModel = new CinemaModel();
            $result = $cinemaModel->where($_GET);
            if($result != false) {
                echo json_encode(['status' => true, 'data' => $result]);
                exit;
            }
        }
        echo json_encode(['status' => false, 'message' => 'Invalid request']);
        exit;
    }






    public function getSeat() {
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            unset($_GET['url']);
            





            $seatModel = new SeatModel();
            $result = $seatModel->where($_GET);
            if($result != false) {
                echo json_encode(['status' => true, 'data' => $result]);
                exit;
            }
        }
        echo json_encode(['status' => false, 'message' => 'Invalid request']);
        exit;
    }

    public function getShowtime() {
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            unset($_GET['url']);
            $showtimeModel = new ShowtimeModel();
            $result = $showtimeModel->where($_GET);
            if($result != false) {
                echo json_encode(['status' => true, 'data' => $result]);
                exit;
            }
        }
        echo json_encode(['status' => false, 'message' => 'Invalid request']);
        exit;
    }

    public function displayMedia() {
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            $mediaModel = new MediaModel();
            $path = $mediaModel->getPath($_GET);
            if($path != false) {
                header('Content-Type: image/webp');
                readfile($path);
                exit;
            }
        }
        echo json_encode(['status' => false, 'message' => 'Invalid request']);
        exit;
    }

    public function insertOrderDetail() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            unset($_POST['url']);
            $orderDetailModel = new OrderDetailModel();
            $result = $orderDetailModel->insertOrderDetail($_POST);
            if($result != false) {
                echo json_encode(['status' => true, 'data' => $result]);
                exit;
            }
        }
        echo json_encode(['status' => false, 'message' => 'Invalid request']);
        exit;
    }

    public function deleteOrderDetail() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            unset($_POST['url']);
            $orderDetailModel = new OrderDetailModel();
            $result = $orderDetailModel->deleteOrderDetail($_POST);
            if($result != false) {
                echo json_encode(['status' => true, 'data' => $result]);
                exit;
            }
        }
        echo json_encode(['status' => false, 'message' => 'Invalid request']);
        exit;
    }


    

    public function cancelPayment() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $payment = new PaymentModel();
            $result = $payment->cancelPayment($_POST);
            if($result != false) {
                echo json_encode(['status' => true, 'data' => $result]);
                exit;
            }
        }
        echo json_encode(['status' => false, 'message' => 'Invalid request']);
        exit;
    }
    public function getPayment() {
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            unset($_GET['url']);
            $payment = new PaymentModel();
            $result = $payment->getPayment($_GET);
            if($result != false) {
                echo json_encode(['status' => true, 'data' => $result]);
                exit;
            }
        }
        echo json_encode(['status' => false, 'message' => 'Invalid request']);
        exit;
    }





    
    


    // Cinema 
    public function getShowtimeByCinemaId() {
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            unset($_GET['url']);
            $showtimeModel = new ShowtimeModel();
            $result = $showtimeModel->getShowtimeByCinemaId($_GET);
            if($result != false) {
                echo json_encode(['status' => true, 'data' => $result]);
                exit;
            }
        }
        echo json_encode(['status' => false, 'message' => 'Invalid request']);
        exit;
    }


    public function getSeatByShowtimeId() {
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            unset($_GET['url']);
            $showtimeModel = new ShowtimeModel();
            $result = $showtimeModel->getSeatByShowtimeId($_GET);
            if($result != false) {
                echo json_encode(['status' => true, 'data' => $result]);
                exit;
            }
        }
        echo json_encode(['status' => false, 'message' => 'Invalid request']);
        exit;
    }

    // Booking
    public function getProductByShowtimeId() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            unset($_GET['url']);
            
            $showtimeModel = new ShowtimeModel();
            $result = $showtimeModel->getProductByShowtimeId($_GET);
            if($result != false) {
                echo json_encode(['status' => true, 'data' => $result]);
                exit;
            }
        }
    
        echo json_encode(['status' => false, 'message' => 'Invalid request']);
        exit;
    }

    public function insertProductInOrderDetail() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $orderDetail = new OrderDetailModel();
            $result = $orderDetail->insertProductInOrderDetail($_POST);
            if($result != false) {
                echo json_encode(['status' => true, 'data' => $result]);
                exit;
            }
        }
    
        echo json_encode(['status' => false, 'message' => 'Invalid request']);
        exit;
    }

    public function deleteProductInOrderDetail() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $orderDetail = new OrderDetailModel();
            $result = $orderDetail->deleteProductInOrderDetail($_POST);
            if($result != false) {
                echo json_encode(['status' => true, 'data' => $result]);
                exit;
            }
        }
    
        echo json_encode(['status' => false, 'message' => 'Invalid request']);
        exit;
    }

    public function getBookingInfo() {
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            
            unset($_GET['url']);
            $orderDetailModel = new OrderDetailModel();
            $result = $orderDetailModel->getBookingInfo($_GET);
            if($result != false) {
                echo json_encode(['status' => true, 'data' => $result]);
                exit;
            }
        }
        echo json_encode(['status' => false, 'message' => 'Invalid request']);
        exit;
    }

    public function confirmPayment() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $payment = new PaymentModel();
            $result = $payment->confirmPayment($_POST);
            if($result != false) {
                echo json_encode(['status' => true, 'data' => $result]);
                exit;
            }
        }
        echo json_encode(['status' => false, 'message' => 'Invalid request']);
        exit;
    }








    public function test() {
        header('Content-Type: application/json');

        echo json_encode(
            (new ShowtimeModel())->getShowtimeForAdmin(['room_id' => 1, 'date' => '2025-05-08'])
        );
    }
}


