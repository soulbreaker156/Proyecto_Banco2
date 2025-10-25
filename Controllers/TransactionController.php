<?php
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Transaction.php';

class TransactionController {

    private function checkLoggedIn() {
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: ../user/login");
            exit;
        }
    }

    private function sendJsonResponse($success, $message, $data = []) {
        header('Content-Type: application/json');
        echo json_encode(['success' => $success, 'message' => $message] + $data);
        exit;
    }

    public function deposit() {
        $this->checkLoggedIn();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $amount = (float)$_POST['monto'];
            if ($amount <= 0) {
                $this->sendJsonResponse(false, 'El monto debe ser positivo.');
            }

            $userModel = new User();
            $transactionModel = new Transaction();
            $newBalance = $_SESSION['saldo'] + $amount;
            
            if ($userModel->updateBalance($_SESSION['id'], $newBalance) && 
                $transactionModel->create($_SESSION['id'], 'deposito', $amount)) {
                
                $_SESSION['saldo'] = $newBalance;
                $this->sendJsonResponse(true, 'Depósito realizado con éxito.', ['newBalance' => $newBalance]);
            } else {
                $this->sendJsonResponse(false, 'Error al procesar el depósito.');
            }
        }
        require_once __DIR__ . '/../Views/transaction/deposit.php';
    }

    public function withdraw() {
        $this->checkLoggedIn();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $amount = (float)$_POST['monto'];
            if ($amount <= 0) {
                $this->sendJsonResponse(false, 'Monto inválido.');
            }
            if ($_SESSION['saldo'] < $amount) {
                $this->sendJsonResponse(false, 'Saldo insuficiente.');
            }

            $userModel = new User();
            $transactionModel = new Transaction();
            $newBalance = $_SESSION['saldo'] - $amount;

            if ($userModel->updateBalance($_SESSION['id'], $newBalance) && 
                $transactionModel->create($_SESSION['id'], 'retiro', $amount)) {

                $_SESSION['saldo'] = $newBalance;
                $this->sendJsonResponse(true, 'Retiro realizado con éxito.', ['newBalance' => $newBalance]);
            } else {
                $this->sendJsonResponse(false, 'Error al procesar el retiro.');
            }
        }
        require_once __DIR__ . '/../Views/transaction/withdraw.php';
    }
    
    public function history() {
        $this->checkLoggedIn();
        $transactionModel = new Transaction();
        $transactions = $transactionModel->findByUserId($_SESSION['id']);
        require_once __DIR__ . '/../Views/transaction/history.php';
    }
}
?>