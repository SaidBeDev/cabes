<?php

namespace App\Http\Controllers\Auth;

use Sentinel;
use App\Sector;
use jsValidator;
use Illuminate\View\View;
use Illuminate\Support\Arr;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use Spatie\OpeningHours\OpeningHours;
use Illuminate\Support\Facades\Validator;
use App\SaidTech\Traits\Data\avatarsTrait;
use App\SaidTech\Traits\Auth\RegisterTrait;
use App\SaidTech\Repositories\UsersRepository\UserRepository;
use App\SaidTech\Traits\Files\UploadImageTrait as UploadImage;
use App\SaidTech\Repositories\DairasRepository\DairaRepository;
use App\SaidTech\Repositories\ConfigsRepository\ConfigRepository;
use App\SaidTech\Repositories\ModulesRepository\ModuleRepository;
use App\SaidTech\Repositories\WilayasRepository\WilayaRepository;

use App\SaidTech\Repositories\StudentsRepository\StudentRepository;
use App\SaidTech\Repositories\TeachersRepository\TeacherRepository;
use App\SaidTech\Repositories\StudyYearsRepository\StudyYearRepository;
use App\SaidTech\Repositories\ContactTypesRepository\ContactTypeRepository;
use App\SaidTech\Repositories\ProfileTypesRepository\ProfileTypeRepository;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Exception;

class RegisterController extends Controller
{
    use UploadImage;
    use RegisterTrait;
    use avatarsTrait;

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
        $this->rubric_uri  = trans('routes.register');

