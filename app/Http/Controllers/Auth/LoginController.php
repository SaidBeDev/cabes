<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Hash;

use Sentinel;

use jsValidator;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use App\SaidTech\Repositories\UsersRepository\UserRepository;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    // Initializing variables
    public $rubric_uri = null;
    public $rubric_name = null;
    protected $base_view = null;
    protected $title = null;
    public $data = [];

    protected $repositories = [];

    protected function setRubricConfig($rubric_name) {
        $this->base_view   = 'frontend.rubrics.' . $rubric_name . '.';
        $this->rubric_name = $rubric_name;
        $this->rubric_uri  = trans('routes.login');

        $this->data = [
            'title' => trans('menu.login')
        ];
    }

    /**
     * @var UserRepository
     */

    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;

        $this->setRubricConfig('auth');

        $this->middleware('guest')->except('logout');
    }

    public function create() {

        $data = [
            'validator' => jsValidator::make($this->getLoginRules())
        ];

        return view($this->base_view . '.login', ['data' => array_merge($this->data, $data)]);
    }

    public function notVerified() {
        $data = [
            'title' => trans('menu.welcome')
        ];

        return view($this->base_view . '.notVerified', ['data' => array_merge($this->data, $data)]);
    }

    /**
     *
     */
    public function login(Request $request) {

        $request->validate($this->getLoginRules());
        $user = $this->repository->findWhere(['email' => $request->email])->first();

        if (!empty($user)) {
            $act = Activation::exists($user);

            if (Hash::check($request->password, $user->password)) {
                if ($user->profile_type->name != "admin") {
                    if ($act && !$act->completed) {
                        $response = [
                            'success' => false,
                            'message' => trans('notifications.not_verified')
                        ];

                        return redirect()->route('auth.welcome')->with($response);
                    }else if ($user->is_blocked == 1) {
                        $response = [
                            'success' => false,
                            'message' => trans('notifications.blocked_account')
                        ];

                        return redirect()->back()->with($response);

                    }elseif ($user->profile_type->name == "teacher" && $user->teacher->is_checked == 0) {
                        $response = [
                            'type' => "not_verified"
                        ];

                        return redirect()->route('auth.notVerified')->with($response);
                    }

                    $credentials = [
                        'email' => $request->email,
                        'password' => $request->password
                    ];

                    if (Hash::check($request->password, $user->password)) {
                        $res = Auth::attempt($credentials);

                        session()->regenerate();

                    }else{
                        $response = [
                            'success' => false,
                            'message' => trans('notifications.unmatched_credentials')
                        ];

                        return redirect()->back()->with($response);
                    }

                    if ($res != false) {

                        $response = [
                            'success' => true,
                            'message' => trans('notifications.login_success')
                        ];

                        return redirect()->route('frontend.profile.edit', ['id' => $user->id])->with($response);
                    }
                }else { // if is admin
                    $response = [
                        'success' => false,
                        'message' => trans('notifications.unmatched_credentials')
                    ];

                    return redirect()->back()->with($response);
                }
            }else{

                $response = [
                    'success' => false,
                    'message' => trans('notifications.unmatched_credentials')
                ];

                return redirect()->back()->with($response);
            }
        }else {
            $response = [
                'success' => false,
                'message' => trans('notifications.unmatched_credentials')
            ];

            return redirect()->back()->with($response);
        }
    }

    public function logout() {
        Sentinel::logout();

        return redirect()->route('auth.loginForm');
    }

    public function getLoginRules() {
        return [
            'email'           => 'required|email',
            'password'        => 'required',
        ];
    }
}
