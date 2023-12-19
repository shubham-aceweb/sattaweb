<?php
namespace App\Classes;

class ApiValidationController
{
    /**
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

     public function numberOnly($value)
    {
        if (empty($value)) {
            return true;
        } else {
            $result = preg_match("/^[0-9]+$/", $value);
            if ($result) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function noSpcialCharacterWithSpace($value)
    {
        if (empty($value)) {
            return true;
        } else {
            $result = preg_match("/[^a-z0-9 ]/i", $value);
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function noSpcialCharacterWithoutSpace($value)
    {
        if (empty($value)) {
            return true;
        } else {
            $result = preg_match("/[^a-z0-9]/i", $value);
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
    }
     public function pincode($value)
    {
        if (empty($value)) {
            return true;
        } else {
            $result = preg_match("/^[0-9]{6}+$/", $value);
            if ($result) {
                return false;
            } else {
                return true;
            }
        }
    }

     public function mobile($value)
    {
        if (empty($value)) {
            return true;
        } else {
            $result = preg_match("/^[0-9]{10}+$/", $value);
            if ($result) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function allWithSomeSpecialCharctor($value)
    {
        if (empty($value)) {
            return true;
        } else {
            $result = preg_match("/^[-a-zA-Z0-9 .,-\/()@#&*%+_=]+$/", $value);

            if ($result) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function otp($value)
    {
        if (empty($value)) {
            return true;
        } else {
            $result = preg_match("/^[0-9]{5}+$/", $value);
            if ($result) {
                return false;
            } else {
                return true;
            }
        }
    }
    public function pin($value)
    {
        if (empty($value)) {
            return true;
        } else {
            $result = preg_match("/^[0-9]{4}+$/", $value);
            if ($result) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function email($value)
    {
        return !preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,4}$/ix", $value) ? true : false;
    }

}
