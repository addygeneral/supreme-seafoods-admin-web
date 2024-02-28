@extends('admin.theme.default')
@section('content')
@include('admin.breadcrumb')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="form-validation">
                <form action="{{ URL::to('admin/settings/update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-3 mb-2">
                        <h5><i class="fa-solid fa-address-card"></i> {{ trans('labels.contact_settings') }} </h5>
                    </div>
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.email') }} <span class="text-danger">*</span></label> </label>
                                        <input type="text" class="form-control" name="email" value="{{ @$getsettings->email == '' ? old('email') : @$getsettings->email }}" placeholder="{{ trans('labels.email') }}" required>
                                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.mobile') }} <span class="text-danger">*</span></label> </label>
                                        <input type="text" class="form-control" name="mobile" value="{{ @$getsettings->mobile == '' ? old('mobile') : @$getsettings->mobile }}" placeholder="{{ trans('labels.mobile') }}" id="mobile" required>
                                        @error('mobile') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.address') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="address" id="address" value="{{ @$getsettings->address == '' ? old('address') : @$getsettings->address }}" required>
                                        @error('address') <span class="text-danger">{{ $message }}</span><br> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.latitude') }} <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="{{ trans('labels.latitude') }}" value="{{ @$getsettings->lat == '' ? old('lat') : @$getsettings->lat }}" class="form-control" name="lat" id="lat" readonly required>
                                        @error('lat') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.longitude') }} <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="{{ trans('labels.longitude') }}" value="{{ @$getsettings->lang == '' ? old('lang') : @$getsettings->lang }}" class="form-control" name="lang" id="lang" readonly required>
                                        @error('lang') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="mymap" class="settings-map"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.facebook_link') }}</label>
                                        <input type="text" class="form-control" name="fb" id="fb" value="{{ @$getsettings->fb == '' ? old('fb') : @$getsettings->fb }}" placeholder="{{ trans('labels.facebook_link') }}">
                                        @error('fb') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.youtube_link') }}</label>
                                        <input type="text" class="form-control" name="youtube" id="youtube" value="{{ @$getsettings->youtube == '' ? old('youtube') : @$getsettings->youtube }}" placeholder="{{ trans('labels.youtube_link') }}">
                                        @error('youtube') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.instagram_link') }}</label>
                                        <input type="text" class="form-control" name="insta" id="insta" value="{{ @$getsettings->insta == '' ? old('insta') : @$getsettings->insta }}" placeholder="{{ trans('labels.instagram_link') }}">
                                        @error('insta') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group text-end">
                                    <a href="{{ url('/admin/home') }}" class="btn btn-outline-danger">{{ trans('labels.cancel') }}</a>
                                    <button class="btn btn-primary" @if (env('Environment')=='sendbox' ) type="button" onclick="myFunction()" @else type="submit" name="contact_update" value="1" @endif>{{ trans('labels.save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form action="{{ URL::to('admin/settings/update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-3 mb-2">
                        <h5><i class="fa-regular fa-earth-americas"></i> {{ trans('labels.third_party_settings') }} </h5>
                    </div>
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.map_key') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="map" id="map" value="{{ @$getsettings->map == '' ? old('map') : @$getsettings->map }}" placeholder="{{ trans('labels.map_key') }}" required>
                                        @error('map') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.firebase_key') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="firebase" id="firebase" value="{{ @$getsettings->firebase == '' ? old('firebase') : @$getsettings->firebase }}" placeholder="{{ trans('labels.firebase_key') }}" required>
                                        @error('firebase') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.timezone') }}</label>
                                        <select class="form-control selectpicker" name="timezone" id="timezone" data-live-search="true">
                                            <option value="" selected> {{ trans('labels.select') }} </option>
                                            <option value="Pacific/Midway" {{ @$getsettings->timezone == 'Pacific/Midway' ? 'selected' : '' }}> (GMT-11:00) Midway Island, Samoa</option>
                                            <option value="America/Adak" {{ @$getsettings->timezone == 'America/Adak' ? 'selected' : '' }}> (GMT-10:00) Hawaii-Aleutian</option>
                                            <option value="Etc/GMT+10" {{ @$getsettings->timezone == 'Etc/GMT+10' ? 'selected' : '' }}> (GMT-10:00) Hawaii</option>
                                            <option value="Pacific/Marquesas" {{ @$getsettings->timezone == 'Pacific/Marquesas' ? 'selected' : '' }}> (GMT-09:30) Marquesas Islands</option>
                                            <option value="Pacific/Gambier" {{ @$getsettings->timezone == 'Pacific/Gambier' ? 'selected' : '' }}> (GMT-09:00) Gambier Islands</option>
                                            <option value="America/Anchorage" {{ @$getsettings->timezone == 'America/Anchorage' ? 'selected' : '' }}> (GMT-09:00) Alaska</option>
                                            <option value="America/Ensenada" {{ @$getsettings->timezone == 'America/Ensenada' ? 'selected' : '' }}> (GMT-08:00) Tijuana, Baja California</option>
                                            <option value="Etc/GMT+8" {{ @$getsettings->timezone == 'Etc/GMT+8' ? 'selected' : '' }}> (GMT-08:00) Pitcairn Islands</option>
                                            <option value="America/Los_Angeles" {{ @$getsettings->timezone == 'America/Los_Angeles' ? 'selected' : '' }}> (GMT-08:00) Pacific Time (US & Canada)</option>
                                            <option value="America/Denver" {{ @$getsettings->timezone == 'America/Denver' ? 'selected' : '' }}> (GMT-07:00) Mountain Time (US & Canada)</option>
                                            <option value="America/Chihuahua" {{ @$getsettings->timezone == 'America/Chihuahua' ? 'selected' : '' }}> (GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                                            <option value="America/Dawson_Creek" {{ @$getsettings->timezone == 'America/Dawson_Creek' ? 'selected' : '' }}> (GMT-07:00) Arizona</option>
                                            <option value="America/Belize" {{ @$getsettings->timezone == 'America/Belize' ? 'selected' : '' }}> (GMT-06:00) Saskatchewan, Central America</option>
                                            <option value="America/Cancun" {{ @$getsettings->timezone == 'America/Cancun' ? 'selected' : '' }}> (GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                                            <option value="Chile/EasterIsland" {{ @$getsettings->timezone == 'Chile/EasterIsland' ? 'selected' : '' }}> (GMT-06:00) Easter Island</option>
                                            <option value="America/Chicago" {{ @$getsettings->timezone == 'America/Chicago' ? 'selected' : '' }}> (GMT-06:00) Central Time (US & Canada)</option>
                                            <option value="America/New_York" {{ @$getsettings->timezone == 'America/New_York' ? 'selected' : '' }}> (GMT-05:00) Eastern Time (US & Canada)</option>
                                            <option value="America/Havana" {{ @$getsettings->timezone == 'America/Havana' ? 'selected' : '' }}> (GMT-05:00) Cuba</option>
                                            <option value="America/Bogota" {{ @$getsettings->timezone == 'America/Bogota' ? 'selected' : '' }}> (GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                                            <option value="America/Caracas" {{ @$getsettings->timezone == 'America/Caracas' ? 'selected' : '' }}> (GMT-04:30) Caracas</option>
                                            <option value="America/Santiago" {{ @$getsettings->timezone == 'America/Santiago' ? 'selected' : '' }}> (GMT-04:00) Santiago</option>
                                            <option value="America/La_Paz" {{ @$getsettings->timezone == 'America/La_Paz' ? 'selected' : '' }}> (GMT-04:00) La Paz</option>
                                            <option value="Atlantic/Stanley" {{ @$getsettings->timezone == 'Atlantic/Stanley' ? 'selected' : '' }}> (GMT-04:00) Faukland Islands</option>
                                            <option value="America/Campo_Grande" {{ @$getsettings->timezone == 'America/Campo_Grande' ? 'selected' : '' }}> (GMT-04:00) Brazil</option>
                                            <option value="America/Goose_Bay" {{ @$getsettings->timezone == 'America/Goose_Bay' ? 'selected' : '' }}> (GMT-04:00) Atlantic Time (Goose Bay)</option>
                                            <option value="America/Glace_Bay" {{ @$getsettings->timezone == 'America/Glace_Bay' ? 'selected' : '' }}> (GMT-04:00) Atlantic Time (Canada)</option>
                                            <option value="America/St_Johns" {{ @$getsettings->timezone == 'America/St_Johns' ? 'selected' : '' }}> (GMT-03:30) Newfoundland</option>
                                            <option value="America/Araguaina" {{ @$getsettings->timezone == 'America/Araguaina' ? 'selected' : '' }}> (GMT-03:00) UTC-3</option>
                                            <option value="America/Montevideo" {{ @$getsettings->timezone == 'America/Montevideo' ? 'selected' : '' }}> (GMT-03:00) Montevideo</option>
                                            <option value="America/Miquelon" {{ @$getsettings->timezone == 'America/Miquelon' ? 'selected' : '' }}> (GMT-03:00) Miquelon, St. Pierre</option>
                                            <option value="America/Godthab" {{ @$getsettings->timezone == 'America/Godthab' ? 'selected' : '' }}> (GMT-03:00) Greenland</option>
                                            <option value="America/Argentina/Buenos_Aires" {{ @$getsettings->timezone == 'America/Argentina/Buenos_Aires' ? 'selected' : '' }}> (GMT-03:00) Buenos Aires</option>
                                            <option value="America/Sao_Paulo" {{ @$getsettings->timezone == 'America/Sao_Paulo' ? 'selected' : '' }}> (GMT-03:00) Brasilia</option>
                                            <option value="America/Noronha" {{ @$getsettings->timezone == 'America/Noronha' ? 'selected' : '' }}> (GMT-02:00) Mid-Atlantic</option>
                                            <option value="Atlantic/Cape_Verde" {{ @$getsettings->timezone == 'Atlantic/Cape_Verde' ? 'selected' : '' }}> (GMT-01:00) Cape Verde Is.</option>
                                            <option value="Atlantic/Azores" {{ @$getsettings->timezone == 'Atlantic/Azores' ? 'selected' : '' }}> (GMT-01:00) Azores</option>
                                            <option value="Europe/Belfast" {{ @$getsettings->timezone == 'Europe/Belfast' ? 'selected' : '' }}> (GMT) Greenwich Mean Time : Belfast</option>
                                            <option value="Europe/Dublin" {{ @$getsettings->timezone == 'Europe/Dublin' ? 'selected' : '' }}> (GMT) Greenwich Mean Time : Dublin</option>
                                            <option value="Europe/Lisbon" {{ @$getsettings->timezone == 'Europe/Lisbon' ? 'selected' : '' }}> (GMT) Greenwich Mean Time : Lisbon</option>
                                            <option value="Europe/London" {{ @$getsettings->timezone == 'Europe/London' ? 'selected' : '' }}> (GMT) Greenwich Mean Time : London</option>
                                            <option value="Africa/Abidjan" {{ @$getsettings->timezone == 'Africa/Abidjan' ? 'selected' : '' }}> (GMT) Monrovia, Reykjavik</option>
                                            <option value="Europe/Amsterdam" {{ @$getsettings->timezone == 'Europe/Amsterdam' ? 'selected' : '' }}> (GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna </option>
                                            <option value="Europe/Belgrade" {{ @$getsettings->timezone == 'Europe/Belgrade' ? 'selected' : '' }}> (GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague </option>
                                            <option value="Europe/Brussels" {{ @$getsettings->timezone == 'Europe/Brussels' ? 'selected' : '' }}> (GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                                            <option value="Africa/Algiers" {{ @$getsettings->timezone == 'Africa/Algiers' ? 'selected' : '' }}> (GMT+01:00) West Central Africa</option>
                                            <option value="Africa/Windhoek" {{ @$getsettings->timezone == 'Africa/Windhoek' ? 'selected' : '' }}> (GMT+01:00) Windhoek</option>
                                            <option value="Asia/Beirut" {{ @$getsettings->timezone == 'Asia/Beirut' ? 'selected' : '' }}> (GMT+02:00) Beirut</option>
                                            <option value="Africa/Cairo" {{ @$getsettings->timezone == 'Africa/Cairo' ? 'selected' : '' }}> (GMT+02:00) Cairo</option>
                                            <option value="Asia/Gaza" {{ @$getsettings->timezone == 'Asia/Gaza' ? 'selected' : '' }}> (GMT+02:00) Gaza</option>
                                            <option value="Africa/Blantyre" {{ @$getsettings->timezone == 'Africa/Blantyre' ? 'selected' : '' }}> (GMT+02:00) Harare, Pretoria</option>
                                            <option value="Asia/Jerusalem" {{ @$getsettings->timezone == 'Asia/Jerusalem' ? 'selected' : '' }}> (GMT+02:00) Jerusalem</option>
                                            <option value="Europe/Minsk" {{ @$getsettings->timezone == 'Europe/Minsk' ? 'selected' : '' }}> (GMT+02:00) Minsk</option>
                                            <option value="Asia/Damascus" {{ @$getsettings->timezone == 'Asia/Damascus' ? 'selected' : '' }}> (GMT+02:00) Syria</option>
                                            <option value="Europe/Moscow" {{ @$getsettings->timezone == 'Europe/Moscow' ? 'selected' : '' }}> (GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
                                            <option value="Africa/Addis_Ababa" {{ @$getsettings->timezone == 'Africa/Addis_Ababa' ? 'selected' : '' }}> (GMT+03:00) Nairobi</option>
                                            <option value="Asia/Tehran" {{ @$getsettings->timezone == 'Asia/Tehran' ? 'selected' : '' }}> (GMT+03:30) Tehran</option>
                                            <option value="Asia/Dubai" {{ @$getsettings->timezone == 'Asia/Dubai' ? 'selected' : '' }}> (GMT+04:00) Abu Dhabi, Muscat</option>
                                            <option value="Asia/Yerevan" {{ @$getsettings->timezone == 'Asia/Yerevan' ? 'selected' : '' }}> (GMT+04:00) Yerevan</option>
                                            <option value="Asia/Kabul" {{ @$getsettings->timezone == 'Asia/Kabul' ? 'selected' : '' }}> (GMT+04:30) Kabul</option>
                                            <option value="Asia/Yekaterinburg" {{ @$getsettings->timezone == 'Asia/Yekaterinburg' ? 'selected' : '' }}> (GMT+05:00) Ekaterinburg</option>
                                            <option value="Asia/Tashkent" {{ @$getsettings->timezone == 'Asia/Tashkent' ? 'selected' : '' }}> (GMT+05:00) Tashkent</option>
                                            <option value="Asia/Kolkata" {{ @$getsettings->timezone == 'Asia/Kolkata' ? 'selected' : '' }}> (GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                                            <option value="Asia/Katmandu" {{ @$getsettings->timezone == 'Asia/Katmandu' ? 'selected' : '' }}> (GMT+05:45) Kathmandu</option>
                                            <option value="Asia/Dhaka" {{ @$getsettings->timezone == 'Asia/Dhaka' ? 'selected' : '' }}> (GMT+06:00) Astana, Dhaka</option>
                                            <option value="Asia/Novosibirsk" {{ @$getsettings->timezone == 'Asia/Novosibirsk' ? 'selected' : '' }}> (GMT+06:00) Novosibirsk</option>
                                            <option value="Asia/Rangoon" {{ @$getsettings->timezone == 'Asia/Rangoon' ? 'selected' : '' }}> (GMT+06:30) Yangon (Rangoon)</option>
                                            <option value="Asia/Bangkok" {{ @$getsettings->timezone == 'Asia/Bangkok' ? 'selected' : '' }}> (GMT+07:00) Bangkok, Hanoi, Jakarta</option>
                                            <option value="Asia/Krasnoyarsk" {{ @$getsettings->timezone == 'Asia/Krasnoyarsk' ? 'selected' : '' }}> (GMT+07:00) Krasnoyarsk</option>
                                            <option value="Asia/Hong_Kong" {{ @$getsettings->timezone == 'Asia/Hong_Kong' ? 'selected' : '' }}> (GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                                            <option value="Asia/Irkutsk" {{ @$getsettings->timezone == 'Asia/Irkutsk' ? 'selected' : '' }}> (GMT+08:00) Irkutsk, Ulaan Bataar</option>
                                            <option value="Australia/Perth" {{ @$getsettings->timezone == 'Australia/Perth' ? 'selected' : '' }}> (GMT+08:00) Perth</option>
                                            <option value="Australia/Eucla" {{ @$getsettings->timezone == 'Australia/Eucla' ? 'selected' : '' }}> (GMT+08:45) Eucla</option>
                                            <option value="Asia/Tokyo" {{ @$getsettings->timezone == 'Asia/Tokyo' ? 'selected' : '' }}> (GMT+09:00) Osaka, Sapporo, Tokyo</option>
                                            <option value="Asia/Seoul" {{ @$getsettings->timezone == 'Asia/Seoul' ? 'selected' : '' }}> (GMT+09:00) Seoul</option>
                                            <option value="Asia/Yakutsk" {{ @$getsettings->timezone == 'Asia/Yakutsk' ? 'selected' : '' }}> (GMT+09:00) Yakutsk</option>
                                            <option value="Australia/Adelaide" {{ @$getsettings->timezone == 'Australia/Adelaide' ? 'selected' : '' }}> (GMT+09:30) Adelaide</option>
                                            <option value="Australia/Darwin" {{ @$getsettings->timezone == 'Australia/Darwin' ? 'selected' : '' }}> (GMT+09:30) Darwin</option>
                                            <option value="Australia/Brisbane" {{ @$getsettings->timezone == 'Australia/Brisbane' ? 'selected' : '' }}> (GMT+10:00) Brisbane</option>
                                            <option value="Australia/Hobart" {{ @$getsettings->timezone == 'Australia/Hobart' ? 'selected' : '' }}> (GMT+10:00) Hobart</option>
                                            <option value="Asia/Vladivostok" {{ @$getsettings->timezone == 'Asia/Vladivostok' ? 'selected' : '' }}> (GMT+10:00) Vladivostok</option>
                                            <option value="Australia/Lord_Howe" {{ @$getsettings->timezone == 'Australia/Lord_Howe' ? 'selected' : '' }}> (GMT+10:30) Lord Howe Island</option>
                                            <option value="Etc/GMT-11" {{ @$getsettings->timezone == 'Etc/GMT-11' ? 'selected' : '' }}> (GMT+11:00) Solomon Is., New Caledonia</option>
                                            <option value="Asia/Magadan" {{ @$getsettings->timezone == 'Asia/Magadan' ? 'selected' : '' }}> (GMT+11:00) Magadan</option>
                                            <option value="Pacific/Norfolk" {{ @$getsettings->timezone == 'Pacific/Norfolk' ? 'selected' : '' }}> (GMT+11:30) Norfolk Island</option>
                                            <option value="Asia/Anadyr" {{ @$getsettings->timezone == 'Asia/Anadyr' ? 'selected' : '' }}> (GMT+12:00) Anadyr, Kamchatka</option>
                                            <option value="Pacific/Auckland" {{ @$getsettings->timezone == 'Pacific/Auckland' ? 'selected' : '' }}> (GMT+12:00) Auckland, Wellington</option>
                                            <option value="Etc/GMT-12" {{ @$getsettings->timezone == 'Etc/GMT-12' ? 'selected' : '' }}> (GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
                                            <option value="Pacific/Chatham" {{ @$getsettings->timezone == 'Pacific/Chatham' ? 'selected' : '' }}> (GMT+12:45) Chatham Islands</option>
                                            <option value="Pacific/Tongatapu" {{ @$getsettings->timezone == 'Pacific/Tongatapu' ? 'selected' : '' }}> (GMT+13:00) Nuku'alofa</option>
                                            <option value="Pacific/Kiritimati" {{ @$getsettings->timezone == 'Pacific/Kiritimati' ? 'selected' : '' }}> (GMT+14:00) Kiritimati</option>
                                        </select>
                                        @error('timezone') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group text-end">
                                    <a href="{{ url('/admin/home') }}" class="btn btn-outline-danger">{{ trans('labels.cancel') }}</a>
                                    <button class="btn btn-primary" @if (env('Environment')=='sendbox' ) type="button" onclick="myFunction()" @else type="submit" name="thirdparty_update" value="1" @endif>{{ trans('labels.save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form action="{{ URL::to('admin/settings/update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-3 mb-2">
                        <h5><i class="fa-solid fa-share-nodes"></i> {{ trans('labels.seo_settings') }} </h5>
                    </div>
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.og_title') }}</label>
                                        <input type="text" class="form-control" placeholder="{{ trans('labels.og_title') }}" name="og_title" id="og_title" value="{{ @$getsettings->og_title == '' ? old('og_title') : @$getsettings->og_title }}">
                                        @error('og_title') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.og_image') }} (1200 x 650) </label>
                                        <input type="file" class="form-control" name="og_image" id="og_image">
                                        @error('image') <span class="text-danger">{{ $message }}</span><br> @enderror
                                        <img src="{{ Helper::image_path(@$getsettings->og_image) }}" class="img-fluid rounded hw-50 mt-1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.og_description') }}</label>
                                        <textarea class="form-control" name="og_description" placeholder="{{ trans('labels.og_description') }}" id="og_description" rows="6">{{ @$getsettings->og_description == '' ? old('og_description') : @$getsettings->og_description }}</textarea>
                                        @error('og_description') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group text-end">
                                    <a href="{{ url('/admin/home') }}" class="btn btn-outline-danger">{{ trans('labels.cancel') }}</a>
                                    <button class="btn btn-primary" @if (env('Environment')=='sendbox' ) type="button" onclick="myFunction()" @else type="submit" name="seo_update" value="1" @endif>{{ trans('labels.save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


                <form action="{{ URL::to('admin/settings/update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-3 mb-2">
                        <h5><i class="fa-solid fa-bell"></i> {{ trans('labels.noti_settings') }} </h5>
                    </div>
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.noti_tone') }} (mp3 only) </label>
                                        <input type="file" class="form-control" name="noti_tune" id="noti_tune" accept="audio/mp3" required>
                                        @error('noti_tune') <span class="text-danger">{{ $message }}</span><br> @enderror


                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mt-4">
                                        @if($getsettings->notification_tune != "")
                                        <audio controls>
                                            <source src="{{ url(env('ASSETSPATHURL'))}}/admin-assets/notification/{{$getsettings->notification_tune}}" type="audio/mp3">
                                            <source src="{{ url(env('ASSETSPATHURL'))}}/admin-assets/notification/{{$getsettings->notification_tune}}" type="audio/mp3">
                                            Your browser does not support the audio element.
                                        </audio>
                                        @endif
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="form-group text-end">
                                    <a href="{{ url('/admin/home') }}" class="btn btn-outline-danger">{{ trans('labels.cancel') }}</a>
                                    <button class="btn btn-primary" @if (env('Environment')=='sendbox' ) type="button" onclick="myFunction()" @else type="submit" name="notification_update" value="1" @endif>{{ trans('labels.save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                @if (App\Models\SystemAddons::where('unique_identifier', 'template')->first() != null && App\Models\SystemAddons::where('unique_identifier', 'template')->first()->activated == 1)
                <form action="{{ URL::to('admin/settings/update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-3 mb-2">
                        <h5><i class="fa-solid fa-gears"></i> {{ trans('labels.theme_settings') }} </h5>
                    </div>
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 selectimg">
                                    <div class="form-group">

                                        <label class="form-label">{{ trans('labels.themes') }}
                                            <span class="text-danger"> * </span> </label>
                                        <div>
                                            <label for="template1" class="radio-card position-relative">
                                                <input type="radio" name="template" id="template1"  value="1" {{ $getsettings->theme == 1 ? 'checked' : '' }}  />
                                                <div class="card-content-wrapper border rounded-2">
                                                    <span class="check-icon position-absolute"></span>
                                                    <div class="selecimg">
                                                        <img src="{{ helper::image_path('theme-' . 1 . '.png') }}">
                                                    </div>
                                                </div>
                                            </label>
                                            <label for="template2" class="radio-card position-relative">
                                                <input type="radio" name="template" id="template2" value="2" {{ $getsettings->theme == 2 ? 'checked' : '' }}  />
                                                <div class="card-content-wrapper border rounded-2">
                                                    <span class="check-icon position-absolute"></span>
                                                    <div class="selecimg">
                                                        <img src="{{ helper::image_path('theme-' . 2 . '.png') }}">
                                                    </div>
                                                </div>
                                            </label>
                                            <label for="template3" class="radio-card position-relative">
                                                <input type="radio" name="template" id="template3" value="3" {{ $getsettings->theme == 3 ? 'checked' : '' }}  />
                                                <div class="card-content-wrapper border rounded-2">
                                                    <span class="check-icon position-absolute"></span>
                                                    <div class="selecimg">
                                                        <img src="{{ helper::image_path('theme-' . 3 . '.png') }}">
                                                    </div>
                                                </div>
                                            </label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group text-end">
                                    <a href="{{ url('/admin/home') }}" class="btn btn-outline-danger">{{ trans('labels.cancel') }}</a>
                                    <button class="btn btn-primary" @if (env('Environment')=='sendbox' ) type="button" onclick="myFunction()" @else type="submit" name="theme_update" value="1" @endif>{{ trans('labels.save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                @endif
                <form action="{{ URL::to('admin/settings/update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-3 mb-2">
                        <h5><i class="fa-solid fa-briefcase"></i> {{ trans('labels.business_settings') }} </h5>
                    </div>
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.currency') }} <span class="text-danger">*</span> </label>
                                        <input type="text" placeholder="{{ trans('labels.currency') }}" value="{{ @$getsettings->currency == '' ? old('currency') : @$getsettings->currency }}" class="form-control" name="currency" id="currency" required>
                                        @error('currency') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.currency_position') }} </label>
                                        <div class="d-flex">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input me-0" type="radio" name="currency_position" id="inlineRadio1" value="1" {{ @$getsettings->currency_position == 1 ? 'checked' : '' }} checked>
                                                <label class="form-check-label" for="inlineRadio1">{{ trans('labels.left') }}</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input me-0" type="radio" name="currency_position" id="inlineRadio2" value="2" {{ @$getsettings->currency_position == 2 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="inlineRadio2">{{ trans('labels.right') }}</label>
                                            </div>
                                            @error('currency') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.referral_amount') }} <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="{{ trans('labels.referral_amount') }}" value="{{ @$getsettings->referral_amount == '' ? old('referral_amount') : @$getsettings->referral_amount }}" class="form-control" name="referral_amount" id="referral_amount" required>
                                        @error('referral_amount') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.max_order_qty') }} <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="{{ trans('labels.max_order_qty') }}" value="{{ @$getsettings->max_order_qty == '' ? old('max_order_qty') : @$getsettings->max_order_qty }}" class="form-control" name="max_order_qty" id="max_order_qty" required>
                                        @error('max_order_qty') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.min_amount') }} <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="{{ trans('labels.min_amount') }}" value="{{ @$getsettings->min_order_amount == '' ? old('min_order_amount') : @$getsettings->min_order_amount }}" class="form-control" name="min_order_amount" id="min_order_amount" required>
                                        @error('min_order_amount') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.max_amount') }} <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="{{ trans('labels.max_amount') }}" value="{{ @$getsettings->max_order_amount == '' ? old('max_order_amount') : @$getsettings->max_order_amount }}" class="form-control" name="max_order_amount" id="max_order_amount" required>
                                        @error('max_order_amount') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.maintenance_mode') }} </label>
                                        <input id="maintenance_mode-switch" type="checkbox" class="checkbox-switch" name="maintenance_mode" value="1" {{ $getsettings->maintenance_mode == 1 ? 'checked' : '' }}>
                                        <label for="maintenance_mode-switch" class="switch">
                                            <span class="switch__circle"><span class="switch__circle-inner"></span></span>
                                            <span class="switch__left ps-2">{{ trans('labels.off') }}</span>
                                            <span class="switch__right pe-2">{{ trans('labels.on') }}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.login_required') }} </label>
                                        <input id="login_required-switch" type="checkbox" class="checkbox-switch" name="login_required" value="1" {{ $getsettings->login_required == 1 ? 'checked' : '' }}>
                                        <label for="login_required-switch" class="switch">
                                            <span class="switch__circle"><span class="switch__circle-inner"></span></span>
                                            <span class="switch__left ps-2">{{ trans('labels.off') }}</span>
                                            <span class="switch__right pe-2">{{ trans('labels.on') }}</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-form-label"
                                            for="">{{ trans('labels.pickup_delivery') }}
                                        </label>

                                        <select class="form-control selectpicker" name="pickup_delivery" id="pickup_delivery" data-live-search="true">
                                            <option value="1" {{$getsettings->pickup_delivery == 1 ? 'selected' : ''}}>{{trans('labels.both')}}</option>
                                            <option value="2" {{$getsettings->pickup_delivery == 2 ? 'selected' : ''}}>{{trans('labels.delivery')}}</option>
                                            <option value="3" {{$getsettings->pickup_delivery == 3 ? 'selected' : ''}}>{{trans('labels.pickup')}}</option>
                                        </select>
                                        
                                    </div>
                                </div>                          
                            </div>


                            <div class="row">
                                <div class="form-group text-end">
                                    <a href="{{ url('/admin/home') }}" class="btn btn-outline-danger">{{ trans('labels.cancel') }}</a>
                                    <button class="btn btn-primary" @if (env('Environment')=='sendbox' ) type="button" onclick="myFunction()" @else type="submit" name="business_update" value="1" @endif>{{ trans('labels.save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form action="{{ URL::to('admin/settings/update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-3 mb-2">
                        <h5><i class="fa-solid fa-browser"></i> {{ trans('labels.website_settings') }} </h5>
                    </div>
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.title_for_title_bar') }}</label>
                                        <input type="text" class="form-control" name="title" id="title" value="{{ @$getsettings->title == '' ? old('title') : @$getsettings->title }}" placeholder="{{ trans('labels.title_for_title_bar') }}">
                                        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.short_title') }} </label>
                                        <input type="text" class="form-control" name="short_title" id="short_title" value="{{ @$getsettings->short_title == '' ? old('short_title') : @$getsettings->short_title }}" placeholder="{{ trans('labels.short_title') }}">
                                        @error('short_title') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.logo') }} (250 x 250) </label>
                                        <input type="file" class="form-control" name="logo" id="logo">
                                        @error('logo') <span class="text-danger">{{ $message }}</span><br> @enderror
                                        <img src="{{ Helper::image_path(@$getsettings->logo) }}" class="img-fluid rounded hw-50 mt-1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.Favicon') }} (16 x 16) </label>
                                        <input type="file" class="form-control" name="favicon" id="favicon">
                                        @error('favicon') <span class="text-danger">{{ $message }}</span><br> @enderror
                                        <img src="{{ Helper::image_path(@$getsettings->favicon) }}" class="img-fluid rounded hw-50 mt-1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.copyright') }} </label>
                                        <input type="text" class="form-control" name="copyright" id="copyright" value="{{ @$getsettings->copyright == '' ? old('copyright') : @$getsettings->copyright }}" placeholder="{{ trans('labels.copyright') }}">
                                        @error('copyright') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <hr class="divider">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.mobile_app_title') }}</label>
                                        <input type="text" class="form-control" placeholder="{{ trans('labels.mobile_app_title') }}" name="mobile_app_title" id="mobile_app_title" value="{{ @$getsettings->mobile_app_title == '' ? old('mobile_app_title') : @$getsettings->mobile_app_title }}">
                                        @error('mobile_app_title') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.mobile_app_description') }}</label>
                                        <textarea class="form-control" name="mobile_app_description" placeholder="{{ trans('labels.mobile_app_description') }}" id="mobile_app_description" rows="5">{{ @$getsettings->mobile_app_description == '' ? old('mobile_app_description') : @$getsettings->mobile_app_description }}</textarea>
                                        @error('mobile_app_description') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.mobile_app_image') }} (650 x 750) </label>
                                        <input type="file" class="form-control" name="mobile_app_image" id="mobile_app_image">
                                        @error('image') <span class="text-danger">{{ $message }}</span><br> @enderror
                                        <img src="{{ Helper::image_path(@$getsettings->mobile_app_image) }}" class="img-fluid rounded hw-50 mt-1">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.bg_image') }} (1920 x 300) </label>
                                        <input type="file" class="form-control" name="mobile_app_bg_image">
                                        @error('image') <span class="text-danger">{{ $message }}</span><br> @enderror
                                        <img src="{{ Helper::image_path(@$getsettings->mobile_app_bg_image) }}" class="img-fluid rounded hw-50 mt-1">
                                    </div>
                                </div>
                                <hr class="divider">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.auth_bg_image') }} (1920 x 1280) </label>
                                        <input type="file" class="form-control" name="auth_bg_image" id="auth_bg_image">
                                        @error('auth_bg_image') <span class="text-danger">{{ $message }}</span><br> @enderror
                                        <img src="{{ Helper::image_path(@$getsettings->auth_bg_image) }}" class="img-fluid rounded hw-50 mt-1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.breadcrumb_bg_image') }} (1920 x 300) </label>
                                        <input type="file" class="form-control" name="breadcrumb_bg_image" id="breadcrumb_bg_image">
                                        @error('breadcrumb_bg_image') <span class="text-danger">{{ $message }}</span><br> @enderror
                                        <img src="{{ Helper::image_path(@$getsettings->breadcrumb_bg_image) }}" class="img-fluid rounded hw-50 mt-1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.booknow_bg_image') }} (1920 x 550) </label>
                                        <input type="file" class="form-control" name="booknow_bg_image">
                                        @error('booknow_bg_image') <span class="text-danger">{{ $message }}</span><br> @enderror
                                        <img src="{{ Helper::image_path(@$getsettings->booknow_bg_image) }}" class="img-fluid rounded hw-50 mt-1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.reviews_bg_image') }} (1920 x 550) </label>
                                        <input type="file" class="form-control" name="reviews_bg_image">
                                        @error('reviews_bg_image') <span class="text-danger">{{ $message }}</span><br> @enderror
                                        <img src="{{ Helper::image_path(@$getsettings->reviews_bg_image) }}" class="img-fluid rounded hw-50 mt-1">
                                    </div>
                                </div>
                                <hr class="divider">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.footer_title') }}</label>
                                        <input type="text" class="form-control" placeholder="{{ trans('labels.footer_title') }}" name="footer_title" id="footer_title" value="{{ @$getsettings->footer_title == '' ? old('footer_title') : @$getsettings->footer_title }}">
                                        @error('footer_title') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.footer_description') }}</label>
                                        <textarea class="form-control" name="footer_description" placeholder="{{ trans('labels.footer_description') }}" id="footer_description" rows="5">{{ @$getsettings->footer_description == '' ? old('footer_description') : @$getsettings->footer_description }}</textarea>
                                        @error('footer_description') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.footer_logo') }} (250 x 250) </label>
                                        <input type="file" class="form-control" name="footer_logo" id="footer_logo">
                                        @error('footer_logo') <span class="text-danger">{{ $message }}</span><br> @enderror
                                        <img src="{{ Helper::image_path(@$getsettings->footer_logo) }}" class="img-fluid rounded hw-50 mt-1">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.footer_bg_image') }} (1920 x 650) </label>
                                        <input type="file" class="form-control" name="footer_bg_image" id="footer_bg_image">
                                        @error('footer_bg_image') <span class="text-danger">{{ $message }}</span><br> @enderror
                                        <img src="{{ Helper::image_path(@$getsettings->footer_bg_image) }}" class="img-fluid rounded hw-50 mt-1">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row justify-content-between">
                                            <label class="col-auto col-form-label" for="">{{ trans('labels.footer_features') }} <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="Ex. <i class='fa-solid fa-truck-fast'></i> Visit https://fontawesome.com/ for more info"> <i class="fa-solid fa-circle-info"></i> </span> </label>
                                            @if (count($getfooterfeatures) > 0)
                                            <span class="col-auto">
                                                <button class="btn btn-sm btn-outline-info" type="button" onclick="add_features('{{ trans('labels.icon') }}','{{ trans('labels.title') }}','{{ trans('labels.description') }}')"> <i class="fa-sharp fa-solid fa-plus"></i> {{ trans('labels.add_new') }}</button>
                                            </span>
                                            @endif
                                        </div>
                                        @forelse ($getfooterfeatures as $key => $features)
                                        <div class="row">
                                            <input type="hidden" name="edit_icon_key[]" value="{{ $features->id }}">
                                            <div class="col-md-3 form-group">
                                                <div class="input-group">
                                                    <input type="text" class="form-control feature_required" onkeyup="show_feature_icon(this)" name="edi_feature_icon[{{ $features->id }}]" placeholder="{{ trans('labels.icon') }}" value="{{ $features->icon }}" required>
                                                    <p class="input-group-text">{!! $features->icon !!}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <input type="text" class="form-control" name="edi_feature_title[{{ $features->id }}]" placeholder="{{ trans('labels.title') }}" value="{{ $features->title }}" required>
                                            </div>
                                            <div class="col-md-5 form-group">
                                                <input type="text" class="form-control" name="edi_feature_description[{{ $features->id }}]" placeholder="{{ trans('labels.description') }}" value="{{ $features->description }}" required>
                                            </div>
                                            <div class="col-md-1 form-group">
                                                <button class="btn btn-danger" type="button" onclick="delete_features('{{ URL::to('admin/settings/delete-feature-' . $features->id) }}')"> <i class="fa fa-trash"></i> </button>
                                            </div>
                                        </div>
                                        @empty
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <div class="input-group">
                                                    <input type="text" class="form-control feature_required" onkeyup="show_feature_icon(this)" name="feature_icon[]" placeholder="{{ trans('labels.icon') }}">
                                                    <p class="input-group-text"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <input type="text" class="form-control feature_required" name="feature_title[]" placeholder="{{ trans('labels.title') }}">
                                            </div>
                                            <div class="col-md-5 form-group">
                                                <input type="text" class="form-control feature_required" name="feature_description[]" placeholder="{{ trans('labels.description') }}">
                                            </div>
                                            <div class="col-md-1 form-group">
                                                <button class="btn btn-info" type="button" onclick="add_features('{{ trans('labels.icon') }}','{{ trans('labels.title') }}','{{ trans('labels.description') }}')"> <i class="fa-sharp fa-solid fa-plus"></i> </button>
                                            </div>
                                        </div>
                                        @endforelse
                                        <span class="extra_footer_features"></span>
                                        {{-- @if (count($getfooterfeatures) > 0)
                                                <button class="btn btn-info" type="button" onclick="add_features('{{ trans('labels.icon') }}','{{ trans('labels.title') }}','{{ trans('labels.description') }}')"> <i class="fa-sharp fa-solid fa-plus"></i> {{ trans('labels.add_new') }} </button>
                                        @endif --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group text-end">
                                    <a href="{{ url('/admin/home') }}" class="btn btn-outline-danger">{{ trans('labels.cancel') }}</a>
                                    <button class="btn btn-primary" @if (env('Environment')=='sendbox' ) type="button" onclick="myFunction()" @else type="submit" name="web_update" value="1" @endif>{{ trans('labels.save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form action="{{ URL::to('admin/settings/update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-3 mb-2">
                        <h5><i class="fa-solid fa-mobile-notch"></i> {{ trans('labels.mobile_app_settings') }} </h5>
                    </div>
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.ios_app_link') }}</label>
                                        <input type="text" class="form-control" name="ios" id="ios" value="{{ @$getsettings->ios == '' ? old('ios') : @$getsettings->ios }}" placeholder="{{ trans('labels.ios_app_link') }}">
                                        @error('ios') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.android_app_link') }}</label>
                                        <input type="text" class="form-control" name="android" id="android" value="{{ @$getsettings->android == '' ? old('android') : @$getsettings->android }}" placeholder="{{ trans('labels.android_app_link') }}">
                                        @error('android') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.app_bottom_image') }} (1440 x 1600) </label>
                                        <input type="file" class="form-control" name="app_bottom_image" id="app_bottom_image">
                                        @error('image') <span class="text-danger">{{ $message }}</span><br> @enderror
                                        <img src="{{ Helper::image_path(@$getsettings->app_bottom_image) }}" class="img-fluid rounded hw-50 mt-1">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group text-end">
                                    <a href="{{ url('/admin/home') }}" class="btn btn-outline-danger">{{ trans('labels.cancel') }}</a>
                                    <button class="btn btn-primary" @if (env('Environment')=='sendbox' ) type="button" onclick="myFunction()" @else type="submit" name="mobileapp_update" value="1" @endif>{{ trans('labels.save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form action="{{ URL::to('admin/settings/update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-3 mb-2">
                        <h5><i class="fa-solid fa-square-info"></i> {{ trans('labels.about_us') }} </h5>
                    </div>
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.about_content') }} </label>
                                        <textarea class="form-control" name="about_content" id="ckeditor" rows="5">{{ @$getsettings->about_content == '' ? old('about_content') : @$getsettings->about_content }}</textarea>
                                        @error('about_content') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group text-end">
                                    <a href="{{ url('/admin/home') }}" class="btn btn-outline-danger">{{ trans('labels.cancel') }}</a>
                                    <button class="btn btn-primary" @if (env('Environment')=='sendbox' ) type="button" onclick="myFunction()" @else type="submit" name="about_update" value="1" @endif>{{ trans('labels.save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key={{ @Helper::appdata()->map }}&libraries=places&callback=initMap" async defer></script>
<script src="{{url(env('ASSETSPATHURL').'admin-assets/assets/js/custom/settings.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace('ckeditor');
</script>
@endsection