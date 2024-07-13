<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\LoginRequest;
use App\Http\Requests\Mobile\LoginVerifyRequest;
use App\Http\Requests\Mobile\RegisterEmailVerifyRequest;
use App\Http\Requests\Mobile\RegisterEmailVerifyResendRequest;
use App\Http\Requests\Mobile\RegisterPhoneVerifyRequest;
use App\Http\Requests\Mobile\RegisterPhoneVerifyResendRequest;
use App\Http\Requests\Mobile\RegisterRequest;
use App\Http\Requests\Mobile\RegisterStepRequest;
use App\Http\Resources\RegisterQuestionResource;
use App\Http\Resources\UserResource;
use App\Mail\LoginVerifyMail;
use App\Mail\RegisterVerifyMail;
use App\Models\RegisterQuestion;
use App\Models\RegisterQuestionAnswer;
use App\Models\Session;
use App\Models\User;
use App\Modules\Sms\SmsModule;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * @tags 😸 Mobile > 1 > Auth
 */
class AuthController extends Controller
{

    /**
     * Auth Login
     *
     * Bu servis sisteme giriş yapmak kullanılan servistir. Aynı zamanda tekrar kod gönder servisidir.
     * @unauthenticated
     */
    public function login(LoginRequest $request)
    {
        $credential = $request->input('credential');
        $isMail = filter_var($credential, FILTER_VALIDATE_EMAIL);
        $user = $isMail ? User::where('email', $credential)->first()
            : User::where('phone', $credential)->first();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $verifyCode = User::makeAuthVerifyCode();
        $user->setAuthVerifyCode(intval($verifyCode));

        if ($isMail) {
            Mail::to($user->email)->send(new LoginVerifyMail($user, $verifyCode));
            return response()->json([
                "message" => "Mail doğrulaması gönderildi.",
                "credential" => $credential,
            ]);
        } else {
            $sms = new SmsModule();
            $sms->sendSms($credential, "Royalmid uygulamasına giriş yapmak için\n\nDoğrulama Kodunuz: " . $verifyCode);
            return response()->json([
                "message" => "Sms doğrulaması gönderildi.",
                "credential" => $credential
            ]);
        }
    }

    /**
     * Auth Login Verify
     *
     * Bu servis giriş için doğrulama servisidir.
     * @unauthenticated
     */
    public function loginVerify(LoginVerifyRequest $request)
    {
        $credential = $request->input('credential');
        $verifyCode = $request->input('verify_code');

        $isMail = filter_var($credential, FILTER_VALIDATE_EMAIL);
        $user = $isMail ? User::where('email', $credential)->first()
            : User::where('phone', $credential)->first();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        $currentDateTime = Carbon::now();
        $verifyDateTime = Carbon::parse($user->auth_verify_time);

        if ($user->auth_verify_code === $verifyCode && !$currentDateTime->greaterThan($verifyDateTime)) {
            $token = JWTAuth::fromUser($user);

            auth("user-api")->setUser($user);
            Session::create([
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                'last_activity' => now(),
                'token' => $token,
                'user_id' => $user->id,
                'role' => $user->role
            ]);

            User::where("id", $user->id)->update([
                "auth_verify_code" => null,
                "auth_verify_time" => null,
            ]);

            return [
                /**
                 * @var string Giriş ve uygulama işlemleri için token
                 * @example ey...
                 */
                'accessToken' => $token,

                /** @var UserResource */
                "user" => new UserResource($user)
            ];
        }

        return response()->json([
            "message" => "Doğrulama kodunuz hatalı veya süresi geçmiş"
        ], 400);
    }


