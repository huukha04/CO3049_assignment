<?php
class ShowtimeModel
{

    use Model;
    use CSV;
    public function __construct() {
        $this->allowedColumns = [
            'room_id',
            'media_id',
            'date',
            'start_time',
            'end_time',
        ];
        $this->table = 'showtime';
        $this->message = '';
    }

    public function getSeatByShowtimeId($data) {
        try {
            $showtime_id = $data['showtime_id'];
    
            $query = 
                "SELECT s.*, od.status " .
                "FROM seat s " .
                "INNER JOIN room r ON s.room_id = r.id " .
                "INNER JOIN showtime st ON r.id = st.room_id " .
                "LEFT JOIN orderdetail od ON s.id = od.seat_id AND od.showtime_id = st.id " .
                "WHERE st.id = :showtime_id " .
                "ORDER BY s.row ASC, s.col ASC";
            
            $params = [
                'showtime_id' => $showtime_id
            ];

            $seats = $this->PDOquery($query, $params);

            return $seats;
    
        } catch (Exception $e) {
            $this->message = 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function getShowtimeByCinemaId($data) {
        try {
            $cinemaId = $data["cinema_id"];
            
            $query = 
                "SELECT st.*, m.title AS title " .  // Lấy thêm title từ bảng media
                "FROM $this->table st " .
                "INNER JOIN room r ON st.room_id = r.id " .
                "INNER JOIN media m ON st.media_id = m.id " .
                "WHERE r.cinema_id = :cinema_id " .
                "AND st.start_time > NOW() " .  
                "ORDER BY st.start_time ASC";
            
            $params = ['cinema_id' => $cinemaId];
            return $this->PDOquery($query, $params);
            
        } catch (Exception $e) {
            $this->message = 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function getProductByShowtimeId($data) {
        try {
            $showtime_id = $data['showtime_id'];
    
            $query = 
               "SELECT p.* " .  
                "FROM product p " .
                "INNER JOIN cinema c ON p.cinema_id = c.id " .  
                "INNER JOIN room r ON c.id = r.cinema_id " .  
                "INNER JOIN showtime st ON r.id = st.room_id " .  
                "WHERE st.id = :showtime_id " .
                "AND p.status = 'available'";

            $params = [
                'showtime_id' => $showtime_id
            ];

            return $this->PDOquery($query, $params);
    
        } catch (Exception $e) {
            $this->message = 'Error: ' . $e->getMessage();
            return false;
        }
    }






    public function getShowtimeForAdmin($data) {
        try {
            $date = $data['date'];
            $roomId = $data['room_id'];
    
            // Truy vấn chính xác dựa trên room_id và date
            $query =
                "SELECT st.start_time, st.end_time, m.title ".
                "FROM showtime st ".
                "INNER JOIN media m ON m.id = st.media_id ".
                "WHERE st.date = :date AND st.room_id = :room_id"
            ;
    
            $params = [
                'room_id' => $roomId,
                'date' => $date
            ];
    
            return $this->PDOquery($query, $params);
    
        } catch (Exception $e) {
            $this->message = 'Error: ' . $e->getMessage();
            return false;
        }
    }
    
    
    
    

}
