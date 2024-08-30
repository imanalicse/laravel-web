<?php
namespace App\Traits;

trait SessionTrait {

    public function sessionRead($key, $default = null) {
        return session()->get($key, $default);
    }

    public function sessionWrite($key, $value) {
        session()->put($key, $value);
    }

    public function cartGet($sub_key = '', $default = null) {
        if (empty($sub_key)) {
            $cart = $this->sessionRead('cart', $default);
        }
        else {
            $cart = $this->sessionRead('cart.'.$sub_key, $default);
        }
        return $cart;
    }

    public function cartSet($sub_key, $value) {
        $this->sessionWrite('cart.' .$sub_key, $value);
    }

}
