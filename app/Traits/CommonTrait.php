<?php
namespace App\Traits;

trait CommonTrait {

    use SessionTrait;
    use PayPalTrait;

    public function logDirectory() : string {
        return storage_path('logs');
    }

    public function customLog($message, $file_name = '', $path = '')  {

        $file_name = trim($file_name);
        $path = trim($path);
        $path = $this->logDirectory() .'/'.  trim($path, "/");

        if(!file_exists($path)){
            mkdir($path, 0755, true);
        }

        if (empty($file_name)) {
            $file_name = 'debug';
        }

        $file_name = $file_name . '.log';

        $file_path = $path . '/' . $file_name;

        if (is_array($message) || is_object($message)) {
            $log_message = print_r($message, true);
        }
        else {
            $log_message = $message;
        }

        $log_message = date('Y-m-d H:i:s') . ": " . $log_message."\n";
        error_log($log_message, 3, $file_path);
    }

    public function hasRole(array $relational_roles, array $check_roles): bool {
        $role_names  = array_column($relational_roles, 'name');
        foreach ($check_roles as $key => $check_role) {
            if (in_array($check_role, $role_names)) {
                return true;
            }
        }

        return false;
    }

    public function decimalPrice($amount, $decimal = 2) : string {
        return number_format($amount, $decimal, '.', '');
    }

    public function generateOrderReferenceCode($cart): string {
        $first_name_explode = explode(" ", $cart['customer']['first_name']);
        $first_name_explode = preg_replace('/[^A-Za-z0-9\-]/', '', $first_name_explode);
        return substr($first_name_explode[0], 0, 6).'-' . time();
    }
}
