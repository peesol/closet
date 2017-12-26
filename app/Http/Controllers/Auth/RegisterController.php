<?php

namespace Closet\Http\Controllers\Auth;

use Closet\Models\User;
use Closet\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Closet\Jobs\SendVerificationEmail;
use Mail;
use App;
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
            'shop_name' => 'required|max:50|unique:shops,name',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'address' => 'required',
            'country' => 'required',
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
            'country' => 'ไทย',
        ]);

        $user->shop()->create([
          'name' => $data['shop_name'],
          'slug' => uniqid('s_').$user->id,
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
            $locale = App::getLocale();
            event(new Registered($user = $this->create($request->all())));
            Mail::to($user->email)->queue(new EmailVerification($user));

            return view('email.verification');
        }
    /**
    * Handle a registration request for the application.
    *
    * @param $token
    * @return \Illuminate\Http\Response
    */
    public function verify($token)
        {
            $user = User::where('email_token',$token)->first();
            $user->verified = 1;

            if($user->save()){
                return view('email.success',['user'=>$user]);
            }
        }
}
