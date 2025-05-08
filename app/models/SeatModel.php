<?php
class SeatModel
{

    use Model;
    public function __construct() {
        $this->allowedColumns = [
            'room_id',
            'cinema_id',
            'code',
            'row',
            'col',
            'type',
            'price'
        ];
        $this->table = 'seat';
        $this->message = '';
    }

    public function insertSeat($data) {
        if (empty($data['id'])) {
            $this->insert($data);
        } else {
            $type = $data['type'];
            $updateData = ['type' => $type];

            // Bỏ qua price nếu là 'none'
            if ($type !== 'none') {
                $updateData['price'] = $data['price'];
            }

            $this->update($data['id'], $updateData);

    
            $query = "SELECT * FROM seat WHERE row = :row AND room_id = :room_id ORDER BY col ASC";
            $params = [
                'row' => $data['row'],
                'room_id' => $data['room_id']
            ];
            $seats = $this->PDOquery($query, $params);

            $rowLetter = chr(64 + $data['row']);
            $seatNumber = 1;
    
            foreach ($seats as $seat) {
                if ($seat->type === 'none') {
                    $this->update($seat->id, [
                        'code' => '',
                    ]);
                    continue;
                }
    
                $seatCode = $rowLetter . $seatNumber;
    
                $this->update($seat->id, [
                    'code' => $seatCode,
                ]);
    
                $seatNumber++;
            }
        }
    
        return true;
    }
    
    
    
    public function deleteSeat($data) {
        // Xóa ghế theo ID
        $id = $data['id'];
        $this->update($id, [
            'type' => 'none',
            'price' => null,
            'code' => ''
        ]);
    
        // Lấy danh sách ghế còn lại theo hàng và phòng
        $query = "SELECT * FROM seat WHERE row = :row AND room_id = :room_id ORDER BY col ASC";
        $params = [
            'row' => $data['row'],
            'room_id' => $data['room_id']
        ];
        $seats = $this->PDOquery($query, $params);
    
        // Chuyển số row thành chữ
        $rowLetter = chr(64 + $data['row']);
        $seatNumber = 1;
    
        // Cập nhật lại mã ghế
        foreach ($seats as $seat) {
            // Bỏ qua ghế loại "none" và ghế không có mã
            if ($seat->type === 'none') {
                // Đảm bảo ghế "none" không có mã
                if ($seat->code !== '') {
                    $this->update($seat->id, ['code' => '']);
                }
                continue;
            }
    
            // Tạo mã ghế (A1, A2, ...)
            $seatCode = $rowLetter . $seatNumber;
    
            // Chỉ cập nhật nếu mã ghế thay đổi
            if ($seat->code !== $seatCode) {
                $this->update($seat->id, ['code' => $seatCode]);
            }
    
            $seatNumber++;
        }
    
        return true;
    }
    

}
