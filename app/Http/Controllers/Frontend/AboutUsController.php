<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Frontend\FrontendBaseController;

use App\SaidTech\Repositories\AboutUsRepository\AboutUsRepository;

use App\SaidTech\Traits\Files\uploadImageTrait as uploadImage;

class AboutUsController extends FrontendBaseController
{
    use uploadImage;

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
/*
        $art = [
            'image' => "edu_2.png"
        ];

        $translations = [
            'fr' => [
                'name' => 'Connaître la plateforme <span class="theme-cl">CABES</span>',
                'desc' => "Cabes Foundation fournit des services professionnels dans le domaine de l'éducation et la formation en se servant des moyens technologiques pour mieux atteindre ses objectifs. Parmi nos services, l'enseignement et la formation à distance qui est un projet ambitieux.",
                'detail' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32. The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.',
            ],
            'ar' => [
                'name' => '<span class="theme-cl">CABES</span>تعرف على منصة',
                'desc' => "تقدم مؤسسة قبس خدمات احترافية في مجال التعليم والتدريب باستخدام الوسائل التكنولوجية لتحقيق أهدافها بشكل أفضل. من خدماتنا التعليم والتدريب عن بعد وهو مشروع طموح.",
                'detail' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32. The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.',
            ],
        ];

        $res = $this->repository->create(array_merge($art, $translations));

        dd($res); */

        return view($this->base_view . 'index', ['data' => array_merge($this->data, $data)]);
    }
}
