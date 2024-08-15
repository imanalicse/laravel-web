<?php
namespace App\Traits;

trait CommonTrait {

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
}
