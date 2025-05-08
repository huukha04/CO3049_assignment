<?php
class OrderDetailModel
{

    use Model;
    public function __construct() {
        $this->allowedColumns = [
            'order_code',
            'showtime_id',
            'seat_id',
            'product_id',
            'quantity',
            'status',
            'time'

        ];
        $this->table = 'orderdetail';
        $this->message = '';
        $this->deletePendingOrders();

        
    }

    public function deletePendingOrders() {
        try {
            $query = "DELETE FROM orderdetail " .
                 "WHERE status = 'pending' " .
                 "AND DATE_ADD(time, INTERVAL 5 MINUTE) < NOW() " .
                 "AND order_code NOT IN (SELECT order_code FROM `order`)"; // Kiểm tra nếu order_code không tồn tại trong bảng order
    
            $params = [];  // Không cần tham số nếu không có điều kiện khác
    
            $this->PDOquery($query, $params);
            
            return true;  // Trả về true khi xóa thành công
        } catch (Exception $e) {
            $this->message = 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function insertOrderDetail($data) {
        try {
            $order_code = $data['order_code'];
            $result = $this->where($data);
            if ($result) {
                $update = $this->update($result[0]->id, $data);
                if ($update) {
                    return true;
                }
            } else {
                $insert = $this->insert($data);
                if ($insert) {
                    return true;
                }
            }
            return false;
        } catch (Exception $e) {
            $this->message = 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function deleteOrderDetail($data) {
        try {
            $order_code = $data['order_code'];
            $result = $this->where($data);
            if ($result) {
                $delete = $this->delete($result[0]->id);
                if ($delete) {
                    return true;
                }
            } else {
                return false;
            }
        } catch (Exception $e) {
            $this->message = 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function revenueFor14Days() {
        $query = 
            "SELECT " .
                "DATE(od.time) AS date, " .
                "SUM(COALESCE(s.price, 0)) AS total_seat_price, " .
                "SUM(COALESCE(p.price * od.quantity, 0)) AS total_product_price, " .
                "SUM(COALESCE(s.price, 0) + COALESCE(p.price * od.quantity, 0)) AS total_revenuee " .
            "FROM " . $this->table . " od " .
            "LEFT JOIN seat s ON od.seat_id = s.id " .
            "LEFT JOIN product p ON od.product_id = p.id " .
            "WHERE od.status = :status " .
            "AND od.time >= CURDATE() - INTERVAL 13 DAY " .
            "GROUP BY DATE(od.time) " .
            "ORDER BY DATE(od.time)";
    
        $data = ['status' => 'completed'];
        return $this->PDOquery($query, $data);
    }

    public function revenueMovieHot() {
        $query = "SELECT " . 
                    "m.title, " .  // Lấy title từ bảng media
                    "DATE(od.time) AS date, " . 
                    "COUNT(od.order_code) AS total_orders " . 
                "FROM " . $this->table . " od " . 
                "JOIN showtime s ON od.showtime_id = s.id " . 
                "JOIN media m ON s.media_id = m.id " .  // Tham gia với bảng media
                "WHERE od.status = :status " . 
                "GROUP BY m.title, DATE(od.time) " . 
                "ORDER BY DATE(od.time) DESC";
    
        $data = ['status' => 'completed']; // Lọc chỉ các đơn hàng đã hoàn thành
        
        return $this->PDOquery($query, $data);
    }

    public function revenueChartCoverage($data) {
        try {
            $query = "SELECT m.title, " .  // Lấy tiêu đề từ bảng media
            "COUNT(DISTINCT od.seat_id) AS total_orders, " .  // Đếm số ghế duy nhất trong orderDetail
            "(COUNT(se.id) * 1.0 / COUNT(DISTINCT od.seat_id)) AS total_seats " .  // Tính tỷ lệ ghế trên mỗi đơn hàng
            "FROM orderDetail od " . 
            "INNER JOIN showtime s ON od.showtime_id = s.id " .  // Kết nối bảng orderDetail và showtime
            "INNER JOIN seat se ON se.room_id = s.id " .  // Kết nối bảng seat và showtime theo room_id
            "INNER JOIN media m ON s.media_id = m.id " .  // Kết nối bảng showtime và media để lấy title
            "WHERE od.status = :status " .  // Lọc theo trạng thái đơn hàng
            "AND od.seat_id IS NOT NULL " .  // Kiểm tra seat_id không null
            "AND od.time BETWEEN :start_date AND :end_date " .  // Điều kiện thời gian
            "GROUP BY m.title";  // Nhóm theo title trong bảng media (thay vì showtime_id)
    
            // Tham số truy vấn
            $params = [
                'status' => 'completed',
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date']
            ];
            
            return $this->PDOquery($query, $params);
        } catch (Exception $e) {
            $this->message = 'Error: ' . $e->getMessage();
            return false;
        }
    }
    
    

    // Booking

    public function insertProductInOrderDetail($data) {
        $orderCode = $data['order_code'];
        $productId = $data['product_id'];
        $showtimeId = $data["showtime_id"];


        $order = $this->where([
                'order_code' => $orderCode,
                'product_id' => $productId,
                'showtime_id' => $showtimeId,
            ]);
        if($order == false) {
            $this->insert([
                'order_code' => $orderCode,
                'product_id' => $productId,
                'showtime_id' => $showtimeId,
                'quantity' => 1
            ]);
        } else {
            $this->update( 
                $order[0]->id,
                [
                    'quantity' => $order[0]->quantity + 1,
                    'order_code' => $orderCode,
                    'showtime_id' => $showtimeId,
                    'product_id' => $productId
                ]
            );
        }
        return true;


    }

    public function deleteProductInOrderDetail($data) {
        $orderCode = $data['order_code'];
        $productId = $data['product_id'];
        $showtimeId = $data["showtime_id"];

        $order = $this->where([
                'order_code' => $orderCode,
                'product_id' => $productId,
                'showtime_id' => $showtimeId,
            ]);
        if($order == false) {
            return true;
        } else {
            if ($order[0]->quantity <= 1) {
                $this->delete($order[0]->id);
                return true;
            }
            
            $this->update( 
                $order[0]->id,
                [
                    'quantity' => $order[0]->quantity - 1,
                    'order_code' => $orderCode,
                    'product_id' => $productId,
                    'showtime_id' => $showtimeId,
                ]
            );
        }


        

    }

    public function getBookingInfo($data) {
        try {
            $showtime_id = $data['showtime_id'];
            $order_code = $data['order_code'];
        
            // Lấy thông tin showtime
            $query = 
                "SELECT m.title AS movie_name, c.name AS cinema_name, r.name AS room_name, st.start_time AS showtime " .
                "FROM showtime st " .
                "INNER JOIN media m ON st.media_id = m.id " .
                "INNER JOIN room r ON st.room_id = r.id " .
                "INNER JOIN cinema c ON r.cinema_id = c.id " .
                "WHERE st.id = :showtime_id";
            $params = ['showtime_id' => $showtime_id];
        
            $return = $this->PDOquery($query, $params);
        
            // Lấy danh sách ghế
            $query = 
                "SELECT s.code " . 
                "FROM orderdetail o " .
                "INNER JOIN seat s ON o.seat_id = s.id " .
                "WHERE o.order_code = :order_code AND o.showtime_id = :showtime_id";
            $params = [
                'order_code' => $order_code,
                'showtime_id' => $showtime_id,
            ];
            $return[0]->seat_list = $this->PDOquery($query, $params);

            // Lấy danh sách sản phẩm
            $query = 
                "SELECT p.name, o.quantity " . 
                "FROM orderdetail o " .
                "INNER JOIN product p ON o.product_id = p.id " .
                "WHERE o.order_code = :order_code AND o.showtime_id = :showtime_id";
            $params = [
                'order_code' => $order_code,
                'showtime_id' => $showtime_id,
            ];
            $return[0]->product_list = $this->PDOquery($query, $params);
        
            // Lấy tổng giá tiền
            $query = 
            "SELECT SUM(s.price) AS total " . 
            "FROM orderdetail o " . 
            "INNER JOIN seat s ON o.seat_id = s.id " . 
            "WHERE o.order_code = :order_code AND o.showtime_id = :showtime_id";
            $total = $this->PDOquery($query, $params)[0]->total;

            $query = 
            "SELECT SUM(p.price * o.quantity) AS total " . 
            "FROM orderdetail o " . 
            "INNER JOIN product p ON o.product_id = p.id " . 
            "WHERE o.order_code = :order_code AND o.showtime_id = :showtime_id ";
            
        
            // Lấy tổng giá tiền và gán vào $return[0]->total_price
            $return[0]->total_price = $total + $this->PDOquery($query, $params)[0]->total;
        
            return $return;
    
        } catch (Exception $e) {
            $this->message = 'Error: ' . $e->getMessage();
            return false;
        }
    }


    
    
    
    
    
    
    
    
    

}
