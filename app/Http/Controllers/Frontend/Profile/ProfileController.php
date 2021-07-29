<?php

namespace App\Http\Controllers\Frontend\Profile;

use Auth;
use App\Module;
use App\Sector;
use App\Session;
use App\Shedule;
use App\TeacherProfile;
use App\ModuleTranslation;

use App\SessionTranslation;
use Illuminate\Support\Arr;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Validator;

use App\SaidTech\Traits\Auth\RegisterTrait;
use App\SaidTech\Traits\Files\UploadImageTrait as UploadImage;
use App\SaidTech\Traits\Data\avatarsTrait;

use \Cviebrock\EloquentSluggable\Services\SlugService;
use App\Http\Controllers\Frontend\FrontendBaseController;
use App\SaidTech\Repositories\UsersRepository\UserRepository;

use App\SaidTech\Repositories\DairasRepository\DairaRepository;
use App\SaidTech\Repositories\ConfigsRepository\ConfigRepository;
use App\SaidTech\Repositories\ModulesRepository\ModuleRepository;
use App\SaidTech\Repositories\PeriodsRepository\PeriodRepository;
use App\SaidTech\Repositories\WilayasRepository\WilayaRepository;
use App\SaidTech\Traits\Data\businessHoursTrait as businessHours;
use App\SaidTech\Repositories\StudentsRepository\StudentRepository;
use App\SaidTech\Repositories\TeachersRepository\TeacherRepository;
use App\SaidTech\Repositories\StudyYearsRepository\StudyYearRepository;
use App\SaidTech\Repositories\ContactTypesRepository\ContactTypeRepository;
use App\SaidTech\Repositories\ProfileTypesRepository\ProfileTypeRepository;

