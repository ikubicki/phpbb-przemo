<?php

namespace PhpBB\Modules\Auth\Classic;
use PhpBB\Forum\Authenticator;

class Legacy extends Authenticator
{

    public function verify()
    {
        $index = $this->login ?? null;
        $password = $this->password ?? null;
        $record = $this->findRecord('legacy', $index);
        if ($this->check($password, $record->hash)) {
            return $this->convert($record, $index, $password);
        }
    }

    protected function convert($record, $index, $password)
    {
        $classic = new Module;
        $salt = null;
        $hash = $classic->hash($password, $salt);
        return $classic->add($record->user_id, $index, $hash, $salt);
    }

    protected function encode($input, $count, &$itoa64)
    {
        $output = '';
        $i = 0;
        do {
            $value = ord($input[$i++]);
            $output .= $itoa64[$value & 0x3f];
            if ($i < $count) {
                $value |= ord($input[$i]) << 8;
            }
            $output .= $itoa64[($value >> 6) & 0x3f];
            if ($i++ >= $count) {
                break;
            }
            if ($i < $count) {
                $value |= ord($input[$i]) << 16;
            }
            $output .= $itoa64[($value >> 12) & 0x3f];
            if ($i++ >= $count) {
                break;
            }
            $output .= $itoa64[($value >> 18) & 0x3f];
        }
        while ($i < $count);
        return $output;
    }

    protected function calculate($password, $setting, &$itoa64)
    {
        $output = '*';
        if (substr($setting, 0, 3) != '$H$' && substr($setting, 0, 3) != '$P$') {
            return $output;
        }
        $count_log2 = strpos($itoa64, $setting[3]);
        if ($count_log2 < 7 || $count_log2 > 30) {
            return $output;
        }
        $count = 1 << $count_log2;
        $salt = substr($setting, 4, 8);
        if (strlen($salt) != 8) {
            return $output;
        }
        $hash = md5($salt . $password, true);
        do {
            $hash = md5($hash . $password, true);
        }
        while (--$count);
        $output = substr($setting, 0, 12);
        $output .= $this->encode($hash, 16, $itoa64);
        return $output;
    }

    protected function check($password, $hash)
    {
        if(!$password) { 
            return false;
        }
        $itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        return $this->calculate($password, $hash, $itoa64) === $hash;
    }
}