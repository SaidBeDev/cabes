<div class="lang-container" style=" float: {{ app()->getLocale() == 'ar' ? 'left' : 'right' }}" data-toggle="tooltip" data-placement="{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}" title="{{ trans('frontend.choose_lang') }}">
    <select class="selectpicker lang-select" onchange="window.location = this.value;">
        <option data-content='ع' {{ app()->getLocale() == 'ar' ? 'selected' : '' }} value="{{ $data['uris']['ar'] }}"></option>
        <option  data-content='FR ' {{ app()->getLocale() == 'fr' ? 'selected' : '' }} value="{{ LaravelLocalization::getLocalizedURL('fr', $data['uris']['fr'], [], true) }}"></option>
    </select>
</div>
