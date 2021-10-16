<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Hash;

use Sentinel;
use Reminder;
use Activation;

use jsValidator;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\SaidTech\Repositories\UsersRepository\UserRepository;

use App\SaidTech\Traits\Auth\RegisterTrait;
use App\SaidTech\Traits\Lang\routeTrait;

class LoginController extends Controller
{
    use RegisterTrait, routeTrait;
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
    protected $uris = [];

    protected $repositories = [];

    protected function setRubricConfig($rubric_name) {
        $this->base_view   = 'frontend.rubrics.' . $rubric_name . '.';
        $this->rubric_name = $rubric_name;
        $this->rubric_uri  = trans('routes.login');

        $this->generateTranslatedURL();

        $this->data = [
            'title' => trans('menu.login'),
            'uris' => $this->uris
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

        $this->generateTranslatedURL('not_verified');

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
                        $res = Auth::attempt($credentials, $request->remember);

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

    /**
     * Send reset email page
     */
    public function resetPasswordForm() {

        $validator = JsValidator::make([
            'email' => "required|email"
        ]);

        $this->generateTranslatedURL('reset_pass');

        $data = [
            'validator' => $validator,
            'uris'      => $this->uris
        ];

        return view($this->base_view . '.forgetPass', ['data' => array_merge($this->data, $data)]);
    }

    /**
     * Send Reset Mail
     */
    public function SendResetMail(Request $request) {
        $request->validate(['email' => "required|email"]);

        $user = $this->repository->findWhere(['email' => $request->email])->first();

        if ($user) {
            $user = Sentinel::findById($user->id);

            // Remove expired reminders
            Reminder::removeExpired();

            // Send Reminder
            $rem = Reminder::create($user);

            // Send email
            $res = $this->sendResetPassMail($user, $rem->code);

            if ($res) {

                $response = [
                    'success' => true,
                    'message' => trans('notifications.reset_pass_sent')
                ];

                return redirect()->route('auth.resetPasswordForm')->with($response);
            }

        } else {
            $response = [
                'success' => false,
                'message' => trans('notifications.unexpected_email')
            ];

            return redirect()->route('auth.resetPasswordForm')->with($response);
        }
    }

    /**
     * New password form
     */
    public function newPasswordForm($code, $id) {
        $user = Sentinel::findById($id);

        $rem = Reminder::exists($user);

        if (!$rem->is_completed) {

            if ($rem && ($rem->user_id == $id) && ($rem->code == $code)) {
                $validator = JsValidator::make([
                    'email' => "required|email",
                    'password' => 'required|string|confirmed|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x]).*$/',
                    'code' => "required"
                ]);

                $translatedSlug = [
                    'fr' => trans('routes.by_module', [], 'fr') .'/'. $rem->code .'/'. $user->id,
                    'ar' => trans('routes.by_module', [], 'ar') .'/'. $rem->code .'/'. $user->id
                ];

                $this->generateRouteCustom(null, $translatedSlug);

                $data = [
                    'user' => $user,
                    'code' => $rem->code,
                    'validator' => $validator
                ];

                return view('frontend.rubrics.auth.newPass', ['data' => array_merge($this->data, $data)]);

            } else {
                $response = [
                    'success' => false,
                    'message' => trans('notifications.unexpected_link')
                ];

                return redirect()->route('auth.resetPasswordForm')->with($response);
            }
        } else {
            $response = [
                'success' => false,
                'message' => trans('notifications.expired_link')
            ];

            return redirect()->route('auth.resetPasswordForm')->with($response);
        }
    }

    /**
     * Attempt to complete reset password
     */
    public function resetPassword(Request $request) {

        $request->validate([
            'email' => "required|email",
            'password' => 'required|string|confirmed|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x]).*$/',
            'code' => "required"

        ]);

        $user = $this->repository->findWhere(['email' => $request->email])->first();
        $user = Sentinel::findById($user->id);

        if ($user) {
            // Send Reminder
            $rem = Reminder::exists($user);

            if ($rem) {
                $res = Reminder::complete($user, $request->code, $request->password);

                if ($res) {

                    $response = [
                        'success' => true,
                        'message' => trans('notifications.pass_updated')
                    ];

                    return redirect()->route('auth.loginForm')->with($response);
                } else {
                    throw new \LogicException("Reminder not complete due to error");
                }
            }
        }
    }

    /**
     * Logout
     */
    public function logout() {
        if (!empty(Auth::user())) {
            Auth::logout();

            $response = [
                'success' => true,
                'message' => trans('notifications.logged_out')
            ];

            return redirect()->route('frontend.index')->with($response);
        }
    }

    public function getLoginRules() {
        return [
            'email'           => 'required|email',
            'password'        => 'required',
        ];
    }
}
