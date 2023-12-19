<?php
namespace App\Http\Controllers\Api;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Crypt;
use Carbon\Carbon;
use App\Classes\ApiValidationController;
use App\Classes\ApiCrypterController;
use Illuminate\Support\Facades\Storage;

class MumbaiGroup1Controller extends Controller
{
    public function __construct()
    {
        $this->demoaccount = '8604691685';

        date_default_timezone_set('Asia/Kolkata');
        $this->current_date_time = date("Y-m-d H:i:s");
        $this->today_date = date("Y-m-d");
        $this->max_withdraw_limit = 30000;
        $this->min_withdraw_limit = 200;
        $this->max_deposit_limit = 30000;
        $this->min_deposit_limit = 100;
        $this->min_betting_limit = 10;
        $this->appname = 'mumbaigroup';
        $this->app_version = '2.1';
        $this->betting_close = 'YES';
        $this->betting_close_before = 5;
        $this->website = "https://bestsattamatka.net/";

      
    }
    public function app_setup(Request $request)
    {
        $object = new ApiCrypterController();
        $authKeyEncryted = $request->header('auth-key');
        $authokey = $object->auth_key($authKeyEncryted);

        if (empty($authKeyEncryted)) {
            echo json_encode(['code' => "0", 'msg' => 'Unauthorized Request']);
        } else {
            $authokey = $object->auth_key($authKeyEncryted);
            if (!$authokey) {
                echo json_encode(['code' => "0", 'msg' => 'Unauthorized Request']);
            } else {
                $notice = DB::table('notice_master')
                    ->where('status', 'Enable')
                    ->first();
                $notice_text = "NA";
                if (empty($notice)) {
                    $notice_text = "NA";
                } else {
                    $notice_text = $notice->text;
                }
                $support_number = "NA";
                $support = DB::table('support_contact_master')
                    ->where('type', 'WhatsApp')
                    ->where('status', 'Enable')
                    ->where('product', $this->appname)
                    ->first();
                if (empty($support)) {
                    $support_number = "NA";
                } else {
                    $support_number = $support->mobile;
                }

                $data = [
                    "code" => "1",
                    "currentVersionName" => $this->app_version,
                    "forceInstall" => "Enable",
                    "demoaccount" => $this->demoaccount,
                    "whatsapp" => $support_number,
                    "shutdown" => "Disable",
                    "website" =>  $this->website,
                    "msg" => "We will back shortly",
                    "time" => "Mantenance is sheduled for sometime \n We will be back shortly.",
                    "sharetext" => "Download App",
                    "app_download_link" => "https://bestsattamatka.net/download-app/com.bestsattamatka.mumbaigroup",
                    "download_step_1" => "Download and Install new version of App Name App from ".$this->website,
                    "download_step_2" => "If you are facing any problem unistall old version App and re-insatll App",
                    "download_step_3" => "Enable unknown source setting if you are not downloading or Updating  from Google Play Store.",
                    "notice_text" => $notice_text,
                ];

                echo json_encode($data);
            }
        }
    }
    public function otp_un_register(Request $request)
    {
        $object = new ApiCrypterController();
        $validation = new ApiValidationController();
        $authKeyEncryted = $request->header('auth-key');
        if (empty($authKeyEncryted)) {
            echo json_encode(['code' => 0, 'msg' => 'Unauthorized Request']);
        } else {
            $authokey = $object->auth_key($authKeyEncryted);
            if (!$authokey) {
                echo json_encode(['code' => 0, 'msg' => 'Unauthorized Request']);
            } else {
                $rawdata = json_decode($request->getContent(), true);
                if (!isset($rawdata['mobile'])) {
                    $data = ["code" => "0", "msg" => "Unauthorized Requestss"];
                    echo json_encode($data);
                } else {
                    $mobile = $rawdata['mobile'];
                    $user = DB::table('users_master')
                        ->where('source', $this->appname)
                        ->where('mobile', $mobile)
                        ->first();

                    if ($validation->mobile($mobile)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Mobile number must be in number/10 digit',
                        ]);
                    } elseif (!empty($user)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => "Mobile Number Alreday Register",
                        ]);
                    } else {
                        $code = $this->send_otp_mobile($rawdata['mobile']);
                        switch ($code) {
                            case '0':
                                echo json_encode([
                                    "code" => "2",
                                    "msg" => 'OTP SMS Server not working. Please try after some time',
                                ]);
                                break;
                            case '1':
                                echo json_encode([
                                    "code" => "1",
                                    "msg" => 'OTP Send your register mobile number.',
                                ]);
                                break;
                            case '2':
                                echo json_encode([
                                    "code" => "0",
                                    "msg" => 'Somthing went to wrong. Please try after some time',
                                ]);
                                break;
                        }
                    }
                }
            }
        }
    }
    public function otp_register(Request $request)
    {
        $object = new ApiCrypterController();
        $validation = new ApiValidationController();
        $authKeyEncryted = $request->header('auth-key');

        if (empty($authKeyEncryted)) {
            echo json_encode(['code' => 0, 'msg' => 'Unauthorized Request1']);
        } else {
            $authokey = $object->auth_key($authKeyEncryted);

            if (!$authokey) {
                echo json_encode(['code' => 0, 'msg' => 'Unauthorized Request2']);
            } else {
                $rawdata = json_decode($request->getContent(), true);
                if (!isset($rawdata['mobile'])) {
                    $data = ["code" => "0", "msg" => "Unauthorized Requests3"];
                    echo json_encode($data);
                } else {
                    $mobile = $rawdata['mobile'];
                    $user = DB::table('users_master')
                        ->where('mobile', $mobile)
                        ->where('source', $this->appname)
                        ->first();

                    if ($validation->mobile($mobile)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Mobile number must be in number/10 digit',
                        ]);
                    } elseif (empty($user)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => "Mobile Number Not Register",
                        ]);
                    } else {
                        $code = $this->send_otp_mobile($rawdata['mobile']);
                        switch ($code) {
                            case '0':
                                echo json_encode([
                                    "code" => "2",
                                    "msg" => 'OTP SMS Server not working. Please try after some time',
                                ]);
                                break;
                            case '1':
                                echo json_encode([
                                    "code" => "1",
                                    "msg" => 'OTP Send your register mobile number.',
                                ]);
                                break;
                            case '2':
                                echo json_encode([
                                    "code" => "0",
                                    "msg" => 'Somthing went to wrong. Please try after some time',
                                ]);
                                break;
                        }
                    }
                }
            }
        }
    }
    public function registration(Request $request)
    {
        $object = new ApiCrypterController();
        $validation = new ApiValidationController();
        $authKeyEncryted = $request->header('auth-key');
        if (empty($authKeyEncryted)) {
            return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
        } else {
            $authokey = $object->auth_key($authKeyEncryted);
            if (!$authokey) {
                return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
            } else {
                $rawdata = json_decode($request->getContent(), true);

                if (!isset($rawdata['full_name']) || !isset($rawdata['mobile']) || !isset($rawdata['otp'])) {
                    echo json_encode([
                        "code" => "0",
                        "msg" => "Unauthorized Request",
                    ]);
                } else {
                    $full_name = $rawdata['full_name'];
                    $mobile = $rawdata['mobile'];
                    $otp = $rawdata['otp'];
                    $check_mobile = DB::table('users_master')
                        ->where('mobile', $mobile)
                        ->where('source', $this->appname)
                        ->first();

                    if ($validation->otp($otp)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Otp must be numric and 5 digit and not be empty',
                        ]);
                    } elseif (!empty($check_mobile)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Mobile Number Alredy Register',
                        ]);
                    } else {
                        $code = $this->verify_otp_mobile($mobile, $otp);
                        switch ($code) {
                            case '0':
                                echo json_encode([
                                    "code" => "0",
                                    "msg" => 'OTP Not Match . Please Enter Valid Valid OTP',
                                ]);
                                break;

                            case '1':
                                $data = [
                                    'full_name' => strtoupper($full_name),
                                    'mobile' => strtoupper($mobile),
                                    'refer_by' => 'NA',
                                    'user_bank_wallet_status' => 'NO',
                                    'mobile_verification_status' => 'YES',
                                    'source' => $this->appname,
                                    'version' => $this->app_version,
                                    'status' => "Enable",
                                    'created_at' => $this->current_date_time,
                                    'updated_at' => $this->current_date_time,
                                ];
                                $return_id = DB::table('users_master')->insertGetId($data);

                                if (isset($return_id)) {
                                    $uniquenumber = $return_id;
                                    $reg_number = 'SM' . strtoupper($this->genratenumber(8, $uniquenumber));
                                    $token = substr(str_shuffle('12345687890abcdefghijklmnopqrstuvwxyz'), 0, 4) . bin2hex(random_bytes(10) . $uniquenumber);
                                    $refer_code = strtoupper($this->genratenumber(6, $uniquenumber));
                                    DB::table('users_master')
                                        ->where('id', $return_id)
                                        ->update(['reg_no' => $reg_number, 'refer_code' => $refer_code, 'token' => $token]);

                                    echo json_encode([
                                        "code" => "1",
                                        "reg_no" => $object->openssl_encrypt($reg_number),
                                        "token" => $object->openssl_encrypt($token),
                                        "msg" => "Register successfully",
                                    ]);
                                } else {
                                    echo json_encode([
                                        "code" => "0",
                                        "msg" => "Somthing went to wrong. Please try again",
                                    ]);
                                }
                                break;
                            case '2':
                                echo json_encode([
                                    "code" => "0",
                                    "msg" => 'Please Resend OTP again.',
                                ]);
                                break;
                        }
                    }
                }
            }
        }
    }
    public function login_with_otp(Request $request)
    {
        $object = new ApiCrypterController();
        $validation = new ApiValidationController();
        $authKeyEncryted = $request->header('auth-key');
        if (empty($authKeyEncryted)) {
            return response()->json(['code' => 0, 'msg' => 'Unauthorized Request1']);
        } else {
            $authokey = $object->auth_key($authKeyEncryted);
            if (!$authokey) {
                return response()->json(['code' => 0, 'msg' => 'Unauthorized Request2']);
            } else {
                $rawdata = json_decode($request->getContent(), true);

                if (!isset($rawdata['mobile']) || !isset($rawdata['otp'])) {
                    echo json_encode([
                        "code" => "0",
                        "msg" => "Unauthorized Request3",
                    ]);
                } else {
                    $mobile = $rawdata['mobile'];
                    $otp = $rawdata['otp'];
                    $check_user = DB::table('users_master')
                        ->where('mobile', $mobile)
                        ->where('source', $this->appname)
                        ->first();

                    if ($validation->mobile($mobile)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Mobile number must be in number/10 digit and not be empty',
                        ]);
                    } elseif ($validation->otp($otp)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Otp must be numric and 5 digit and not be empty',
                        ]);
                    } elseif (empty($check_user)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Mobile Number Not Register',
                        ]);
                    } else {
                        $code = $this->verify_otp_mobile($mobile, $otp);
                        switch ($code) {
                            case '0':
                                echo json_encode([
                                    "code" => "0",
                                    "msg" => 'OTP Not Match . Please Enter Valid Valid OTP',
                                ]);
                                break;

                            case '1':
                                DB::table('users_master')
                                    ->where('mobile', $mobile)
                                    ->update(['version' => $this->app_version, 'updated_at' => $this->current_date_time]);

                                echo json_encode([
                                    "code" => "1",
                                    "reg_no" => $object->openssl_encrypt($check_user->reg_no),
                                    "token" => $object->openssl_encrypt($check_user->token),
                                    "msg" => "Register successfully",
                                ]);
                                break;
                            case '2':
                                echo json_encode([
                                    "code" => "0",
                                    "msg" => 'Please Resend OTP again.',
                                ]);
                                break;
                        }
                    }
                }
            }
        }
    }
    public function home(Request $request)
    {
        $object = new ApiCrypterController();
        $validation = new ApiValidationController();
        $authKeyEncryted = $request->header('auth-key');
        if (empty($authKeyEncryted)) {
            return response()->json(['code' => 0, 'msg' => 'Unauthorized Request3']);
        } else {
            $authokey = $object->auth_key($authKeyEncryted);
            if (!$authokey) {
                return response()->json(['code' => 0, 'msg' => 'Unauthorized Request5']);
            } else {
                $rawdata = json_decode($request->getContent(), true);

                if (!isset($rawdata['reg_no']) || !isset($rawdata['token'])) {
                    echo json_encode([
                        "code" => "0",
                        "msg" => "Unauthorized Request6",
                    ]);
                } else {
                    $reg_no = $object->openssl_decrypt($rawdata['reg_no']);
                    $token = $object->openssl_decrypt($rawdata['token']);
                    $user = DB::table('users_master')
                        ->where('reg_no', $reg_no)
                        ->where('token', $token)
                        ->where('source', $this->appname)
                        ->first();

                    if (empty($user)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Unauthorized Request77',
                        ]);
                    } else {
                        $lottery_list = DB::table('lottery_name_master')
                            ->orderBy('position', 'ASC')
                           ->where('status','!=' ,'Deactive')
                         ->get();
                        echo json_encode([
                            "code" => "1",
                            "full_name" => $user->full_name,
                            "wallet" => $user->wallet,
                            "mobile" => $user->mobile,
                            "mobile_verification_status" => $user->mobile_verification_status,
                            "lottery_list" => $lottery_list,
                            "msg" => "Successfully",
                        ]);
                    }
                }
            }
        }
    }

    public function profile(Request $request)
    {
        $object = new ApiCrypterController();
        $validation = new ApiValidationController();
        $authKeyEncryted = $request->header('auth-key');
        if (empty($authKeyEncryted)) {
            return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
        } else {
            $authokey = $object->auth_key($authKeyEncryted);
            if (!$authokey) {
                return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
            } else {
                $rawdata = json_decode($request->getContent(), true);

                if (!isset($rawdata['reg_no']) || !isset($rawdata['token'])) {
                    echo json_encode([
                        "code" => "0",
                        "msg" => "Unauthorized Request",
                    ]);
                } else {
                    $reg_no = $object->openssl_decrypt($rawdata['reg_no']);
                    $token = $object->openssl_decrypt($rawdata['token']);
                    $user = DB::table('users_master')
                        ->where('reg_no', $reg_no)
                        ->where('token', $token)
                        ->first();

                    if (empty($user)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Unauthorized Request',
                        ]);
                    } else {
                        $user_profile = DB::table('users_master')
                            ->where('reg_no', $reg_no)
                            ->select(
                                'id',
                                'reg_no',
                                'full_name',
                                'mobile',
                                'wallet',
                                'refer_code',
                                'mobile_verification_status',
                                'user_bank_wallet_status',
                                'phone_pay_mobile',
                                'google_pay_mobile',
                                'paytm_pay_mobile',
                                'bank_name',
                                'bank_ac_number',
                                'bank_ifsc',
                                'status',
                                'created_at',
                                'updated_at'
                            )
                            ->first();

                        $url = "https://gsboss.in/";

                        //$share_msg='Install the Pride app to make up to Rs. 1000 every day.'. "\n".'Use the following referral code to sign up....'. "\n".'The reference number is : '.$user_profile->refer_code.''. "\n".'Visit '.$url.' to download today';

                        $share_msg = 'Install the Pride app to make up to Rs. 1000 every day.' . "\n" . 'Visit ' . $url . ' to download today';

                        echo json_encode([
                            "code" => "1",
                            "profile" => $user_profile,
                            "share_msg" => $share_msg,
                            "msg" => "Successfully",
                        ]);
                    }
                }
            }
        }
    }
    public function update_bank_wallet(Request $request)
    {
        $object = new ApiCrypterController();
        $validation = new ApiValidationController();
        $authKeyEncryted = $request->header('auth-key');
        if (empty($authKeyEncryted)) {
            return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
        } else {
            $authokey = $object->auth_key($authKeyEncryted);
            if (!$authokey) {
                return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
            } else {
                $rawdata = json_decode($request->getContent(), true);

                if (
                    !isset($rawdata['reg_no']) ||
                    !isset($rawdata['token']) ||
                    !isset($rawdata['bank_name']) ||
                    !isset($rawdata['account_no']) ||
                    !isset($rawdata['ifsc']) ||
                    !isset($rawdata['phone_pay_mobile']) ||
                    !isset($rawdata['google_pay_mobile']) ||
                    !isset($rawdata['paytm_pay_mobile'])
                ) {
                    echo json_encode([
                        "code" => "0",
                        "msg" => "Unauthorized Request",
                    ]);
                } else {
                    $reg_no = $object->openssl_decrypt($rawdata['reg_no']);
                    $token = $object->openssl_decrypt($rawdata['token']);
                    $bank_name = $rawdata['bank_name'];
                    $account_no = $rawdata['account_no'];
                    $ifsc = $rawdata['ifsc'];
                    $phone_pay_mobile = $rawdata['phone_pay_mobile'];
                    $google_pay_mobile = $rawdata['google_pay_mobile'];
                    $paytm_pay_mobile = $rawdata['paytm_pay_mobile'];

                    $user = DB::table('users_master')
                        ->where('reg_no', $reg_no)
                        ->where('token', $token)
                        ->first();

                    if (empty($user)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Unauthorized Request',
                        ]);
                    } else {
                        $data = [
                            'user_bank_wallet_status' => 'YES',
                            'phone_pay_mobile' => $phone_pay_mobile,
                            'google_pay_mobile' => $google_pay_mobile,
                            'paytm_pay_mobile' => $paytm_pay_mobile,
                            'bank_name' => strtoupper($bank_name),
                            'bank_ac_number' => strtoupper($account_no),
                            'bank_ifsc' => strtoupper($ifsc),
                            'updated_at' => $this->current_date_time,
                        ];

                        $update = DB::table('users_master')
                            ->where('reg_no', $reg_no)
                            ->update($data);

                        if ($update) {
                            $user_profile = DB::table('users_master')
                                ->where('reg_no', $reg_no)
                                ->select(
                                    'id',
                                    'reg_no',
                                    'full_name',
                                    'mobile',
                                    'wallet',
                                    'refer_code',
                                    'mobile_verification_status',
                                    'user_bank_wallet_status',
                                    'phone_pay_mobile',
                                    'google_pay_mobile',
                                    'paytm_pay_mobile',
                                    'bank_name',
                                    'bank_ac_number',
                                    'bank_ifsc',
                                    'status',
                                    'created_at',
                                    'updated_at'
                                )
                                ->first();

                            echo json_encode([
                                "code" => "1",
                                "profile" => $user_profile,
                                "msg" => "Success",
                            ]);
                        } else {
                            echo json_encode([
                                "code" => "0",
                                "msg" => "Somthing went to wrong. Please try again",
                            ]);
                        }
                    }
                }
            }
        }
    }
    public function withdraw_amount_screen(Request $request)
    {
        $object = new ApiCrypterController();
        $validation = new ApiValidationController();
        $authKeyEncryted = $request->header('auth-key');
        if (empty($authKeyEncryted)) {
            return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
        } else {
            $authokey = $object->auth_key($authKeyEncryted);
            if (!$authokey) {
                return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
            } else {
                $rawdata = json_decode($request->getContent(), true);

                if (!isset($rawdata['reg_no']) || !isset($rawdata['token'])) {
                    echo json_encode([
                        "code" => "0",
                        "msg" => "Unauthorized Request",
                    ]);
                } else {
                    $reg_no = $object->openssl_decrypt($rawdata['reg_no']);
                    $token = $object->openssl_decrypt($rawdata['token']);
                    $user = DB::table('users_master')
                        ->where('reg_no', $reg_no)
                        ->where('token', $token)
                        ->first();

                    if (empty($user)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Unauthorized Request',
                        ]);
                    } else {
                        echo json_encode([
                            "code" => "1",
                            "wallet" => $user->wallet,
                            "user_bank_wallet_status" => $user->user_bank_wallet_status,
                            "phone_pay_mobile" => $user->phone_pay_mobile,
                            "google_pay_mobile" => $user->google_pay_mobile,
                            "paytm_pay_mobile" => $user->paytm_pay_mobile,
                            "msg" => "Successfully",
                        ]);
                    }
                }
            }
        }
    }
    public function withdraw_amount(Request $request)
    {
        $object = new ApiCrypterController();
        $validation = new ApiValidationController();
        $authKeyEncryted = $request->header('auth-key');
        if (empty($authKeyEncryted)) {
            return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
        } else {
            $authokey = $object->auth_key($authKeyEncryted);
            if (!$authokey) {
                return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
            } else {
                $rawdata = json_decode($request->getContent(), true);

                if (!isset($rawdata['reg_no']) || !isset($rawdata['token']) || !isset($rawdata['amount']) || !isset($rawdata['select_account_type'])) {
                    echo json_encode([
                        "code" => "0",
                        "msg" => "Unauthorized Request",
                    ]);
                } else {
                    $reg_no = $object->openssl_decrypt($rawdata['reg_no']);
                    $token = $object->openssl_decrypt($rawdata['token']);
                    $amount = $rawdata['amount'];
                    $select_account_type = $rawdata['select_account_type'];

                    $user = DB::table('users_master')
                        ->where('reg_no', $reg_no)
                        ->where('token', $token)
                        ->first();

                    if (empty($user)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Unauthorized Request',
                        ]);
                    } elseif ($select_account_type == 'NA') {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Select paymnet recive account or wallet ',
                        ]);
                    } elseif ($user->user_bank_wallet_status == 'NO') {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Add  Bank/ Wallet Detail in your Account',
                        ]);
                    } elseif ($validation->numberOnly($amount)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Enter valid Amount',
                        ]);
                    } elseif ($amount > $user->wallet) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => "Insufficient funds in your wallet",
                        ]);
                    } elseif ($amount > $this->max_withdraw_limit) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => "Maximum amount withdraw limit is " . $this->max_withdraw_limit,
                        ]);
                    } elseif ($amount < $this->min_withdraw_limit) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => "Minimum amount withdraw limit is " . $this->min_withdraw_limit,
                        ]);
                    } else {
                        $transaction_id = 'TN' . str_replace(".", "", microtime(true)) . rand(100, 999);

                        switch ($select_account_type) {
                            case 'Bank':
                                $create_tran_history = [
                                    'transaction_id' => $transaction_id,
                                    'reg_no' => $reg_no,
                                    'full_name' => $user->full_name,
                                    'transfer_type' => $select_account_type,
                                    'bank_name' => $user->bank_name,
                                    'account_no' => $user->bank_ac_number,
                                    'ifsc' => $user->bank_ifsc,
                                    'phone_pay_mobile' => 'NA',
                                    'google_pay_mobile' => 'NA',
                                    'paytm_pay_mobile' => 'NA',
                                    'amount' => $amount,
                                    'status' => 'PROCESS',
                                    'status_msg' => 'Payment Request is submitted',
                                    'isRollBack' => 'NO',
                                    'source' => $this->appname,
                                    'created_at' => $this->current_date_time,
                                    'updated_at' => $this->current_date_time,
                                ];

                                $return_id = DB::table('withdraw_history_master')->insertGetId($create_tran_history);

                                if (isset($return_id)) {
                                    $total = $user->wallet - $amount;
                                    $upadet_user_wallet = [
                                        'wallet' => $total,
                                        'updated_at' => $this->current_date_time,
                                    ];

                                    $update = DB::table('users_master')
                                        ->where('reg_no', $reg_no)
                                        ->where('token', $token)
                                        ->update($upadet_user_wallet);
                                    echo json_encode([
                                        "code" => "1",
                                        "msg" => "Your withdraw request submitted Successfully. We will transfer amount in your account within 2-3 Hours",
                                    ]);
                                } else {
                                    echo json_encode([
                                        "code" => "0",
                                        "msg" => "Somthing went to wrong. Please try again",
                                    ]);
                                }

                                break;

                            case 'PhonePay':
                                $create_tran_history = [
                                    'transaction_id' => $transaction_id,
                                    'reg_no' => $reg_no,
                                    'full_name' => $user->full_name,
                                    'transfer_type' => $select_account_type,
                                    'bank_name' => 'NA',
                                    'account_no' => 'NA',
                                    'ifsc' => 'NA',
                                    'phone_pay_mobile' => $user->phone_pay_mobile,
                                    'google_pay_mobile' => 'NA',
                                    'paytm_pay_mobile' => 'NA',
                                    'amount' => $amount,
                                    'status' => 'PROCESS',
                                    'status_msg' => 'Payment Request is submitted',
                                    'isRollBack' => 'NO',
                                    'source' => $this->appname,
                                    'created_at' => $this->current_date_time,
                                    'updated_at' => $this->current_date_time,
                                ];

                                $return_id = DB::table('withdraw_history_master')->insertGetId($create_tran_history);

                                if (isset($return_id)) {
                                    $total = $user->wallet - $amount;
                                    $upadet_user_wallet = [
                                        'wallet' => $total,
                                        'updated_at' => $this->current_date_time,
                                    ];

                                    $update = DB::table('users_master')
                                        ->where('reg_no', $reg_no)
                                        ->where('token', $token)
                                        ->update($upadet_user_wallet);
                                    echo json_encode([
                                        "code" => "1",
                                        "msg" => "Your withdraw request submitted Successfully. We will transfer amount in your account within 2-3 Hours",
                                    ]);
                                } else {
                                    echo json_encode([
                                        "code" => "0",
                                        "msg" => "Somthing went to wrong. Please try again",
                                    ]);
                                }
                                break;
                            case 'GooglePay':
                                $create_tran_history = [
                                    'transaction_id' => $transaction_id,
                                    'reg_no' => $reg_no,
                                    'full_name' => $user->full_name,
                                    'transfer_type' => $select_account_type,
                                    'bank_name' => 'NA',
                                    'account_no' => 'NA',
                                    'ifsc' => 'NA',
                                    'phone_pay_mobile' => 'NA',
                                    'google_pay_mobile' => $user->google_pay_mobile,
                                    'paytm_pay_mobile' => 'NA',
                                    'amount' => $amount,
                                    'status' => 'PROCESS',
                                    'status_msg' => 'Payment Request is submitted',
                                    'isRollBack' => 'NO',
                                    'source' => $this->appname,
                                    'created_at' => $this->current_date_time,
                                    'updated_at' => $this->current_date_time,
                                ];

                                $return_id = DB::table('withdraw_history_master')->insertGetId($create_tran_history);

                                if (isset($return_id)) {
                                    $total = $user->wallet - $amount;
                                    $upadet_user_wallet = [
                                        'wallet' => $total,
                                        'updated_at' => $this->current_date_time,
                                    ];

                                    $update = DB::table('users_master')
                                        ->where('reg_no', $reg_no)
                                        ->where('token', $token)
                                        ->update($upadet_user_wallet);
                                    echo json_encode([
                                        "code" => "1",
                                        "msg" => "Your withdraw request submitted Successfully. We will transfer amount in your account within 2-3 Hours",
                                    ]);
                                } else {
                                    echo json_encode([
                                        "code" => "0",
                                        "msg" => "Somthing went to wrong. Please try again",
                                    ]);
                                }
                                break;
                            case 'PaytmPay':
                                $create_tran_history = [
                                    'transaction_id' => $transaction_id,
                                    'reg_no' => $reg_no,
                                    'full_name' => $user->full_name,
                                    'phone_pay_mobile' => $user->phone_pay_mobile,
                                    'google_pay_mobile' => $user->google_pay_mobile,
                                    'paytm_pay_mobile' => $user->paytm_pay_mobile,
                                    'amount' => $amount,
                                    'status' => 'PROCESS',
                                    'status_msg' => 'Payment Request is submitted',
                                    'isRollBack' => 'NO',
                                    'source' => $this->appname,
                                    'created_at' => $this->current_date_time,
                                    'updated_at' => $this->current_date_time,
                                ];

                                $return_id = DB::table('withdraw_history_master')->insertGetId($create_tran_history);

                                if (isset($return_id)) {
                                    $total = $user->wallet - $amount;
                                    $upadet_user_wallet = [
                                        'wallet' => $total,
                                        'updated_at' => $this->current_date_time,
                                    ];

                                    $update = DB::table('users_master')
                                        ->where('reg_no', $reg_no)
                                        ->where('token', $token)
                                        ->update($upadet_user_wallet);
                                    echo json_encode([
                                        "code" => "1",
                                        "msg" => "Your withdraw request submitted Successfully. We will transfer amount in your account within 2-3 Hours",
                                    ]);
                                } else {
                                    echo json_encode([
                                        "code" => "0",
                                        "msg" => "Somthing went to wrong. Please try again",
                                    ]);
                                }
                                // code...
                                break;
                        }
                    }
                }
            }
        }
    }
    public function withdraw_history(Request $request)
    {
        $object = new ApiCrypterController();
        $validation = new ApiValidationController();
        $authKeyEncryted = $request->header('auth-key');
        if (empty($authKeyEncryted)) {
            return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
        } else {
            $authokey = $object->auth_key($authKeyEncryted);
            if (!$authokey) {
                return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
            } else {
                $rawdata = json_decode($request->getContent(), true);

                if (!isset($rawdata['reg_no']) || !isset($rawdata['token']) || !isset($rawdata['status'])) {
                    echo json_encode([
                        "code" => "0",
                        "msg" => "Unauthorized Request",
                    ]);
                } else {
                    $reg_no = $object->openssl_decrypt($rawdata['reg_no']);
                    $token = $object->openssl_decrypt($rawdata['token']);
                    $status = $rawdata['status'];
                    $user = DB::table('users_master')
                        ->where('reg_no', $reg_no)
                        ->where('token', $token)
                        ->first();

                    if (empty($user)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Unauthorized Request',
                        ]);
                    } else {
                        $withdraw_history = DB::table('withdraw_history_master')
                            ->where('reg_no', $reg_no)
                            ->where('status', $status)
                            ->get()
                            ->take(100);

                        echo json_encode([
                            "code" => "1",
                            "withdraw_history" => $withdraw_history,
                            "msg" => 'Success',
                        ]);
                    }
                }
            }
        }
    }

    public function deposit_amount_screen(Request $request)
    {
        $object = new ApiCrypterController();
        $validation = new ApiValidationController();
        $authKeyEncryted = $request->header('auth-key');
        if (empty($authKeyEncryted)) {
            return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
        } else {
            $authokey = $object->auth_key($authKeyEncryted);
            if (!$authokey) {
                return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
            } else {
                $rawdata = json_decode($request->getContent(), true);

                if (!isset($rawdata['reg_no']) || !isset($rawdata['token'])) {
                    echo json_encode([
                        "code" => "0",
                        "msg" => "Unauthorized Request",
                    ]);
                } else {
                    $reg_no = $object->openssl_decrypt($rawdata['reg_no']);
                    $token = $object->openssl_decrypt($rawdata['token']);
                    $user = DB::table('users_master')
                        ->where('reg_no', $reg_no)
                        ->where('token', $token)
                        ->first();

                    if (empty($user)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Unauthorized Request',
                        ]);
                    } else {
                        $payment_deposit_acc = DB::table('payment_recive_acc_master')
                            ->where('product', $this->appname)
                            ->where('status', 'Enable')
                            ->get();

                        if (count($payment_deposit_acc) == 0) {
                            echo json_encode([
                                "code" => "1",
                                "wallet" => $user->wallet,
                                "deposit_ac_status" => "Disable",
                                "msg" => "Successfully",
                            ]);
                        } else {
                            echo json_encode([
                                "code" => "1",
                                "wallet" => $user->wallet,
                                "deposit_ac_list" => $payment_deposit_acc,
                                "deposit_ac_status" => "Enable",
                                "msg" => "Successfully",
                            ]);
                        }
                    }
                }
            }
        }
    }
    public function deposit_amount(Request $request)
    {
        $object = new ApiCrypterController();
        $validation = new ApiValidationController();
        $authKeyEncryted = $request->header('auth-key');
        if (empty($authKeyEncryted)) {
            return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
        } else {
            $authokey = $object->auth_key($authKeyEncryted);
            if (!$authokey) {
                return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
            } else {
                $rawdata = json_decode($request->getContent(), true);

                if (!isset($rawdata['reg_no']) || !isset($rawdata['token']) || !isset($rawdata['amount']) || !isset($rawdata['merchant_transaction_id'])) {
                    echo json_encode([
                        "code" => "0",
                        "msg" => "Unauthorized Requeste",
                    ]);
                } else {
                    $reg_no = $object->openssl_decrypt($rawdata['reg_no']);
                    $token = $object->openssl_decrypt($rawdata['token']);
                    $amount = $rawdata['amount'];
                    $merchant_transaction_id = $rawdata['merchant_transaction_id'];
                    $user = DB::table('users_master')
                        ->where('reg_no', $reg_no)
                        ->where('token', $token)
                        ->first();

                    if (empty($user)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Unauthorized Requeste',
                        ]);
                    } elseif ($validation->noSpcialCharacterWithoutSpace($merchant_transaction_id)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Ref No / UTR No Number Must be Alphabet and Numaric',
                        ]);
                    } elseif ($validation->numberOnly($amount)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Enter valid Amount',
                        ]);
                    } elseif ($amount > $this->max_deposit_limit) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => "Maximum amount deposit limit is " . $this->max_deposit_limit,
                        ]);
                    } elseif ($amount < $this->min_deposit_limit) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => "Minimum amount deposit limit is " . $this->min_deposit_limit,
                        ]);
                    } else {
                        $transaction_id = 'TN' . str_replace(".", "", microtime(true)) . rand(100, 999);
                        $create_deposit_history = [
                            'transaction_id' => $transaction_id,
                            'merchant_transaction_id' => $merchant_transaction_id,
                            'reg_no' => $reg_no,
                            'full_name' => $user->full_name,
                            'payout_mode' => 'UPI',
                            'amount' => $amount,
                            'status' => 'PROCESS',
                            'status_msg' => 'Payment Request is submitted',
                            'source' => $this->appname,
                            'created_at' => $this->current_date_time,
                            'updated_at' => $this->current_date_time,
                        ];
                        $return_id = DB::table('deposit_history_master')->insertGetId($create_deposit_history);

                        if (isset($return_id)) {
                            echo json_encode([
                                "code" => "1",
                                "msg" => "Your Deposit request submitted Successfully. We will add amount in your account within 2-3 Hours",
                            ]);
                        } else {
                            echo json_encode([
                                "code" => "0",
                                "msg" => "Somthing went to wrong. Please try again",
                            ]);
                        }
                    }
                }
            }
        }
    }
    public function deposit_history(Request $request)
    {
        $object = new ApiCrypterController();
        $validation = new ApiValidationController();
        $authKeyEncryted = $request->header('auth-key');
        if (empty($authKeyEncryted)) {
            return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
        } else {
            $authokey = $object->auth_key($authKeyEncryted);
            if (!$authokey) {
                return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
            } else {
                $rawdata = json_decode($request->getContent(), true);

                if (!isset($rawdata['reg_no']) || !isset($rawdata['token']) || !isset($rawdata['status'])) {
                    echo json_encode([
                        "code" => "0",
                        "msg" => "Unauthorized Request",
                    ]);
                } else {
                    $reg_no = $object->openssl_decrypt($rawdata['reg_no']);
                    $token = $object->openssl_decrypt($rawdata['token']);
                    $status = $rawdata['status'];
                    $user = DB::table('users_master')
                        ->where('reg_no', $reg_no)
                        ->where('token', $token)
                        ->first();

                    if (empty($user)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Unauthorized Request',
                        ]);
                    } else {
                        $deposit_history = DB::table('deposit_history_master')
                            ->where('reg_no', $reg_no)
                            ->where('status', $status)
                            ->get()
                            ->take(100);

                        echo json_encode([
                            "code" => "1",
                            "deposit_history" => $deposit_history,
                            "msg" => 'Success',
                        ]);
                    }
                }
            }
        }
    }
    public function game_rate(Request $request)
    {
        $object = new ApiCrypterController();
        $validation = new ApiValidationController();
        $authKeyEncryted = $request->header('auth-key');
        if (empty($authKeyEncryted)) {
            return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
        } else {
            $authokey = $object->auth_key($authKeyEncryted);
            if (!$authokey) {
                return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
            } else {
                $rawdata = json_decode($request->getContent(), true);

                if (!isset($rawdata['reg_no']) || !isset($rawdata['token'])) {
                    echo json_encode([
                        "code" => "0",
                        "msg" => "Unauthorized Request",
                    ]);
                } else {
                    $reg_no = $object->openssl_decrypt($rawdata['reg_no']);
                    $token = $object->openssl_decrypt($rawdata['token']);
                    $user = DB::table('users_master')
                        ->where('reg_no', $reg_no)
                        ->where('token', $token)
                        ->first();

                    if (empty($user)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Unauthorized Request',
                        ]);
                    } else {
                        $game_rate_list = DB::table('game_rate_master')
                            ->where('status', 'Enable')
                            ->where('product', $this->appname)
                            ->get();

                        echo json_encode([
                            "code" => "1",
                            "game_rate_list" => $game_rate_list,
                            "msg" => 'Success',
                        ]);
                    }
                }
            }
        }
    }

    public function submit_game_number(Request $request)
    {
        $object = new ApiCrypterController();
        $validation = new ApiValidationController();
        $authKeyEncryted = $request->header('auth-key');
        if (empty($authKeyEncryted)) {
            return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
        } else {
            $authokey = $object->auth_key($authKeyEncryted);
            if (!$authokey) {
                return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
            } else {
                $rawdata = json_decode($request->getContent(), true);

                if (
                    !isset($rawdata['reg_no']) ||
                    !isset($rawdata['token']) ||
                    !isset($rawdata['lottery_date']) ||
                    !isset($rawdata['lottery_name']) ||
                    !isset($rawdata['game_type']) ||
                    !isset($rawdata['cart_bet_item']) ||
                    !isset($rawdata['total_amount'])
                ) {
                    echo json_encode([
                        "code" => "0",
                        "msg" => "Unauthorized Request",
                    ]);
                } else {
                    $reg_no = $object->openssl_decrypt($rawdata['reg_no']);
                    $token = $object->openssl_decrypt($rawdata['token']);
                    $lottery_date = $rawdata['lottery_date'];
                    $lottery_name = $rawdata['lottery_name'];
                    $game_type = $rawdata['game_type'];
                    $cart_bet_item = trim(preg_replace('/\s+/', ' ', $rawdata['cart_bet_item']));
                    $amount = $rawdata['total_amount'];
                    $user = DB::table('users_master')
                        ->where('reg_no', $reg_no)
                        ->where('token', $token)
                        ->first();
                    $lottery = DB::table('lottery_name_master')
                        ->whereDate('lottery_date', $lottery_date)
                        ->where('lottery_name', $lottery_name)
                        ->where('status', 'Open')
                        ->first();

                    if (empty($user)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Unauthorized Request',
                        ]);
                    } elseif ($this->betting_close == "NO") {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Betting Close For Some Time',
                        ]);
                    } elseif (empty($lottery)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Unauthorized Request',
                        ]);
                    }else if ($this->today_date != $lottery->lottery_date) 
                    {

                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Today Betting is close',
                        ]);

                    }elseif ($validation->numberOnly($amount)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Enter Valid Amount.',
                        ]);
                    } elseif ($amount < $this->min_betting_limit) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Mininum Bet Amount is Rs. 10',
                        ]);
                    } elseif ($amount > $user->wallet) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Insufficient funds in wallet.',
                        ]);
                    } else {
                        $now = Carbon::now();
                        $current_time = $now->format('g:iA');

                        switch ($game_type) {
                            case 'Open':

                                
                                $now = Carbon::now();
                                
                                $add_extra_minut = (new Carbon($current_time))->addMinutes($this->betting_close_before)->format('g:iA');
                                $current_time_extra_minut = strtotime($add_extra_minut);
                                $bet_close_time = strtotime($lottery->open_time);
                                if ($current_time_extra_minut > $bet_close_time) {
                                    echo json_encode([
                                        "code" => "0",
                                        "msg" => 'Betting Close Befor '.$this->betting_close_before.' Minuts of Market Open Betting Time '.$lottery->open_time,
                                    ]);
                                }  else {
                                    $total = $user->wallet - $amount;
                                    $update = DB::table('users_master')
                                        ->where('reg_no', $reg_no)
                                        ->update(['wallet' => $total, 'updated_at' => $this->current_date_time]);
                                    if ($update) {
                                        $date = new Carbon($lottery_date);
                                        $cart_bet_item = json_decode($cart_bet_item, true);
                                        foreach ($cart_bet_item as $value) {
                                            $lottery_category = DB::table('game_rate_master')
                                                ->where('product', $this->appname)
                                                ->where('game_name', $value['GameCategory'])
                                                ->first();

                                            if (!empty($lottery_category)) {
                                                $data = [
                                                    'reg_no' => $user->reg_no,
                                                    'lottery_date' => $lottery_date,
                                                    'lottery_day' => strtoupper($date->shortEnglishDayOfWeek),
                                                    'lottery_name' => $lottery_name,
                                                    'open_time' => $lottery->open_time,
                                                    'close_time' => $lottery->close_time,
                                                    'lottery_game_type' => $value['GameType'],
                                                    'lottery_category_type' => $value['GameCategory'],
                                                    'lottery_numbers' => $value['GameNumber'],
                                                    'lottery_rate' => $lottery_category->xrate,
                                                    'lottery_amount' => $value['GameAmount'],
                                                    'won_lottery_amount' => $value['GameAmount'] * $lottery_category->xrate,
                                                    'result_number' => 'NA',
                                                    'status' => "PENDING",
                                                    'isTransfer' => "NO",
                                                    'source' => $this->appname,
                                                    'created_at' => $this->current_date_time,
                                                    'updated_at' => $this->current_date_time,
                                                ];

                                                DB::table('lottery_result_master')->insert($data);
                                            }
                                        }

                                        echo json_encode([
                                            "code" => "1",
                                            "msg" => "Bet Submited Successfully",
                                        ]);
                                    } else {
                                        echo json_encode([
                                            "code" => "0",
                                            "msg" => "Somthing went to wrong. Please try again",
                                        ]);
                                    }
                                }

                                
                                break;

                            case 'Close':


                                $isContainOpen = false;
                                $cart_bet_item = json_decode($cart_bet_item, true);
                                foreach ($cart_bet_item as $value) {
                                    if ($value['GameType'] == "Open") {
                                        $isContainOpen = true;
                                    }
                                }
                                $isContainJodi = false;
                                
                                foreach ($cart_bet_item as $value) {
                                    if ($value['GameCategory'] == "Jodi") {
                                        $isContainJodi = true;
                                    }
                                }
                                
                                $add_extra_minut = (new Carbon($current_time))->addMinutes($this->betting_close_before)->format('g:iA');
                                $current_time_extra_minut = strtotime($add_extra_minut);
                                $bet_close_time = strtotime($lottery->close_time);
                                if ($current_time_extra_minut > $bet_close_time) {
                                    echo json_encode([
                                        "code" => "0",
                                        "msg" => 'Betting Close Befor '.$this->betting_close_before.' Minuts of Market Close Betting Time '.$lottery->close_time,
                                    ]);
                                } elseif ($isContainOpen) {
                                    echo json_encode([
                                        "code" => "0",
                                        "msg" => "You can not play open betting",
                                    ]);
                                } elseif ($isContainJodi) {
                                    echo json_encode([
                                        "code" => "0",
                                        "msg" => "You can not play jodi as as closing",
                                    ]);
                                }  else {

        
                                    $total = $user->wallet - $amount;
                                    $update = DB::table('users_master')
                                        ->where('reg_no', $reg_no)
                                        ->update(['wallet' => $total, 'updated_at' => $this->current_date_time]);
                                    if ($update) {
                                        $date = new Carbon($lottery_date);
                                        

                                        foreach ($cart_bet_item as $value) {
                                            $lottery_category = DB::table('game_rate_master')
                                                ->where('product', $this->appname)
                                                ->where('game_name', $value['GameCategory'])
                                                ->first();

                                            if (!empty($lottery_category)) {
                                                $data = [
                                                    'reg_no' => $user->reg_no,
                                                    'lottery_date' => $lottery_date,
                                                    'lottery_day' => strtoupper($date->shortEnglishDayOfWeek),
                                                    'lottery_name' => $lottery_name,
                                                    'open_time' => $lottery->open_time,
                                                    'close_time' => $lottery->close_time,
                                                    'lottery_game_type' => $value['GameType'],
                                                    'lottery_category_type' => $value['GameCategory'],
                                                    'lottery_numbers' => $value['GameNumber'],
                                                    'lottery_rate' => $lottery_category->xrate,
                                                    'lottery_amount' => $value['GameAmount'],
                                                    'won_lottery_amount' => $value['GameAmount'] * $lottery_category->xrate,
                                                    'result_number' => 'NA',
                                                    'status' => "PENDING",
                                                    'isTransfer' => "NO",
                                                    'source' => $this->appname,
                                                    'created_at' => $this->current_date_time,
                                                    'updated_at' => $this->current_date_time,
                                                ];

                                                DB::table('lottery_result_master')->insert($data);
                                            }
                                        }

                                        echo json_encode([
                                            "code" => "1",
                                            "msg" => "Bet Submited Successfully",
                                        ]);
                                    } else {
                                        echo json_encode([
                                            "code" => "0",
                                            "msg" => "Somthing went to wrong. Please try again",
                                        ]);
                                    }
                                }

                                // code...
                                break;
                        }
                    }
                }
            }
        }
    }

    public function lottery_history(Request $request)
    {
        $object = new ApiCrypterController();
        $validation = new ApiValidationController();
        $authKeyEncryted = $request->header('auth-key');
        if (empty($authKeyEncryted)) {
            return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
        } else {
            $authokey = $object->auth_key($authKeyEncryted);
            if (!$authokey) {
                return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
            } else {
                $rawdata = json_decode($request->getContent(), true);

                if (!isset($rawdata['reg_no']) || !isset($rawdata['token']) || !isset($rawdata['status'])) {
                    echo json_encode([
                        "code" => "0",
                        "msg" => "Unauthorized Request",
                    ]);
                } else {
                    $reg_no = $object->openssl_decrypt($rawdata['reg_no']);
                    $token = $object->openssl_decrypt($rawdata['token']);
                    $status = $rawdata['status'];
                    $user = DB::table('users_master')
                        ->where('reg_no', $reg_no)
                        ->where('token', $token)
                        ->first();

                    if (empty($user)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Unauthorized Request',
                        ]);
                    } else {
                        switch ($status) {
                            case 'PENDING':
                                $lottery_history = DB::table('lottery_result_master')
                                    ->where('reg_no', $reg_no)
                                    ->where('status', 'PENDING')
                                    ->get();

                                echo json_encode([
                                    "code" => "1",
                                    "lottery_record" => $lottery_history,
                                    "msg" => 'Success',
                                ]);
                                break;

                            case 'WIN':
                                $lottery_history = DB::table('lottery_result_master')
                                    ->where('reg_no', $reg_no)
                                    ->where('status', 'WIN')
                                    ->get();

                                echo json_encode([
                                    "code" => "1",
                                    "lottery_record" => $lottery_history,
                                    "msg" => 'Success',
                                ]);
                                break;
                            case 'LOSS':
                                $lottery_history = DB::table('lottery_result_master')
                                    ->where('reg_no', $reg_no)
                                    ->where('status', 'LOSS')
                                    ->get();

                                echo json_encode([
                                    "code" => "1",
                                    "lottery_record" => $lottery_history,
                                    "msg" => 'Success',
                                ]);
                                // code...
                                break;
                        }
                    }
                }
            }
        }
    }
    public function lottery_result_history(Request $request)
    {
        $object = new ApiCrypterController();
        $validation = new ApiValidationController();
        $authKeyEncryted = $request->header('auth-key');
        if (empty($authKeyEncryted)) {
            return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
        } else {
            $authokey = $object->auth_key($authKeyEncryted);
            if (!$authokey) {
                return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
            } else {
                $rawdata = json_decode($request->getContent(), true);

                if (!isset($rawdata['reg_no']) || !isset($rawdata['token']) || !isset($rawdata['lottery_name'])) {
                    echo json_encode([
                        "code" => "0",
                        "msg" => "Unauthorized Request",
                    ]);
                } else {
                    $reg_no = $object->openssl_decrypt($rawdata['reg_no']);
                    $token = $object->openssl_decrypt($rawdata['token']);
                    $lottery_name = $rawdata['lottery_name'];
                    $user = DB::table('users_master')
                        ->where('reg_no', $reg_no)
                        ->where('token', $token)
                        ->first();

                    if (empty($user)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Unauthorized Request',
                        ]);
                    } else {
                        $lottery_result_history = DB::table('lottery_result_history_master')
                            ->where('lottery_name', $lottery_name)
                            ->orderBy('lottery_date', 'ASC')
                            ->get();

                        echo json_encode([
                            "code" => "1",
                            "lottery_result_history" => $lottery_result_history,
                            "msg" => 'Success',
                        ]);
                    }
                }
            }
        }
    }

    public function user_query(Request $request)
    {
        $object = new ApiCrypterController();
        $validation = new ApiValidationController();
        $authKeyEncryted = $request->header('auth-key');
        if (empty($authKeyEncryted)) {
            return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
        } else {
            $authokey = $object->auth_key($authKeyEncryted);
            if (!$authokey) {
                return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
            } else {
                $rawdata = json_decode($request->getContent(), true);

                if (!isset($rawdata['reg_no']) || !isset($rawdata['token']) || !isset($rawdata['query'])) {
                    echo json_encode([
                        "code" => "0",
                        "msg" => "Unauthorized Request",
                    ]);
                } else {
                    $reg_no = $object->openssl_decrypt($rawdata['reg_no']);
                    $token = $object->openssl_decrypt($rawdata['token']);
                    $query = $rawdata['query'];
                    $user = DB::table('users_master')
                        ->where('reg_no', $reg_no)
                        ->where('token', $token)
                        ->first();

                    if (empty($user)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Unauthorized Request',
                        ]);
                    } elseif (empty($query)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Enter your query ',
                        ]);
                    } else {
                        $data = [
                            'reg_no' => $reg_no,
                            'full_name' => strtoupper($user->full_name),
                            'mobile' => strtoupper($user->mobile),
                            'query' => $query,
                            'revert' => 'One of our team will be in contact with you shortly',
                            'status' => "Open",
                            'source' => $this->appname,
                            'created_at' => $this->current_date_time,
                            'updated_at' => $this->current_date_time,
                        ];
                        $return_id = DB::table('help_and_support')->insertGetId($data);

                        if (isset($return_id)) {
                            $uniquenumber = $return_id;
                            $ticket_no = 'TK' . strtoupper($this->genratenumber(8, $uniquenumber));

                            DB::table('help_and_support')
                                ->where('id', $return_id)
                                ->update(['ticket_no' => $ticket_no]);

                            echo json_encode([
                                "code" => "1",
                                "msg" => "Your Query  Submited Successfully and One of our team will be in contact with you shortly",
                            ]);
                        } else {
                            echo json_encode([
                                "code" => "0",
                                "msg" => "Somthing went to wrong. Please try again",
                            ]);
                        }
                    }
                }
            }
        }
    }
    public function user_query_list(Request $request)
    {
        $object = new ApiCrypterController();
        $validation = new ApiValidationController();
        $authKeyEncryted = $request->header('auth-key');
        if (empty($authKeyEncryted)) {
            return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
        } else {
            $authokey = $object->auth_key($authKeyEncryted);
            if (!$authokey) {
                return response()->json(['code' => 0, 'msg' => 'Unauthorized Request']);
            } else {
                $rawdata = json_decode($request->getContent(), true);

                if (!isset($rawdata['reg_no']) || !isset($rawdata['token'])) {
                    echo json_encode([
                        "code" => "0",
                        "msg" => "Unauthorized Request",
                    ]);
                } else {
                    $reg_no = $object->openssl_decrypt($rawdata['reg_no']);
                    $token = $object->openssl_decrypt($rawdata['token']);

                    $user = DB::table('users_master')
                        ->where('reg_no', $reg_no)
                        ->where('token', $token)
                        ->first();

                    if (empty($user)) {
                        echo json_encode([
                            "code" => "0",
                            "msg" => 'Unauthorized Request',
                        ]);
                    } else {
                        $help_and_support = DB::table('help_and_support')
                            ->where('reg_no', $reg_no)
                            ->get();
                        echo json_encode([
                            "code" => "1",
                            "query_list" => $help_and_support,
                            "msg" => "Success",
                        ]);
                    }
                }
            }
        }
    }

    public function send_otp_mobile($mobile)
    {
        $mobile = $mobile;
        $check_old_otp = DB::table('otp_master')
            ->where('mobile_email', $mobile)
            ->where('type', 'Mobile')
            ->first();
        if (empty($check_old_otp)) {
            $otp = rand(11111, 99999);
        } else {
            $otp = $check_old_otp->otp;
        }

        $data = [
            'type' => 'Mobile',
            'mobile_email' => $mobile,
            'otp' => $otp,
            'created_at' => $this->current_date_time,
            'updated_at' => $this->current_date_time,
        ];
        $return_id = DB::table('otp_master')->insertGetId($data);
        if (isset($return_id)) {
            $url = "https://msg.mtalkz.com/V2/http-api.php?apikey=dXGaIrojgcvprxBq&senderid=MTAMOI&number=91$mobile&message=Your%20OTP-%20One%20Time%20Password%20is%20$otp%20to%20authenticate%20your%20login%20with%20$otp%20Powered%20By%20mTalkz&format=json";
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ]);

            $response = curl_exec($curl);

            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                return "2";
            } else {
                return "1";
            }
        } else {
            return "0";
        }
    }
    public function verify_otp_mobile($mobile, $otp)
    {
        $find_otp = DB::table('otp_master')
            ->where('mobile_email', $mobile)
            ->where('otp', $otp)
            ->first();
        if (empty($find_otp)) {
            return "2";
        } else {
            DB::table('otp_master')
                ->where('mobile_email', $mobile)
                ->delete();
            return "1";
        }
    }
    public function genratenumber($limit, $uniquenumber)
    {
        $time = str_replace(".", "", microtime(true)) . rand(10, 99) . $uniquenumber;
        return substr(base_convert(sha1($time), 16, 36), 0, $limit);
    }
}
