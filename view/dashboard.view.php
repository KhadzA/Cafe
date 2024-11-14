<?php

include __DIR__ . '../../control/dashboard.control.php';

$controller = new DashboardCtrl();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->handleRequest();
    exit();
}

$profitToday = $controller->getProfitToday();
$profitMonth = $controller->getProfitMonth();
$profitYear = $controller->getProfitYear();

$dailyProfitData = $controller->getDailyProfitData();
$weeklyProfitData = $controller->getWeeklyProfitData();
$monthlyProfitData = $controller->getMonthlyProfitData();
$yearlyProfitData = $controller->getYearlyProfitData();
