<?php

namespace App\SaidTech\Traits\Lang;

use LaravelLocalization;

trait routeTrait
{
    /**
     * Generate a translated routes
     * @param $uri
     * @return void
     */
    public function generateTranslatedURL($uri = null) {
        $uri = !empty($uri) ? $uri : $this->rubric_name;

        foreach (LaravelLocalization::getSupportedLocales() as $code => $prop) {
            $this->uris[$code] = LaravelLocalization::getURLFromRouteNameTranslated($code, 'routes.' . $uri, [], true);
        }
    }

    public function generateArticleRoutesWithSlug($uri = null, $article = null) {

        $uri = !empty($uri) ? $uri : $this->rubric_name;

        if (is_null($uri) || is_null($article)) {
            abort(404);
        }

        foreach (LaravelLocalization::getSupportedLocales() as $code => $rop) {

            $this->data['uris'][$code] = LaravelLocalization::getURLFromRouteNameTranslated($code, 'routes.' . $uri, [], true) .'/'. $article->translate($code)->slug;
        }
    }

    public function generateRouteWithSlug($uri = null, $slug = null) {

        $uri = !empty($uri) ? $uri : $this->rubric_name;

        if (is_null($uri) || is_null($slug)) {
            abort(404);
        }

        foreach (LaravelLocalization::getSupportedLocales() as $code => $rop) {

            $this->data['uris'][$code] = LaravelLocalization::getURLFromRouteNameTranslated($code, 'routes.' . $uri, [], true) .'/'. $slug;
        }
    }

    public function generateRouteCustom($uri = null, $data = null) {
        $uri = !empty($uri) ? $uri : $this->rubric_name;

        if (is_null($uri) || is_null($data)) {
            abort(404);
        }

        foreach (LaravelLocalization::getSupportedLocales() as $code => $rop) {

            $this->data['uris'][$code] = LaravelLocalization::getURLFromRouteNameTranslated($code, 'routes.' . $uri, [], true) .'/'. $data[$code];
        }

    }
}
