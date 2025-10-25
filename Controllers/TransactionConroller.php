<?php
require_once '../models/User.php';
require_once '../models/Transaction.php';

class TransactionController {
    private function checkLoggedIn() {
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: ../user/login");
            exit;
        }
    }

    public function deposit() {
        $this->checkLoggedIn();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $amount = (float)$_POST['monto'];
            if ($amount > 0) {
                $userModel = new User();
                $transactionModel = new Transaction();
                
                $newBalance = $_SESSION['saldo'] + $amount;
                
                
                $userModel->updateBalance($_SESSION['id'], $newBalance);
                $transactionModel->create($_SESSION['id'], 'deposito', $amount);
                
                $_SESSION['saldo'] = $newBalance;
                header("Location: ../user/dashboard");
                exit;
            }
        }
        require_once '../views/transaction/deposit.php';
    }

    public function withdraw() {
        $this->checkLoggedIn();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $amount = (float)$_POST['monto'];
            if ($amount > 0 && $_SESSION['saldo'] >= $amount) {
                $userModel = new User();
                $transactionModel = new Transaction();
                
                $newBalance = $_SESSION['saldo'] - $amount;
                
                $userModel->updateBalance($_SESSION['id'], $newBalance);
                $transactionModel->create($_SESSION['id'], 'retiro', $amount);
                
                $_SESSION['saldo'] = $newBalance;
                header("Location: ../user/dashboard");
                exit;
            }
        }
        require_once '../views/transaction/withdraw.php';
    }

    public function history() {
        $this->checkLoggedIn();
        $transactionModel = new Transaction();
        $transactions = $transactionModel->findByUserId($_SESSION['id']);
        require_once '../views/transaction/history.php';
    }
}
?>