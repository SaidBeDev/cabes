<?php

namespace App\Http\Controllers\Backend\About;

use App\Http\Controllers\Backend\BackendBaseController;

use App\SaidTech\Repositories\AboutUsRepository\AboutUsRepository;

use App\SaidTech\Traits\Files\UploadImageTrait as uploadImage;
use Illuminate\Http\Request;
use JsValidator;

class AboutUsController extends BackendBaseController
{
    use uploadImage, uploadImage;

     /**
     * @var AboutUsRepository
     */

    protected $repository;

    public function __construct(
        AboutUsRepository $repository
    )
    {
        $this->repository = $repository;

        $this->setRubricConfig('about');
    }


    public function index() {

        $data = [
            'article' => $this->repository->first()
        ];

        return view($this->base_view . 'index', ['data' => array_merge($this->data, $data)]);
    }


    public function edit() {

        $data =  [
            'article' => $this->repository->first(),
            'validator' => JsValidator::make($this->getAboutRules())
        ];

        return view($this->base_view . 'edit', ['data' => array_merge($this->data, $data)]);
    }


    public function update(Request $request) {

        $article = $this->repository->first();

        $art = $request->validate($this->getAboutRules());
        $art = $request->except(['name_fr', 'name_ar', 'desc_fr', 'desc_ar', 'detail_fr', 'detail_ar']);

        if (!empty($request->image)) {

            $art['image'] = "edu_2.png";

            $image = $this->uploadImageAndMove(request()->image, $article->image, 'about', 'abouts', 'image');

            $art['image'] = $image;
        }

        $translations = [
            'fr' => [
                'name' => $request->name_fr,
                'desc' => $request->desc_fr,
                'detail' => $request->detail_fr
            ],
            'ar' => [
                'name' => $request->name_ar,
                'desc' => $request->desc_ar,
                'detail' => $request->detail_ar
            ],
        ];

        $this->repository->update(array_merge($art, $translations), $article->id);

        $response = [
            'success' => true,
            'message' => trans('notifications.about_updated')
        ];

        return redirect()->back()->with($response);
    }

    public function getAboutRules() {
        return [
            'name_fr' => "required",
            'desc_fr' => "required",
            'detail_fr' => "required",
            'name_ar' => "required",
            'desc_ar' => "required",
            'detail_ar' => "required",
        ];
    }

}
