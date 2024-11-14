<?php
require_once __DIR__ . '../../connection/database.php';

class DashboardModel extends dBase {

    public function __construct() {

    }

    public function fetchProfitToday() {
        $sql = "SELECT SUM(total_amount) as total_amount FROM orders WHERE DATE(order_date) = CURDATE()";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_amount'] ?? 0;
    }

    public function fetchProfitMonth() {
        $sql = "SELECT SUM(total_amount) as total_amount FROM orders WHERE MONTH(order_date) = MONTH(CURDATE()) AND YEAR(order_date) = YEAR(CURDATE())";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_amount'] ?? 0;
    }

    public function fetchProfitYear() {
        $sql = "SELECT SUM(total_amount) as total_amount FROM orders WHERE YEAR(order_date) = YEAR(CURDATE())";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_amount'] ?? 0;
    }



    public function fetchDailyProfits() {
        $sql = "
        SELECT 
            DAYNAME(order_date) AS day_name, 
            SUM(total_amount) AS total_amount
        FROM orders
        WHERE WEEK(order_date) = WEEK(CURDATE())
        GROUP BY DAYNAME(order_date)
        ORDER BY FIELD(DAYNAME(order_date), 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday')
        ";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchWeeklyProfits() {
        $sql = "
        SELECT 
            CONCAT('Week ', WEEK(order_date, 1)) AS week,
            SUM(total_amount) AS total_amount
        FROM orders
        WHERE YEAR(order_date) = YEAR(CURDATE())
        GROUP BY WEEK(order_date, 1)
        ORDER BY WEEK(order_date, 1)
        ";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function fetchMonthlyProfits() {
        $sql = "
        SELECT 
            MONTH(order_date) AS month, 
            SUM(total_amount) AS total_amount
        FROM orders
        WHERE YEAR(order_date) = YEAR(CURDATE())
        GROUP BY MONTH(order_date)
        ORDER BY MONTH(order_date)
        ";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchYearlyProfits() {
        $sql = "
        SELECT 
            YEAR(order_date) AS year, 
            SUM(total_amount) AS total_amount
        FROM orders
        GROUP BY YEAR(order_date)
        ORDER BY YEAR(order_date)
        ";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
