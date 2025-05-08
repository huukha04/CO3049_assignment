

DELIMITER $$

CREATE PROCEDURE generate_seats_for_room(IN roomId INT)
BEGIN
    INSERT INTO seat (room_id, code, row, col, type, price)
    SELECT 
        roomId,
        CONCAT(CHAR(64 + rws.row_index), cls.col_index),
        rws.row_index,
        cls.col_index,
        CASE
            WHEN rws.row_index BETWEEN 1 AND 3 THEN 'standard'
            WHEN rws.row_index BETWEEN 4 AND 6 THEN 'vip'
            WHEN rws.row_index = 8 THEN 'couple'
            ELSE 'standard'
        END,
        CASE
            WHEN rws.row_index BETWEEN 1 AND 3 THEN 1000.00
            WHEN rws.row_index BETWEEN 4 AND 6 THEN 1200.00
            WHEN rws.row_index = 8 THEN 1500.00
            ELSE 1000.00
        END
    FROM 
        (SELECT 1 AS row_index UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL 
         SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8) AS rws
    JOIN
        (
            SELECT 1 AS col_index UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 
            UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10
        ) AS cls
    ON (rws.row_index != 8 OR cls.col_index <= 5);
END $$

DELIMITER ;

CALL generate_seats_for_room(1);
CALL generate_seats_for_room(2);
CALL generate_seats_for_room(3);
CALL generate_seats_for_room(4);
CALL generate_seats_for_room(5);
CALL generate_seats_for_room(6);
CALL generate_seats_for_room(7);
CALL generate_seats_for_room(8);
CALL generate_seats_for_room(9);
CALL generate_seats_for_room(10);
CALL generate_seats_for_room(11);
CALL generate_seats_for_room(12);
CALL generate_seats_for_room(13);
CALL generate_seats_for_room(14);
CALL generate_seats_for_room(15);
CALL generate_seats_for_room(16);
CALL generate_seats_for_room(17);
CALL generate_seats_for_room(18);
CALL generate_seats_for_room(19);
CALL generate_seats_for_room(20);
CALL generate_seats_for_room(21);
CALL generate_seats_for_room(22);
CALL generate_seats_for_room(23);
CALL generate_seats_for_room(24);
CALL generate_seats_for_room(25);
CALL generate_seats_for_room(26);
CALL generate_seats_for_room(27);
CALL generate_seats_for_room(28);
CALL generate_seats_for_room(29);
CALL generate_seats_for_room(30);
CALL generate_seats_for_room(31);
CALL generate_seats_for_room(32);
CALL generate_seats_for_room(33);
CALL generate_seats_for_room(34);
CALL generate_seats_for_room(35);

