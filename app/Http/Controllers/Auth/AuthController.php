<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Configuracion as Configuracion;
use Illuminate\Http\Request;
use App\ActivationService as ActivationService;

class AuthController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Registration & Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users, as well as the
      | authentication of existing users. By default, this controller uses
      | a simple trait to add these behaviors. Why don't you explore it?
      |
     */

use AuthenticatesAndRegistersUsers,
    ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $loginPath = '/'; // 
    protected $redirectTo = 'datos';
    protected $activationService;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(ActivationService $activationService) {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->activationService = $activationService;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users',
                    'password' => 'required|min:6|confirmed',
                    'g-recaptcha-response' => 'required',
        ]);
    }
	
	protected function authenticated($request, $user) {
		if($user->isadmin) {
			return redirect('admin/candidatos');
		}
		return redirect('datos');
	}

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) {
        return User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
        ]);
    }

    public function getLogout() {
        $this->auth->logout();
        Session::flush();
        return redirect('/');
    }

    public function getLogin() {
        $configuracion = Configuracion::where('llave', '=', 'limit_date')->first();
        $data = [];
        if (strtotime($configuracion['valor']) > time()) {
            return view('auth/login');
        } else {
            $data = array(
                'limit_date' => $configuracion['valor']
            );
            return view('auth/timeout', $data);
        }
    }

    public function register(Request $request) {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                    $request, $validator
            );
        }
        $user = $this->create($request->all());
        $this->activationService->sendActivationMail($user);
        return redirect('auth/login')->with('status', 'Hemos enviado el enlace de activación a su cuenta de correo. Por favor, verifíque su email.');
    }

    public function activateUser($token) {
        if ($user = $this->activationService->activateUser($token)) {
            auth()->login($user);
            return redirect($this->redirectPath());
        }
        abort(404);
    }

}