class ProfileController extends FrontendBaseController
{
    use UploadImage, RegisterTrait, avatarsTrait;

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
        ModuleRepository $moduleRepository,
        StudyYearRepository $studyYearsRepository,
        WilayaRepository $wilayaRepository,
        DairaRepository $dairaRepository,
        ContactTypeRepository $contactTypesRepository,
        PeriodRepository $periodsRepository
    )
    {
        $this->repository = $repository;
        $this->repositories['ProfileTypesRepository'] = $profileTypesRepository;
        $this->repositories['StudentRepository'] = $studentRepository;
        $this->repositories['TeacherRepository'] = $teacherRepository;
        $this->repositories['ConfigsRepository'] = $configRepository;
        $this->repositories['ModulesRepository'] = $moduleRepository;
        $this->repositories['StudyYearsRepository'] = $studyYearsRepository;
        $this->repositories['WilayasRepository'] = $wilayaRepository;
        $this->repositories['DairasRepository'] = $dairaRepository;
        $this->repositories['ContactTypesRepository'] = $contactTypesRepository;
        $this->repositories['PeriodsRepository'] = $periodsRepository;

        $this->setRubricConfig('profile');
    }

    public function show($id) {
        if (Auth::user()->id != $id) {
            throw new \LogicException('Action pas autorisée');
        }

        $user = $this->repository->find($id);

        $data = [
            'uri' => "view_profile",
            'user' => $user,
            'list_periods' => $this->repositories['PeriodsRepository']->all()
        ];

        return view($this->base_view . 'show', ['data' => array_merge($this->data, $data)]);
    }

    public function edit($id)
    {

        if (Auth::user()->id != $id) {
            throw new \LogicException('Action pas autorisée');
        }

        $user = $this->repository->find($id);


        $data = [
            'uri' => "edit_profile",
            'user' => $user,
            'profile_types' => $this->repositories['ProfileTypesRepository']->all(),

            'list_modules' => $this->repositories['ModulesRepository']->all()->filter(function($module) {
                return !in_array($module->translate('fr')->slug, ['formations-universitaires', 'formations-professionnelles']);
            }),
            'spec_modules' => $this->repositories['ModulesRepository']->all()->filter(function($module) {
                return in_array($module->translate('fr')->slug, ['formations-universitaires', 'formations-professionnelles']);
            }),
            'spec_years' => $this->repositories['StudyYearsRepository']->all()->filter(function($module) {
                return in_array($module->translate('fr')->slug, ['formations-professionnelles']);
            }),
            'study_years' => $this->repositories['StudyYearsRepository']->all()->filter(function($module) {
                return !in_array($module->translate('fr')->slug, ['formations-professionnelles']);
            }),

            'list_sectors' => Sector::all(),
            'list_wilayas' => $this->repositories['WilayasRepository']->all(),
            'list_dairas' => $this->repositories['DairasRepository']->all(),
            'list_avatars' => $this->getAvatars()
        ];

        return view($this->base_view . 'edit', ['data' => array_merge($this->data, $data)]);
    }

    /**
     * Update a user instance after validation.
     *
     * @param  Request  $request
     */
    protected function update(Request $request, $id, $profileId)
    {
        if (Auth::user()->id != $id) {
            throw new \LogicException('Action pas autorisée');
        }

        $oldUser = $this->repository->find($id);

        $newUser = $request->validate($this->getUsersRules());

        if ($oldUser->email != $request->email) {
            $request->validate(['email' => "required|unique:users"]);

            $newUser['email'] = $request->email;
        }

        if (!empty($oldUser->contacts)) {
            foreach ($oldUser->contacts as $contact) {
                switch ($contact->contact_type->name) {
                    case 'facebook':
                        $facebook = $contact;
                        break;
                    case 'linkedin':
                        $linkedin = $contact;
                        break;
                    case 'viber':
                        $viber = $contact;
                        break;
                    case 'whatsapp':
                        $whatsapp = $contact;
                        break;
                }
            }
        }

        if ($this->isSetContact($request)) {
            if (in_array("facebook", $this->getContacts($request))) {
                $type = $this->repositories['ContactTypesRepository']->findWhere(['name' => "facebook"])->first();

                if (isset($facebook)) {
                    if ($facebook->content != $request->facebook) {
                        $facebook->content = $request->facebook;
                        $facebook->save();
                    }
                }
                else {
                    $contact = new \App\Contact;
                    $contact->content = $request->facebook;
                    $contact->contact_type_id = $type->id;

                    $contact->save();

                    $oldUser->contacts()->save($contact);
                }
            }

            if (in_array("linkedin", $this->getContacts($request))) {
                $type = $this->repositories['ContactTypesRepository']->findWhere(['name' => "linkedin"])->first();

                if (isset($linkedin)) {
                    if ($linkedin->content != $request->linkedin) {
                        $linkedin->content = $request->linkedin;
                        $linkedin->save();
                    }
                }
                else {
                    $contact = new \App\Contact;
                    $contact->content = $request->linkedin;
                    $contact->contact_type_id = $type->id;

                    $contact->save();

                    $oldUser->contacts()->save($contact);
                }
            }

            if (in_array("whatsapp", $this->getContacts($request))) {
                $type = $this->repositories['ContactTypesRepository']->findWhere(['name' => "whatsapp"])->first();

                if (isset($whatsapp)) {
                    if ($whatsapp->content != $request->whatsapp) {
                        $whatsapp->content = $request->whatsapp;
                        $whatsapp->save();
                    }
                }
                else {
                    $contact = new \App\Contact;
                    $contact->content = $request->whatsapp;
                    $contact->contact_type_id = $type->id;

                    $contact->save();

                    $oldUser->contacts()->save($contact);
                }
            }

            if (in_array("viber", $this->getContacts($request))) {
                $type = $this->repositories['ContactTypesRepository']->findWhere(['name' => "viber"])->first();

                if (isset($viber)) {
                    if ($viber->content != $request->viber) {
                        $viber->content = $request->viber;
                        $viber->save();
                    }
                }
                else {
                    $contact = new \App\Contact;
                    $contact->content = $request->viber;
                    $contact->contact_type_id = $type->id;

                    $contact->save();

                    $oldUser->contacts()->save($contact);
                }
            }
        }

        if (Input::get('is_new_password', false)) {
            if (!empty($request->old_password) && !empty($request->new_password)) {

                if (Hash::check($request->old_password, $oldUser->password)) {
                    $newPassword = Hash::make($request->new_password);
                    $newUser['password'] = $newPassword;

                }
                elseif (Hash::check($request->old_password, $oldUser->password) && Hash::check($request->new_password, $oldUser->password)){

                    $newUser['password'] = $oldUser->password;

                    $response = [
                        'success' => false,
                        'message' => trans('notifications.must_new_password')
                    ];

                    return redirect()->back()->with($response);
                }
                else {

                    $newUser['password'] = $oldUser->password;

                    $response = [
                        'success' => false,
                        'message' => trans('notifications.unmatched_passwords')
                    ];

                    return redirect()->back()->with($response);
                }
            } else {
                $response = [
                    'success' => false,
                    'message' => trans('validation.required', ['attribute' => trans('frontend.password')])
                ];

                return redirect()->back()->with($response);
            }
        }else{
            $newUser['password'] = $oldUser->password;
        }

        $this->repository->update($newUser, $id);

        // Get the type of the profile
        $profile_type = $this->repositories['ProfileTypesRepository']->find($request->profile_type_id);

        switch ($profile_type->name) {

            case 'student':
                $student = $this->repositories['StudentRepository']->find($profileId);

                $credentials = $request->validate($this->getStudentRules());

                $student->study_year_id = $request->study_year_id;

                $student->save();

                break;

            case 'teacher':
                $teacher = $this->repositories['TeacherRepository']->find($profileId);

                $credentials = $request->validate($this->getTeacherRules());

                $teacher->desc = $request->desc;
                $teacher->diploma = $request->diploma;
                $teacher->experience = $request->experience;
                $teacher->video_link = $request->video_link;
                $teacher->portfolio = $request->portfolio;

                $teacher->save();

                // Modules
                if (!empty($teacher->modules)) {
                    for ($i = 0; $i < count($teacher->modules); $i++) {
                        $teacher->modules()->detach();
                     }
                 }

                 for ($i = 0; $i < count($request->module_id); $i++) {
                    $teacher->modules()->attach($request->module_id[$i]);
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

                break;
        }


        $response = [
            'success' => true,
            'message' => trans('notifications.profile_updated')
        ];

        return redirect()->back()->with($response);
    }


    /**
     * @return JsonResponse
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

    public function isSetContact($request) {

        if (!empty($request->facebook) || !empty($request->linkedin) || !empty($request->whatsapp) || !empty($request->viber))
            return true;

        return false;
    }

    public function getContacts($request) {

        $contacts = [];

        if ($this->isSetContact($request)) {
            if (!empty($request->facebook)) {
                array_push($contacts, 'facebook');
            }

            if (!empty($request->linkedin)) {
                array_push($contacts, 'linkedin');
            }

            if (!empty($request->whatsapp)) {
                array_push($contacts, 'whatsapp');
            }

            if (!empty($request->viber)) {
                array_push($contacts, 'viber');
            }

            return $contacts;
        }

        return false;
    }

    public function getUsersRules() {
        return [
            'avatar'          => 'required',
            'full_name'       => 'required',
            'new_password'    => 'string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x]).*$/',
            'tel'             => 'required',
            'address'         => 'required',
            'profile_type_id' => 'required',
            'commune_id'      => "required"

        ];
    }

    public function getStudentRules() {
        return [
            'study_year_id' => 'nullable'
        ];
    }

    public function getTeacherRules() {
        return [
            'desc' => 'nullable',
            'diploma' => "nullable",
            'experience' => "nullable",
            'video_link' => "nullable",
            'portfolio' => "nullable"
        ];
    }

}