    /**
     * Auth Register
     *
     * Bu servis sisteme kayıt olmak için kullanılan servistir.
     * @unauthenticated
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            "name" => $request->input('name'),
            "surname" => $request->input('surname'),
            "phone" => $request->input('phone'),
            "phone_code" => $request->input('phone_code'),
            "email" => $request->input('email'),
        ]);

        if (@$user->id) {
            //Email doğrulama kodu
            $verifyCode = User::makeEmailVerifyCode();
            $user->setEmailVerifyCode($verifyCode);

            Mail::to($user->email)->send(new RegisterVerifyMail($user, $verifyCode));
            return [
                /**
                 * @var string
                 * @example E-posta doğrulanması gönderildi.
                 */
                "message" => "E-posta doğrulanması gönderildi",
                /**
                 * @var string
                 * @example kesemenere123@gmail.com.
                 */
                "credential" => $user->email
            ];
        }

        throw new Exception('Teknik bir sorun oluştu lütfen tekrar deneyiniz.', 500);
    }

    /**
     * Auth Register Email Resend
     *
     * Bu servis eposta yeni bir doğrulama kodu gönderir.
     * @unauthenticated
     */
    public function registerEmailResend(RegisterEmailVerifyResendRequest $request)
    {
        $user = User::where("email", $request->email)->first();

        if (@$user->id) {
            $verifyCode = User::makeEmailVerifyCode();
            $user->setEmailVerifyCode($verifyCode);

            Mail::to($user->email)->send(new RegisterVerifyMail($user, $verifyCode));
            return [
                /**
                 * @var string
                 * @example E-posta doğrulaması.
                 */
                "message" => "E-posta doğrulaması gönderildi.",
                /**
                 * @var string
                 * @example kesemenere123@gmail.com.
                 */
                "credential" => $user->email
            ];
        }

        throw new Exception('Teknik bir sorun oluştu lütfen tekrar deneyiniz.', 500);
    }

    /**
     * Auth Register Email Verify
     *
     * Bu servis kayıt esnasındaki email için doğrulama ve kullanıcı tokenı döndürmesini sağlar.
     * @unauthenticated
     */
    public function registerEmailVerify(RegisterEmailVerifyRequest $request)
    {
        $email = $request->input('email');
        $verifyCode = $request->input('verify_code');

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        $currentDateTime = Carbon::now();
        $verifyDateTime = Carbon::parse($user->email_verify_time);

        if ($user->email_verify_code === $verifyCode && !$currentDateTime->greaterThan($verifyDateTime)) {
            $verifyCode = User::makePhoneVerifyCode();
            $user->setPhoneVerifyCode($verifyCode);

            $sms = new SmsModule();
            $sms->sendSms($user->phone, "Royalmind uygulamasına kayıt olmak için\n\nDoğrulama Kodunuz: " . $verifyCode);

            return [
                /**
                 * @var string
                 * @example Sms doğrulaması gönderildi.
                 */
                "message" => "Sms doğrulaması gönderildi.",

                /**
                 * @var string
                 * @example 905418322382.
                 */
                "credential" => $user->phone
            ];
        }

        return response()->json([
            "message" => "Doğrulama kodunuz hatalı veya süresi geçmiş"
        ], 400);
    }

    /**
     * Auth Register Phone Resend
     *
     * Bu servis telefon numarasına yeni bir doğrulama kodu gönderir.
     * @unauthenticated
     */
    public function registerPhoneResend(RegisterPhoneVerifyResendRequest $request)
    {
        $user = User::where("phone", $request->phone)->first();
        if (@$user->id) {
            $verifyCode = User::makePhoneVerifyCode();
            $user->setPhoneVerifyCode($verifyCode);

            $sms = new SmsModule();
            $sms->sendSms($user->phone, "Royalmind uygulamasına kayıt olmak için\n\nDoğrulama Kodunuz: " . $verifyCode);

            return [
                /**
                 * @var string
                 * @example Sms doğrulaması gönderildi.
                 */
                "message" => "E-posta doğrulaması gönderildi.",

                /**
                 * @var string
                 * @example 905418322382.
                 */
                "credential" => $user->phone
            ];
        }

        throw new Exception('Teknik bir sorun oluştu lütfen tekrar deneyiniz.', 500);
    }


    /**
     * Auth Register Phone Verify
     *
     * Bu servis kayıt esnasındaki telefon için doğrulama ve email kodunu otomatik gönderen servistir. Tekrar gönder işlemi başka servis üzerinden gerçekleştirilmelidir
     * @unauthenticated
     */
    public function registerPhoneVerify(RegisterPhoneVerifyRequest $request)
    {
        $phone = $request->input('phone');
        $verifyCode = $request->input('verify_code');
        $user = User::where('phone', $phone)->first();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $currentDateTime = Carbon::now();
        $verifyDateTime = Carbon::parse($user->phone_verify_time);

        if ($user->phone_verify_code === $verifyCode && !$currentDateTime->greaterThan($verifyDateTime)) {
            $userUpdate = User::where("id", $user->id)->update([
                "phone_verify_code" => null,
                "phone_verify_time" => null,
                "is_phone_verify" => true,
            ]);

            if ($userUpdate) {
                $token = JWTAuth::fromUser($user);
                auth("user-api")->setUser($user);
                Session::create([
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->header('User-Agent'),
                    'last_activity' => now(),
                    'token' => $token,
                    'user_id' => $user->id,
                    'role' => $user->role
                ]);

                User::where("id", $user->id)->update([
                    "email_verify_code" => null,
                    "email_verify_time" => null,
                    "is_email_verify" => true,
                ]);

                return [
                    /**
                     * @var string Giriş ve uygulama işlemleri için token
                     * @example ey...
                     */
                    'accessToken' => $token,
                    /** @var UserResource */
                    "user" => new UserResource($user)
                ];
            }

            throw new Exception('Teknik bir sorun oluştu lütfen tekrar deneyiniz.', 500);
        }

        return response()->json([
            "message" => "Doğrulama kodunuz hatalı veya süresi geçmiş"
        ], 400);
    }


    /**
     * Auth Register Questions
     *
     * Bu servis kayıt edilmesi için dinamik soruları listler.
     * @unauthenticated
     */
    public function registerSteps()
    {
        return RegisterQuestionResource::collection(
            RegisterQuestion::where("is_active", true)
                ->with("options")
                ->orderBy('sort', "asc")
                ->get()
        );
    }


    /**
     * Auth Register Step
     *
     * Bu servis dinamik soruları ve kullanıcının diğer bilgilerini kayıt eder.
     *
     */
    public function registerStep(RegisterStepRequest $request)
    {
        if (!$user = Auth::guard('user-api')->user()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userUpdate = User::where("id", $user->id)->update([
            "birthday" => Carbon::parse($request->input('birthday')),
            "city_id" => @$request->input('city_id') ?? null,
            "country_id" => @$request->input('country_id') ?? null,
            "town_id" => @$request->input('town_id') ?? null,
        ]);

        if (RegisterQuestionAnswer::where("user_id", $user->id)->first()) {
            return response()->json([
                "message" => "Kayıt sorulari bir kez cevaplanabilir!"
            ], 400);
        }

        if ($userUpdate && $request->questions && count($request->questions)) {
            foreach ($request->questions  as $question) {
                if ($question["options"] && count($question["options"])) {
                    foreach ($question["options"] as  $option) {
                        RegisterQuestionAnswer::create([
                            'answer' => null,
                            'user_id' => $user->id,
                            'register_question_option_id' => $option["id"],
                            'register_question_id' => $question["id"],
                        ]);
                    }
                } else {
                    RegisterQuestionAnswer::create([
                        'answer' => $question["answer"],
                        'user_id' => $user->id,
                        'register_question_option_id' => null,
                        'register_question_id' => $question["id"],
                    ]);
                }
            }
        }

        return response()->json([
            "message" => "Kayıt işleminiz tamamlandı :)"
        ], 200);
    }


    /**
     * Auth Current
     *
     * Bu servis paneldeki giriş yapmış kullanıcının bilgilerini getirir.
     *
     * @response UserResource
     */
    public function current()
    {
        if (!$user = Auth::guard('user-api')->user()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return new UserResource($user);
    }

    /**
     * Auth Logout
     *
     * Bu servis sisteme çıkış yapmak için kullanılır.
     *
     */
    public function logout()
    {
        $token = JWTAuth::getToken();
        JWTAuth::authenticate($token);

        // Oturumu sonlandır
        Session::where('token', $token)->delete();
        JWTAuth::invalidate($token);
        return response()->json(['message' => 'Successfully logged out']);
    }
}
