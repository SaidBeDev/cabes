<div style="width: 130px; display: inline-block; margin: 15px 0; float: {{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">
    <select class="selectpicker" onchange="window.location = this.value;">
        <option data-content='<span class="flag-icon flag-icon-dz"></span> العربية' {{ app()->getLocale() == 'ar' ? 'selected' : '' }} value="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}"></option>
        <option  data-content='Français <span class="flag-icon flag-icon-fr"></span> ' {{ app()->getLocale() == 'fr' ? 'selected' : '' }} value="{{ LaravelLocalization::getLocalizedURL('fr', null, [], true) }}"></option>
    </select>

    {{-- <select id="countrySelect" name="ipicked__bahasa" class="" data-show-content="true" onChange="go__bahasa()">
    <option value="http://www.yahoo.com"  data-content='<span class="flag-icon flag-icon-gb"></span> ENG'>ENG</option>
    <option value="http://www.google.com"  data-content='<span class="flag-icon flag-icon-id"></span> IND'>IND</option>
    </select> --}}
</div>
