<?php

namespace Closet\Http\Controllers\Auth;

use Mail;
use App;
use Closet\Models\User;
use Closet\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Closet\Jobs\SendVerificationEmail;
use Closet\Mail\EmailVerification;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'shop_name' => 'required|min:6|max:50|unique:shops,name|alpha_num',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|max:20|confirmed|alpha_num',
            'address' => 'required',
            'gender' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'email_token' => base64_encode($data['email']),
            'address' => $data['address'],
            'phone' => $data['phone'],
            'country' => 'th',
            'language' => 'th',
            'gender' => $data['gender'],
            'options' => json_encode([
              'order' => true,
              'email' => true,
              'comments' => true,
              'following' => true
            ]),
        ]);

        $shop = $user->shop()->create([
          'name' => $data['shop_name'],
          'slug' => uniqid('shop_'),
          'profile_type' => $data['profile_type'],
          'promotion_points' => json_encode([
            'discount' => 5,
            'campaign' => 2,
            'flash_sale' => 2,
          ])
        ]);

        return $user;
    }
    /**
    * Handle a registration request for the application.
    *
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function register(Request $request)
        {
            $this->validator($request->all())->validate();
            event(new Registered($user = $this->create($request->all())));
            if($user->country == 'th') {
              $locale = 'th';
            } else {
              $locale = 'en';
            }
            Mail::to($user->email)->queue((new EmailVerification($user, $locale))->onQueue('high'));

            return back()->with('success', 'success');
        }
    /**
    * Handle a registration request for the application.
    *
    * @param $token
    * @return \Illuminate\Http\Response
    */
    public function verify($token)
    {
      $user = User::where('email_token', $token)->first();
      $user->verified = true;

      if($user->save()){
        return redirect()->route('successRegister');
      }
    }
    public function success()
    {
      return view('email.success');
    }
    public function resendEmailPage()
    {
      return view('auth.email.resend');
    }
    public function resendEmail(Request $request)
    {
      $user = User::where('email', $request->email)->first();

      if($user) {
        if ($user->verified == false) {
          if($user->country == 'th') {
            $locale = 'th';
          } else {
            $locale = 'en';
          }
          Mail::to($user->email)->queue((new EmailVerification($user, $locale))->onQueue('high'));

          return redirect()->back()->with('success', __('auth.verification_sent'));
        } else {
          return redirect()->back()->with('error', __('auth.verified'));
        }
      } else {
        return redirect()->back()->with('error', __('auth.failed'));
      }

    }
}
