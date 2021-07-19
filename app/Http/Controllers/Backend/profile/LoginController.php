<?php

namespace App\Http\Controllers\Backend\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Spatie\OpeningHours\OpeningHours;

use App\SaidTech\Repositories\UsersRepository\UserRepository;
use App\SaidTech\Repositories\ProfileTypesRepository\ProfileTypeRepository;

use Auth;
use Sentinel;
use Activation;

class LoginController extends BackendBaseController
{
    /**
     * @var UserRepository
     */

    protected $repository;

    public function __construct(
        UserRepository $repository,
        ProfileTypeRepository $profileTypesRepository
    )
    {
        $this->repository = $repository;
        $this->repositories['ProfileTypesRepository'] = $profileTypesRepository;

        $this->setRubricConfig('login');
    }


    public function create() {
        $data = [
            'title' => "Login"
        ];

        return view('backend.rubrics.auth.login', ['data' => array_merge($this->data, $data)]);
    }

    public function login(Request $request) {
        $request->validate($this->getLoginRules());
        $user = $this->repository->findWhere(['email' => $request->email])->first();

        if (!empty($user)) {
            if ($user->profile_type->name == "admin") {
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

                    return redirect()->route('backend.teachers.index')->with($response);
                }
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

        return redirect()->route('backend.loginForm');
    }

    public function getLoginRules() {
        return [
            'email' => 'required|email',
            'password' => 'required'
        ];
    }
}
