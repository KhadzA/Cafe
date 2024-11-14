<?php
require_once __DIR__ . '../../model/dashboard.model.php';

class DashboardCtrl extends DashboardModel {

    public function handleRequest() {
        $action = $_POST['action'] ?? '';

        switch ($action) {
            case 'fetchChartData':
                echo json_encode($this->getPriceByDay());
                break;

            default:
                $this->redirectTo404();
                break;
        }
    }

    public function getProfitToday() {
        return $this->fetchProfitToday();
    }

    public function getProfitMonth() {
        return $this->fetchProfitMonth();
    }

    public function getProfitYear() {
        return $this->fetchProfitYear();
    }

    

    public function getDailyProfitData() {
        $dailyData = $this->fetchDailyProfits();
        return $dailyData; 
    }

    public function getWeeklyProfitData() {
        $weeklyData = $this->fetchWeeklyProfits();
        return $weeklyData; 
    }

    public function getMonthlyProfitData() {
        $monthlyData = $this->fetchMonthlyProfits();
        return $monthlyData;
    }

    public function getYearlyProfitData() {
        $yearlyData = $this->fetchYearlyProfits();
        return $yearlyData;
    }


    private function redirectTo404() {
        header("Location: ../../pages/404.php");
        exit();
    }
}