        $this->data = [
            'title' => trans('menu.register')
        ];
    }

    /**
     * @var UserRepository
     */

    protected $repository;

    public function __construct(
        UserRepository $repository,
        StudentRepository $studentRepository,
        TeacherRepository $teacherRepository,
        ProfileTypeRepository $profileTypesRepository,
        ConfigRepository $configRepository,
        WilayaRepository $wilayaRepository,
        DairaRepository $dairaRepository,
        ModuleRepository $moduleRepository,
        StudyYearRepository $studyYearsRepository,
        ContactTypeRepository $contactTypesRepository
    )
    {
        $this->repository = $repository;
        $this->repositories['ProfileTypesRepository'] = $profileTypesRepository;
        $this->repositories['StudentRepository'] = $studentRepository;
        $this->repositories['TeacherRepository'] = $teacherRepository;
        $this->repositories['ConfigsRepository'] = $configRepository;
        $this->repositories['DairasRepository'] = $dairaRepository;
        $this->repositories['WilayasRepository'] = $wilayaRepository;
        $this->repositories['ModulesRepository'] = $moduleRepository;
        $this->repositories['StudyYearsRepository'] = $studyYearsRepository;
        $this->repositories['ContactTypesRepository'] = $contactTypesRepository;


        $this->setRubricConfig('auth');
    }

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

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/profile';

    /**
     * Create a new user instance page data.
     *
     * @return View
     */
    protected function create()
    {

        $data = [
            'profile_types' => $this->repositories['ProfileTypesRepository']->findWhereNotIn('name',["admin"]),
            'list_modules' => $this->repositories['ModulesRepository']->all(),
            'list_sectors' => Sector::all(),
            'study_years' => $this->repositories['StudyYearsRepository']->all(),
            'list_dairas' => $this->repositories['DairasRepository']->all(),
            'list_avatars' => $this->getAvatars(),
            'validator' => jsValidator::make(array_merge($this->getUsersRules(), $this->getTeacherRules(), $this->getStudentRules()))
        ];

        return view($this->base_view . '.register', ['data' => array_merge($this->data, $data)]);
    }

    /**
     * Store a new user instance after a valid registration.
     *
     * @param  Request  $request
     */
    protected function store(Request $request)
    {

        $hour_price   = (int)$this->repositories['ConfigsRepository']->findWhere(['name' => "hourly_price"])->first()->content;
        $group_price  = (int)$this->repositories['ConfigsRepository']->findWhere(['name' => "group_price"])->first()->content;

        // Get the type of the new user
        $profile_type = $this->repositories['ProfileTypesRepository']->find($request->profile_type_id);

        $user = $request->validate($this->getUsersRules());

        if ($profile_type->name == 'student'){
            $request->validate($this->getStudentRules());
        }
        else if ($profile_type->name == 'teacher'){
            $request->validate($this->getTeacherRules());
        }

        //Hash the password
        /* $user['password'] = Hash::make($request->password); */

        $image = null;

        if (isset($request->image)) {
            $image = $this->uploadImage(request()->image, 'profile', 'users', 'picture');
        }

        $user['picture'] = $image;

        $newUser = Sentinel::register(Arr::except($user, ['study_year_id', 'desc', 'hour_price', 'group_price', 'avalibility_hours', 'is_checked', 'module_id']));

        // Send Activation link
        if ($newUser) {
            $act = Activation::create($newUser);

            $res = $this->sendConfirmMail($newUser, $act->code);
        }

        if ($this->isSetContact($request)) {
            if (in_array("facebook", $this->getContacts($request))) {
                $facebook = $this->repositories['ContactTypesRepository']->findWhere(['name' => "facebook"])->first();

                $contact = new \App\Contact;
                $contact->content = $request->facebook;
                $contact->contact_type_id = $facebook->id;

                $contact->save();

                $newUser->contacts()->save($contact);

            }

            if (in_array("linkedin", $this->getContacts($request))) {
                $linkedin = $this->repositories['ContactTypesRepository']->findWhere(['name' => "linkedin"])->first();

                $contact = new \App\Contact;
                $contact->content = $request->linkedin;
                $contact->contact_type_id = $linkedin->id;

                $contact->save();

                $newUser->contacts()->save($contact);
            }

            if (in_array("whatsapp", $this->getContacts($request))) {
                $whatsapp = $this->repositories['ContactTypesRepository']->findWhere(['name' => "whatsapp"])->first();

                $contact = new \App\Contact;
                $contact->content = $request->whatsapp;
                $contact->contact_type_id = $whatsapp->id;

                $contact->save();

                $newUser->contacts()->save($contact);
            }

            if (in_array("viber", $this->getContacts($request))) {
                $viber = $this->repositories['ContactTypesRepository']->findWhere(['name' => "viber"])->first();

                $contact = new \App\Contact;
                $contact->content = $request->viber;
                $contact->contact_type_id = $viber->id;

                $contact->save();

                $newUser->contacts()->save($contact);
            }
        }

        switch($profile_type->name) {

            case 'student':

                $credentials = $request->validate($this->getStudentRules());

                $student = new \App\StudentProfile;

                $student->study_year_id = $request->study_year_id;
                $student->user_id = $newUser->id;

                $student->save();

                $newUser->student()->save($student);

                $response = [
                    'success' => true,
                    'message' => trans('notifications.register_success'),
                    'isTeacher' => false
                ];

                return redirect()->route('auth.welcome')->with($response);

                break;

            case 'teacher':

                $credentials = $request->validate($this->getTeacherRules());

                $teacher = new \App\TeacherProfile;
                $teacher->desc = !empty($request->desc) ? $request->desc : null;
                $teacher->hour_price = $hour_price;
                $teacher->group_price = $group_price;
                $teacher->availability_hours = null;
                $teacher->is_checked = false;
                $teacher->module_id = 1;
                $teacher->user_id = $newUser->id;

                $teacher->save();

                $newUser->teacher()->save($teacher);

                if (!empty($teacher->modules)) {
                    for ($i = 0; $i < count($teacher->modules); $i++) {
                         $teacher->modules()->detach($teacher->modules[$i]);
                     }
                 }

                 if (!empty($request->module_id)) {
                     for ($i = 0; $i < count($request->module_id); $i++) {
                        $teacher->modules()->attach($request->module_id[$i]);
                    }
                 }

                 // Sectors
                if (!empty($teacher->sectors)) {
                    for ($i = 0; $i < count($teacher->sectors); $i++) {
                        $teacher->sectors()->detach();
                    }
                 }

                 for ($i = 0; $i < count($request->sector); $i++) {
                     $teacher->sectors()->attach($request->sector[$i]);
                 }

                // Teaching Years
                if (!empty($teacher->teaching_years)) {
                    for ($i = 0; $i < count($teacher->teaching_years); $i++) {
                         $teacher->teaching_years()->detach();
                     }
                 }

                 for ($i = 0; $i < count($request->teaching_years); $i++) {
                     $teacher->teaching_years()->attach($request->teaching_years[$i]);
                 }


                 $response = [
                    'success' => true,
                    'message' => trans('notifications.register_success'),
                    'isTeacher' => true
                ];

                return redirect()->route('auth.welcome')->with($response);
                break;
        }
    }

    public function welcome($isTeacher = false) {
        $data = [
            'title' => trans('menu.welcome'),
            'isTeacher' => $isTeacher
        ];

        return view($this->base_view . 'welcome', ['data' => array_merge($this->data, $data)]);
    }

    public function isSetContact($request) {

        if (!empty($request->facebook) || !empty($request->linkedin) || !empty($request->whatsapp) || !empty($request->viber))
            return true;

        return false;
    }

    public function getContacts($request) {

        $contacts = [];

        if ($this->isSetContact($request)) {
            if (!empty($request->facebook)) {
                array_merge($contacts, ['facebook']);
            }

            if (!empty($request->linkedin)) {
                array_merge($contacts, ['linkedin']);
            }

            if (!empty($request->whatsapp)) {
                array_merge($contacts, ['whatsapp']);
            }

            if (!empty($request->viber)) {
                array_merge($contacts, ['viber']);
            }

            return $contacts;
        }

        return false;
    }

    public function verify($code, $id) {
        $user = Sentinel::findById($id);

        if (Activation::exists($user)) {
            $act = Activation::exists($user);

            if (Activation::completed($user)) {
                $response = [
                    'success' => true,
                    'message' => "Ce compe est deja vérifiée!"
                ];

                return redirect()->route('frontend.index')->with($response);
            } else {
                // Attemp to complete activation
               if ($code == $act->code) {
                   $res = Activation::complete($user, $code);

                   if ($res) {
                       $response = [
                           'success' => true,
                           'message' => trans('notifications.account_verified')
                       ];
                   }
                   else {
                        $response = [
                            'success' => false,
                            'message' => "An error was occured!"
                        ];
                   }
                   return redirect()->route('frontend.index')->with($response);
               }

                $response = [
                    'success' => false,
                    'message' => "a missing paramater error"
                ];

                return redirect()->route('frontend.index')->with($response);
            }
        } else {

            throw new \LogicException('Activation not exist');
        }
    }

    public function getUsersRules() {
        return [
            'avatar'          => 'required',
            'full_name'       => 'required',
            'email'           => 'required|email|unique:users',
            'password'        => 'required|string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x]).*$/',
            'birthday'        => "required|date",
            'tel'             => 'required',
            'address'         => 'required',
            'profile_type_id' => 'required',
            'commune_id'      => "required"

        ];
    }

    public function getStudentRules() {
        return [
            'study_year_id' => 'required'
        ];
    }

    public function getTeacherRules() {
        return [
            'desc'       => 'nullable',
            'diploma'    => "nullable",
            'experience' => "nullable",
            'video_link' => "nullable",
            'portfolio'  => "nullable"
        ];
    }
}
