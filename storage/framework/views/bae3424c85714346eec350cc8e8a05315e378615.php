<?php $__env->startSection('content'); ?>
<?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="form-validation">
                <form action="<?php echo e(URL::to('admin/settings/update')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="mt-3 mb-2">
                        <h5><i class="fa-solid fa-address-card"></i> <?php echo e(trans('labels.contact_settings')); ?> </h5>
                    </div>
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.email')); ?> <span class="text-danger">*</span></label> </label>
                                        <input type="text" class="form-control" name="email" value="<?php echo e(@$getsettings->email == '' ? old('email') : @$getsettings->email); ?>" placeholder="<?php echo e(trans('labels.email')); ?>" required>
                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.mobile')); ?> <span class="text-danger">*</span></label> </label>
                                        <input type="text" class="form-control" name="mobile" value="<?php echo e(@$getsettings->mobile == '' ? old('mobile') : @$getsettings->mobile); ?>" placeholder="<?php echo e(trans('labels.mobile')); ?>" id="mobile" required>
                                        <?php $__errorArgs = ['mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.address')); ?> <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="address" id="address" value="<?php echo e(@$getsettings->address == '' ? old('address') : @$getsettings->address); ?>" required>
                                        <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span><br> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.latitude')); ?> <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="<?php echo e(trans('labels.latitude')); ?>" value="<?php echo e(@$getsettings->lat == '' ? old('lat') : @$getsettings->lat); ?>" class="form-control" name="lat" id="lat" readonly required>
                                        <?php $__errorArgs = ['lat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.longitude')); ?> <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="<?php echo e(trans('labels.longitude')); ?>" value="<?php echo e(@$getsettings->lang == '' ? old('lang') : @$getsettings->lang); ?>" class="form-control" name="lang" id="lang" readonly required>
                                        <?php $__errorArgs = ['lang'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="mymap" class="settings-map"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.facebook_link')); ?></label>
                                        <input type="text" class="form-control" name="fb" id="fb" value="<?php echo e(@$getsettings->fb == '' ? old('fb') : @$getsettings->fb); ?>" placeholder="<?php echo e(trans('labels.facebook_link')); ?>">
                                        <?php $__errorArgs = ['fb'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.youtube_link')); ?></label>
                                        <input type="text" class="form-control" name="youtube" id="youtube" value="<?php echo e(@$getsettings->youtube == '' ? old('youtube') : @$getsettings->youtube); ?>" placeholder="<?php echo e(trans('labels.youtube_link')); ?>">
                                        <?php $__errorArgs = ['youtube'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.instagram_link')); ?></label>
                                        <input type="text" class="form-control" name="insta" id="insta" value="<?php echo e(@$getsettings->insta == '' ? old('insta') : @$getsettings->insta); ?>" placeholder="<?php echo e(trans('labels.instagram_link')); ?>">
                                        <?php $__errorArgs = ['insta'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group text-end">
                                    <a href="<?php echo e(url('/admin/home')); ?>" class="btn btn-outline-danger"><?php echo e(trans('labels.cancel')); ?></a>
                                    <button class="btn btn-primary" <?php if(env('Environment')=='sendbox' ): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" name="contact_update" value="1" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form action="<?php echo e(URL::to('admin/settings/update')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="mt-3 mb-2">
                        <h5><i class="fa-regular fa-earth-americas"></i> <?php echo e(trans('labels.third_party_settings')); ?> </h5>
                    </div>
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.map_key')); ?> <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="map" id="map" value="<?php echo e(@$getsettings->map == '' ? old('map') : @$getsettings->map); ?>" placeholder="<?php echo e(trans('labels.map_key')); ?>" required>
                                        <?php $__errorArgs = ['map'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.firebase_key')); ?> <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="firebase" id="firebase" value="<?php echo e(@$getsettings->firebase == '' ? old('firebase') : @$getsettings->firebase); ?>" placeholder="<?php echo e(trans('labels.firebase_key')); ?>" required>
                                        <?php $__errorArgs = ['firebase'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.timezone')); ?></label>
                                        <select class="form-control selectpicker" name="timezone" id="timezone" data-live-search="true">
                                            <option value="" selected> <?php echo e(trans('labels.select')); ?> </option>
                                            <option value="Pacific/Midway" <?php echo e(@$getsettings->timezone == 'Pacific/Midway' ? 'selected' : ''); ?>> (GMT-11:00) Midway Island, Samoa</option>
                                            <option value="America/Adak" <?php echo e(@$getsettings->timezone == 'America/Adak' ? 'selected' : ''); ?>> (GMT-10:00) Hawaii-Aleutian</option>
                                            <option value="Etc/GMT+10" <?php echo e(@$getsettings->timezone == 'Etc/GMT+10' ? 'selected' : ''); ?>> (GMT-10:00) Hawaii</option>
                                            <option value="Pacific/Marquesas" <?php echo e(@$getsettings->timezone == 'Pacific/Marquesas' ? 'selected' : ''); ?>> (GMT-09:30) Marquesas Islands</option>
                                            <option value="Pacific/Gambier" <?php echo e(@$getsettings->timezone == 'Pacific/Gambier' ? 'selected' : ''); ?>> (GMT-09:00) Gambier Islands</option>
                                            <option value="America/Anchorage" <?php echo e(@$getsettings->timezone == 'America/Anchorage' ? 'selected' : ''); ?>> (GMT-09:00) Alaska</option>
                                            <option value="America/Ensenada" <?php echo e(@$getsettings->timezone == 'America/Ensenada' ? 'selected' : ''); ?>> (GMT-08:00) Tijuana, Baja California</option>
                                            <option value="Etc/GMT+8" <?php echo e(@$getsettings->timezone == 'Etc/GMT+8' ? 'selected' : ''); ?>> (GMT-08:00) Pitcairn Islands</option>
                                            <option value="America/Los_Angeles" <?php echo e(@$getsettings->timezone == 'America/Los_Angeles' ? 'selected' : ''); ?>> (GMT-08:00) Pacific Time (US & Canada)</option>
                                            <option value="America/Denver" <?php echo e(@$getsettings->timezone == 'America/Denver' ? 'selected' : ''); ?>> (GMT-07:00) Mountain Time (US & Canada)</option>
                                            <option value="America/Chihuahua" <?php echo e(@$getsettings->timezone == 'America/Chihuahua' ? 'selected' : ''); ?>> (GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                                            <option value="America/Dawson_Creek" <?php echo e(@$getsettings->timezone == 'America/Dawson_Creek' ? 'selected' : ''); ?>> (GMT-07:00) Arizona</option>
                                            <option value="America/Belize" <?php echo e(@$getsettings->timezone == 'America/Belize' ? 'selected' : ''); ?>> (GMT-06:00) Saskatchewan, Central America</option>
                                            <option value="America/Cancun" <?php echo e(@$getsettings->timezone == 'America/Cancun' ? 'selected' : ''); ?>> (GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                                            <option value="Chile/EasterIsland" <?php echo e(@$getsettings->timezone == 'Chile/EasterIsland' ? 'selected' : ''); ?>> (GMT-06:00) Easter Island</option>
                                            <option value="America/Chicago" <?php echo e(@$getsettings->timezone == 'America/Chicago' ? 'selected' : ''); ?>> (GMT-06:00) Central Time (US & Canada)</option>
                                            <option value="America/New_York" <?php echo e(@$getsettings->timezone == 'America/New_York' ? 'selected' : ''); ?>> (GMT-05:00) Eastern Time (US & Canada)</option>
                                            <option value="America/Havana" <?php echo e(@$getsettings->timezone == 'America/Havana' ? 'selected' : ''); ?>> (GMT-05:00) Cuba</option>
                                            <option value="America/Bogota" <?php echo e(@$getsettings->timezone == 'America/Bogota' ? 'selected' : ''); ?>> (GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                                            <option value="America/Caracas" <?php echo e(@$getsettings->timezone == 'America/Caracas' ? 'selected' : ''); ?>> (GMT-04:30) Caracas</option>
                                            <option value="America/Santiago" <?php echo e(@$getsettings->timezone == 'America/Santiago' ? 'selected' : ''); ?>> (GMT-04:00) Santiago</option>
                                            <option value="America/La_Paz" <?php echo e(@$getsettings->timezone == 'America/La_Paz' ? 'selected' : ''); ?>> (GMT-04:00) La Paz</option>
                                            <option value="Atlantic/Stanley" <?php echo e(@$getsettings->timezone == 'Atlantic/Stanley' ? 'selected' : ''); ?>> (GMT-04:00) Faukland Islands</option>
                                            <option value="America/Campo_Grande" <?php echo e(@$getsettings->timezone == 'America/Campo_Grande' ? 'selected' : ''); ?>> (GMT-04:00) Brazil</option>
                                            <option value="America/Goose_Bay" <?php echo e(@$getsettings->timezone == 'America/Goose_Bay' ? 'selected' : ''); ?>> (GMT-04:00) Atlantic Time (Goose Bay)</option>
                                            <option value="America/Glace_Bay" <?php echo e(@$getsettings->timezone == 'America/Glace_Bay' ? 'selected' : ''); ?>> (GMT-04:00) Atlantic Time (Canada)</option>
                                            <option value="America/St_Johns" <?php echo e(@$getsettings->timezone == 'America/St_Johns' ? 'selected' : ''); ?>> (GMT-03:30) Newfoundland</option>
                                            <option value="America/Araguaina" <?php echo e(@$getsettings->timezone == 'America/Araguaina' ? 'selected' : ''); ?>> (GMT-03:00) UTC-3</option>
                                            <option value="America/Montevideo" <?php echo e(@$getsettings->timezone == 'America/Montevideo' ? 'selected' : ''); ?>> (GMT-03:00) Montevideo</option>
                                            <option value="America/Miquelon" <?php echo e(@$getsettings->timezone == 'America/Miquelon' ? 'selected' : ''); ?>> (GMT-03:00) Miquelon, St. Pierre</option>
                                            <option value="America/Godthab" <?php echo e(@$getsettings->timezone == 'America/Godthab' ? 'selected' : ''); ?>> (GMT-03:00) Greenland</option>
                                            <option value="America/Argentina/Buenos_Aires" <?php echo e(@$getsettings->timezone == 'America/Argentina/Buenos_Aires' ? 'selected' : ''); ?>> (GMT-03:00) Buenos Aires</option>
                                            <option value="America/Sao_Paulo" <?php echo e(@$getsettings->timezone == 'America/Sao_Paulo' ? 'selected' : ''); ?>> (GMT-03:00) Brasilia</option>
                                            <option value="America/Noronha" <?php echo e(@$getsettings->timezone == 'America/Noronha' ? 'selected' : ''); ?>> (GMT-02:00) Mid-Atlantic</option>
                                            <option value="Atlantic/Cape_Verde" <?php echo e(@$getsettings->timezone == 'Atlantic/Cape_Verde' ? 'selected' : ''); ?>> (GMT-01:00) Cape Verde Is.</option>
                                            <option value="Atlantic/Azores" <?php echo e(@$getsettings->timezone == 'Atlantic/Azores' ? 'selected' : ''); ?>> (GMT-01:00) Azores</option>
                                            <option value="Europe/Belfast" <?php echo e(@$getsettings->timezone == 'Europe/Belfast' ? 'selected' : ''); ?>> (GMT) Greenwich Mean Time : Belfast</option>
                                            <option value="Europe/Dublin" <?php echo e(@$getsettings->timezone == 'Europe/Dublin' ? 'selected' : ''); ?>> (GMT) Greenwich Mean Time : Dublin</option>
                                            <option value="Europe/Lisbon" <?php echo e(@$getsettings->timezone == 'Europe/Lisbon' ? 'selected' : ''); ?>> (GMT) Greenwich Mean Time : Lisbon</option>
                                            <option value="Europe/London" <?php echo e(@$getsettings->timezone == 'Europe/London' ? 'selected' : ''); ?>> (GMT) Greenwich Mean Time : London</option>
                                            <option value="Africa/Abidjan" <?php echo e(@$getsettings->timezone == 'Africa/Abidjan' ? 'selected' : ''); ?>> (GMT) Monrovia, Reykjavik</option>
                                            <option value="Europe/Amsterdam" <?php echo e(@$getsettings->timezone == 'Europe/Amsterdam' ? 'selected' : ''); ?>> (GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna </option>
                                            <option value="Europe/Belgrade" <?php echo e(@$getsettings->timezone == 'Europe/Belgrade' ? 'selected' : ''); ?>> (GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague </option>
                                            <option value="Europe/Brussels" <?php echo e(@$getsettings->timezone == 'Europe/Brussels' ? 'selected' : ''); ?>> (GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                                            <option value="Africa/Algiers" <?php echo e(@$getsettings->timezone == 'Africa/Algiers' ? 'selected' : ''); ?>> (GMT+01:00) West Central Africa</option>
                                            <option value="Africa/Windhoek" <?php echo e(@$getsettings->timezone == 'Africa/Windhoek' ? 'selected' : ''); ?>> (GMT+01:00) Windhoek</option>
                                            <option value="Asia/Beirut" <?php echo e(@$getsettings->timezone == 'Asia/Beirut' ? 'selected' : ''); ?>> (GMT+02:00) Beirut</option>
                                            <option value="Africa/Cairo" <?php echo e(@$getsettings->timezone == 'Africa/Cairo' ? 'selected' : ''); ?>> (GMT+02:00) Cairo</option>
                                            <option value="Asia/Gaza" <?php echo e(@$getsettings->timezone == 'Asia/Gaza' ? 'selected' : ''); ?>> (GMT+02:00) Gaza</option>
                                            <option value="Africa/Blantyre" <?php echo e(@$getsettings->timezone == 'Africa/Blantyre' ? 'selected' : ''); ?>> (GMT+02:00) Harare, Pretoria</option>
                                            <option value="Asia/Jerusalem" <?php echo e(@$getsettings->timezone == 'Asia/Jerusalem' ? 'selected' : ''); ?>> (GMT+02:00) Jerusalem</option>
                                            <option value="Europe/Minsk" <?php echo e(@$getsettings->timezone == 'Europe/Minsk' ? 'selected' : ''); ?>> (GMT+02:00) Minsk</option>
                                            <option value="Asia/Damascus" <?php echo e(@$getsettings->timezone == 'Asia/Damascus' ? 'selected' : ''); ?>> (GMT+02:00) Syria</option>
                                            <option value="Europe/Moscow" <?php echo e(@$getsettings->timezone == 'Europe/Moscow' ? 'selected' : ''); ?>> (GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
                                            <option value="Africa/Addis_Ababa" <?php echo e(@$getsettings->timezone == 'Africa/Addis_Ababa' ? 'selected' : ''); ?>> (GMT+03:00) Nairobi</option>
                                            <option value="Asia/Tehran" <?php echo e(@$getsettings->timezone == 'Asia/Tehran' ? 'selected' : ''); ?>> (GMT+03:30) Tehran</option>
                                            <option value="Asia/Dubai" <?php echo e(@$getsettings->timezone == 'Asia/Dubai' ? 'selected' : ''); ?>> (GMT+04:00) Abu Dhabi, Muscat</option>
                                            <option value="Asia/Yerevan" <?php echo e(@$getsettings->timezone == 'Asia/Yerevan' ? 'selected' : ''); ?>> (GMT+04:00) Yerevan</option>
                                            <option value="Asia/Kabul" <?php echo e(@$getsettings->timezone == 'Asia/Kabul' ? 'selected' : ''); ?>> (GMT+04:30) Kabul</option>
                                            <option value="Asia/Yekaterinburg" <?php echo e(@$getsettings->timezone == 'Asia/Yekaterinburg' ? 'selected' : ''); ?>> (GMT+05:00) Ekaterinburg</option>
                                            <option value="Asia/Tashkent" <?php echo e(@$getsettings->timezone == 'Asia/Tashkent' ? 'selected' : ''); ?>> (GMT+05:00) Tashkent</option>
                                            <option value="Asia/Kolkata" <?php echo e(@$getsettings->timezone == 'Asia/Kolkata' ? 'selected' : ''); ?>> (GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                                            <option value="Asia/Katmandu" <?php echo e(@$getsettings->timezone == 'Asia/Katmandu' ? 'selected' : ''); ?>> (GMT+05:45) Kathmandu</option>
                                            <option value="Asia/Dhaka" <?php echo e(@$getsettings->timezone == 'Asia/Dhaka' ? 'selected' : ''); ?>> (GMT+06:00) Astana, Dhaka</option>
                                            <option value="Asia/Novosibirsk" <?php echo e(@$getsettings->timezone == 'Asia/Novosibirsk' ? 'selected' : ''); ?>> (GMT+06:00) Novosibirsk</option>
                                            <option value="Asia/Rangoon" <?php echo e(@$getsettings->timezone == 'Asia/Rangoon' ? 'selected' : ''); ?>> (GMT+06:30) Yangon (Rangoon)</option>
                                            <option value="Asia/Bangkok" <?php echo e(@$getsettings->timezone == 'Asia/Bangkok' ? 'selected' : ''); ?>> (GMT+07:00) Bangkok, Hanoi, Jakarta</option>
                                            <option value="Asia/Krasnoyarsk" <?php echo e(@$getsettings->timezone == 'Asia/Krasnoyarsk' ? 'selected' : ''); ?>> (GMT+07:00) Krasnoyarsk</option>
                                            <option value="Asia/Hong_Kong" <?php echo e(@$getsettings->timezone == 'Asia/Hong_Kong' ? 'selected' : ''); ?>> (GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                                            <option value="Asia/Irkutsk" <?php echo e(@$getsettings->timezone == 'Asia/Irkutsk' ? 'selected' : ''); ?>> (GMT+08:00) Irkutsk, Ulaan Bataar</option>
                                            <option value="Australia/Perth" <?php echo e(@$getsettings->timezone == 'Australia/Perth' ? 'selected' : ''); ?>> (GMT+08:00) Perth</option>
                                            <option value="Australia/Eucla" <?php echo e(@$getsettings->timezone == 'Australia/Eucla' ? 'selected' : ''); ?>> (GMT+08:45) Eucla</option>
                                            <option value="Asia/Tokyo" <?php echo e(@$getsettings->timezone == 'Asia/Tokyo' ? 'selected' : ''); ?>> (GMT+09:00) Osaka, Sapporo, Tokyo</option>
                                            <option value="Asia/Seoul" <?php echo e(@$getsettings->timezone == 'Asia/Seoul' ? 'selected' : ''); ?>> (GMT+09:00) Seoul</option>
                                            <option value="Asia/Yakutsk" <?php echo e(@$getsettings->timezone == 'Asia/Yakutsk' ? 'selected' : ''); ?>> (GMT+09:00) Yakutsk</option>
                                            <option value="Australia/Adelaide" <?php echo e(@$getsettings->timezone == 'Australia/Adelaide' ? 'selected' : ''); ?>> (GMT+09:30) Adelaide</option>
                                            <option value="Australia/Darwin" <?php echo e(@$getsettings->timezone == 'Australia/Darwin' ? 'selected' : ''); ?>> (GMT+09:30) Darwin</option>
                                            <option value="Australia/Brisbane" <?php echo e(@$getsettings->timezone == 'Australia/Brisbane' ? 'selected' : ''); ?>> (GMT+10:00) Brisbane</option>
                                            <option value="Australia/Hobart" <?php echo e(@$getsettings->timezone == 'Australia/Hobart' ? 'selected' : ''); ?>> (GMT+10:00) Hobart</option>
                                            <option value="Asia/Vladivostok" <?php echo e(@$getsettings->timezone == 'Asia/Vladivostok' ? 'selected' : ''); ?>> (GMT+10:00) Vladivostok</option>
                                            <option value="Australia/Lord_Howe" <?php echo e(@$getsettings->timezone == 'Australia/Lord_Howe' ? 'selected' : ''); ?>> (GMT+10:30) Lord Howe Island</option>
                                            <option value="Etc/GMT-11" <?php echo e(@$getsettings->timezone == 'Etc/GMT-11' ? 'selected' : ''); ?>> (GMT+11:00) Solomon Is., New Caledonia</option>
                                            <option value="Asia/Magadan" <?php echo e(@$getsettings->timezone == 'Asia/Magadan' ? 'selected' : ''); ?>> (GMT+11:00) Magadan</option>
                                            <option value="Pacific/Norfolk" <?php echo e(@$getsettings->timezone == 'Pacific/Norfolk' ? 'selected' : ''); ?>> (GMT+11:30) Norfolk Island</option>
                                            <option value="Asia/Anadyr" <?php echo e(@$getsettings->timezone == 'Asia/Anadyr' ? 'selected' : ''); ?>> (GMT+12:00) Anadyr, Kamchatka</option>
                                            <option value="Pacific/Auckland" <?php echo e(@$getsettings->timezone == 'Pacific/Auckland' ? 'selected' : ''); ?>> (GMT+12:00) Auckland, Wellington</option>
                                            <option value="Etc/GMT-12" <?php echo e(@$getsettings->timezone == 'Etc/GMT-12' ? 'selected' : ''); ?>> (GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
                                            <option value="Pacific/Chatham" <?php echo e(@$getsettings->timezone == 'Pacific/Chatham' ? 'selected' : ''); ?>> (GMT+12:45) Chatham Islands</option>
                                            <option value="Pacific/Tongatapu" <?php echo e(@$getsettings->timezone == 'Pacific/Tongatapu' ? 'selected' : ''); ?>> (GMT+13:00) Nuku'alofa</option>
                                            <option value="Pacific/Kiritimati" <?php echo e(@$getsettings->timezone == 'Pacific/Kiritimati' ? 'selected' : ''); ?>> (GMT+14:00) Kiritimati</option>
                                        </select>
                                        <?php $__errorArgs = ['timezone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group text-end">
                                    <a href="<?php echo e(url('/admin/home')); ?>" class="btn btn-outline-danger"><?php echo e(trans('labels.cancel')); ?></a>
                                    <button class="btn btn-primary" <?php if(env('Environment')=='sendbox' ): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" name="thirdparty_update" value="1" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form action="<?php echo e(URL::to('admin/settings/update')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="mt-3 mb-2">
                        <h5><i class="fa-solid fa-share-nodes"></i> <?php echo e(trans('labels.seo_settings')); ?> </h5>
                    </div>
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.og_title')); ?></label>
                                        <input type="text" class="form-control" placeholder="<?php echo e(trans('labels.og_title')); ?>" name="og_title" id="og_title" value="<?php echo e(@$getsettings->og_title == '' ? old('og_title') : @$getsettings->og_title); ?>">
                                        <?php $__errorArgs = ['og_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.og_image')); ?> (1200 x 650) </label>
                                        <input type="file" class="form-control" name="og_image" id="og_image">
                                        <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span><br> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <img src="<?php echo e(Helper::image_path(@$getsettings->og_image)); ?>" class="img-fluid rounded hw-50 mt-1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.og_description')); ?></label>
                                        <textarea class="form-control" name="og_description" placeholder="<?php echo e(trans('labels.og_description')); ?>" id="og_description" rows="6"><?php echo e(@$getsettings->og_description == '' ? old('og_description') : @$getsettings->og_description); ?></textarea>
                                        <?php $__errorArgs = ['og_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group text-end">
                                    <a href="<?php echo e(url('/admin/home')); ?>" class="btn btn-outline-danger"><?php echo e(trans('labels.cancel')); ?></a>
                                    <button class="btn btn-primary" <?php if(env('Environment')=='sendbox' ): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" name="seo_update" value="1" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


                <form action="<?php echo e(URL::to('admin/settings/update')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="mt-3 mb-2">
                        <h5><i class="fa-solid fa-bell"></i> <?php echo e(trans('labels.noti_settings')); ?> </h5>
                    </div>
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.noti_tone')); ?> (mp3 only) </label>
                                        <input type="file" class="form-control" name="noti_tune" id="noti_tune" accept="audio/mp3" required>
                                        <?php $__errorArgs = ['noti_tune'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span><br> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>


                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mt-4">
                                        <?php if($getsettings->notification_tune != ""): ?>
                                        <audio controls>
                                            <source src="<?php echo e(url(env('ASSETSPATHURL'))); ?>/admin-assets/notification/<?php echo e($getsettings->notification_tune); ?>" type="audio/mp3">
                                            <source src="<?php echo e(url(env('ASSETSPATHURL'))); ?>/admin-assets/notification/<?php echo e($getsettings->notification_tune); ?>" type="audio/mp3">
                                            Your browser does not support the audio element.
                                        </audio>
                                        <?php endif; ?>
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="form-group text-end">
                                    <a href="<?php echo e(url('/admin/home')); ?>" class="btn btn-outline-danger"><?php echo e(trans('labels.cancel')); ?></a>
                                    <button class="btn btn-primary" <?php if(env('Environment')=='sendbox' ): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" name="notification_update" value="1" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <?php if(App\Models\SystemAddons::where('unique_identifier', 'template')->first() != null && App\Models\SystemAddons::where('unique_identifier', 'template')->first()->activated == 1): ?>
                <form action="<?php echo e(URL::to('admin/settings/update')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="mt-3 mb-2">
                        <h5><i class="fa-solid fa-gears"></i> <?php echo e(trans('labels.theme_settings')); ?> </h5>
                    </div>
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 selectimg">
                                    <div class="form-group">

                                        <label class="form-label"><?php echo e(trans('labels.themes')); ?>

                                            <span class="text-danger"> * </span> </label>
                                        <div>
                                            <label for="template1" class="radio-card position-relative">
                                                <input type="radio" name="template" id="template1"  value="1" <?php echo e($getsettings->theme == 1 ? 'checked' : ''); ?>  />
                                                <div class="card-content-wrapper border rounded-2">
                                                    <span class="check-icon position-absolute"></span>
                                                    <div class="selecimg">
                                                        <img src="<?php echo e(helper::image_path('theme-' . 1 . '.png')); ?>">
                                                    </div>
                                                </div>
                                            </label>
                                            <label for="template2" class="radio-card position-relative">
                                                <input type="radio" name="template" id="template2" value="2" <?php echo e($getsettings->theme == 2 ? 'checked' : ''); ?>  />
                                                <div class="card-content-wrapper border rounded-2">
                                                    <span class="check-icon position-absolute"></span>
                                                    <div class="selecimg">
                                                        <img src="<?php echo e(helper::image_path('theme-' . 2 . '.png')); ?>">
                                                    </div>
                                                </div>
                                            </label>
                                            <label for="template3" class="radio-card position-relative">
                                                <input type="radio" name="template" id="template3" value="3" <?php echo e($getsettings->theme == 3 ? 'checked' : ''); ?>  />
                                                <div class="card-content-wrapper border rounded-2">
                                                    <span class="check-icon position-absolute"></span>
                                                    <div class="selecimg">
                                                        <img src="<?php echo e(helper::image_path('theme-' . 3 . '.png')); ?>">
                                                    </div>
                                                </div>
                                            </label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group text-end">
                                    <a href="<?php echo e(url('/admin/home')); ?>" class="btn btn-outline-danger"><?php echo e(trans('labels.cancel')); ?></a>
                                    <button class="btn btn-primary" <?php if(env('Environment')=='sendbox' ): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" name="theme_update" value="1" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <?php endif; ?>
                <form action="<?php echo e(URL::to('admin/settings/update')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="mt-3 mb-2">
                        <h5><i class="fa-solid fa-briefcase"></i> <?php echo e(trans('labels.business_settings')); ?> </h5>
                    </div>
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.currency')); ?> <span class="text-danger">*</span> </label>
                                        <input type="text" placeholder="<?php echo e(trans('labels.currency')); ?>" value="<?php echo e(@$getsettings->currency == '' ? old('currency') : @$getsettings->currency); ?>" class="form-control" name="currency" id="currency" required>
                                        <?php $__errorArgs = ['currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.currency_position')); ?> </label>
                                        <div class="d-flex">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input me-0" type="radio" name="currency_position" id="inlineRadio1" value="1" <?php echo e(@$getsettings->currency_position == 1 ? 'checked' : ''); ?> checked>
                                                <label class="form-check-label" for="inlineRadio1"><?php echo e(trans('labels.left')); ?></label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input me-0" type="radio" name="currency_position" id="inlineRadio2" value="2" <?php echo e(@$getsettings->currency_position == 2 ? 'checked' : ''); ?>>
                                                <label class="form-check-label" for="inlineRadio2"><?php echo e(trans('labels.right')); ?></label>
                                            </div>
                                            <?php $__errorArgs = ['currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.referral_amount')); ?> <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="<?php echo e(trans('labels.referral_amount')); ?>" value="<?php echo e(@$getsettings->referral_amount == '' ? old('referral_amount') : @$getsettings->referral_amount); ?>" class="form-control" name="referral_amount" id="referral_amount" required>
                                        <?php $__errorArgs = ['referral_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.max_order_qty')); ?> <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="<?php echo e(trans('labels.max_order_qty')); ?>" value="<?php echo e(@$getsettings->max_order_qty == '' ? old('max_order_qty') : @$getsettings->max_order_qty); ?>" class="form-control" name="max_order_qty" id="max_order_qty" required>
                                        <?php $__errorArgs = ['max_order_qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.min_amount')); ?> <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="<?php echo e(trans('labels.min_amount')); ?>" value="<?php echo e(@$getsettings->min_order_amount == '' ? old('min_order_amount') : @$getsettings->min_order_amount); ?>" class="form-control" name="min_order_amount" id="min_order_amount" required>
                                        <?php $__errorArgs = ['min_order_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.max_amount')); ?> <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="<?php echo e(trans('labels.max_amount')); ?>" value="<?php echo e(@$getsettings->max_order_amount == '' ? old('max_order_amount') : @$getsettings->max_order_amount); ?>" class="form-control" name="max_order_amount" id="max_order_amount" required>
                                        <?php $__errorArgs = ['max_order_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.maintenance_mode')); ?> </label>
                                        <input id="maintenance_mode-switch" type="checkbox" class="checkbox-switch" name="maintenance_mode" value="1" <?php echo e($getsettings->maintenance_mode == 1 ? 'checked' : ''); ?>>
                                        <label for="maintenance_mode-switch" class="switch">
                                            <span class="switch__circle"><span class="switch__circle-inner"></span></span>
                                            <span class="switch__left ps-2"><?php echo e(trans('labels.off')); ?></span>
                                            <span class="switch__right pe-2"><?php echo e(trans('labels.on')); ?></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.login_required')); ?> </label>
                                        <input id="login_required-switch" type="checkbox" class="checkbox-switch" name="login_required" value="1" <?php echo e($getsettings->login_required == 1 ? 'checked' : ''); ?>>
                                        <label for="login_required-switch" class="switch">
                                            <span class="switch__circle"><span class="switch__circle-inner"></span></span>
                                            <span class="switch__left ps-2"><?php echo e(trans('labels.off')); ?></span>
                                            <span class="switch__right pe-2"><?php echo e(trans('labels.on')); ?></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-form-label"
                                            for=""><?php echo e(trans('labels.pickup_delivery')); ?>

                                        </label>

                                        <select class="form-control selectpicker" name="pickup_delivery" id="pickup_delivery" data-live-search="true">
                                            <option value="1" <?php echo e($getsettings->pickup_delivery == 1 ? 'selected' : ''); ?>><?php echo e(trans('labels.both')); ?></option>
                                            <option value="2" <?php echo e($getsettings->pickup_delivery == 2 ? 'selected' : ''); ?>><?php echo e(trans('labels.delivery')); ?></option>
                                            <option value="3" <?php echo e($getsettings->pickup_delivery == 3 ? 'selected' : ''); ?>><?php echo e(trans('labels.pickup')); ?></option>
                                        </select>
                                        
                                    </div>
                                </div>                          
                            </div>


                            <div class="row">
                                <div class="form-group text-end">
                                    <a href="<?php echo e(url('/admin/home')); ?>" class="btn btn-outline-danger"><?php echo e(trans('labels.cancel')); ?></a>
                                    <button class="btn btn-primary" <?php if(env('Environment')=='sendbox' ): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" name="business_update" value="1" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form action="<?php echo e(URL::to('admin/settings/update')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="mt-3 mb-2">
                        <h5><i class="fa-solid fa-browser"></i> <?php echo e(trans('labels.website_settings')); ?> </h5>
                    </div>
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.title_for_title_bar')); ?></label>
                                        <input type="text" class="form-control" name="title" id="title" value="<?php echo e(@$getsettings->title == '' ? old('title') : @$getsettings->title); ?>" placeholder="<?php echo e(trans('labels.title_for_title_bar')); ?>">
                                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.short_title')); ?> </label>
                                        <input type="text" class="form-control" name="short_title" id="short_title" value="<?php echo e(@$getsettings->short_title == '' ? old('short_title') : @$getsettings->short_title); ?>" placeholder="<?php echo e(trans('labels.short_title')); ?>">
                                        <?php $__errorArgs = ['short_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.logo')); ?> (250 x 250) </label>
                                        <input type="file" class="form-control" name="logo" id="logo">
                                        <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span><br> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <img src="<?php echo e(Helper::image_path(@$getsettings->logo)); ?>" class="img-fluid rounded hw-50 mt-1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.Favicon')); ?> (16 x 16) </label>
                                        <input type="file" class="form-control" name="favicon" id="favicon">
                                        <?php $__errorArgs = ['favicon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span><br> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <img src="<?php echo e(Helper::image_path(@$getsettings->favicon)); ?>" class="img-fluid rounded hw-50 mt-1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.copyright')); ?> </label>
                                        <input type="text" class="form-control" name="copyright" id="copyright" value="<?php echo e(@$getsettings->copyright == '' ? old('copyright') : @$getsettings->copyright); ?>" placeholder="<?php echo e(trans('labels.copyright')); ?>">
                                        <?php $__errorArgs = ['copyright'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <hr class="divider">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.mobile_app_title')); ?></label>
                                        <input type="text" class="form-control" placeholder="<?php echo e(trans('labels.mobile_app_title')); ?>" name="mobile_app_title" id="mobile_app_title" value="<?php echo e(@$getsettings->mobile_app_title == '' ? old('mobile_app_title') : @$getsettings->mobile_app_title); ?>">
                                        <?php $__errorArgs = ['mobile_app_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.mobile_app_description')); ?></label>
                                        <textarea class="form-control" name="mobile_app_description" placeholder="<?php echo e(trans('labels.mobile_app_description')); ?>" id="mobile_app_description" rows="5"><?php echo e(@$getsettings->mobile_app_description == '' ? old('mobile_app_description') : @$getsettings->mobile_app_description); ?></textarea>
                                        <?php $__errorArgs = ['mobile_app_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.mobile_app_image')); ?> (650 x 750) </label>
                                        <input type="file" class="form-control" name="mobile_app_image" id="mobile_app_image">
                                        <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span><br> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <img src="<?php echo e(Helper::image_path(@$getsettings->mobile_app_image)); ?>" class="img-fluid rounded hw-50 mt-1">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.bg_image')); ?> (1920 x 300) </label>
                                        <input type="file" class="form-control" name="mobile_app_bg_image">
                                        <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span><br> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <img src="<?php echo e(Helper::image_path(@$getsettings->mobile_app_bg_image)); ?>" class="img-fluid rounded hw-50 mt-1">
                                    </div>
                                </div>
                                <hr class="divider">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.auth_bg_image')); ?> (1920 x 1280) </label>
                                        <input type="file" class="form-control" name="auth_bg_image" id="auth_bg_image">
                                        <?php $__errorArgs = ['auth_bg_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span><br> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <img src="<?php echo e(Helper::image_path(@$getsettings->auth_bg_image)); ?>" class="img-fluid rounded hw-50 mt-1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.breadcrumb_bg_image')); ?> (1920 x 300) </label>
                                        <input type="file" class="form-control" name="breadcrumb_bg_image" id="breadcrumb_bg_image">
                                        <?php $__errorArgs = ['breadcrumb_bg_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span><br> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <img src="<?php echo e(Helper::image_path(@$getsettings->breadcrumb_bg_image)); ?>" class="img-fluid rounded hw-50 mt-1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.booknow_bg_image')); ?> (1920 x 550) </label>
                                        <input type="file" class="form-control" name="booknow_bg_image">
                                        <?php $__errorArgs = ['booknow_bg_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span><br> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <img src="<?php echo e(Helper::image_path(@$getsettings->booknow_bg_image)); ?>" class="img-fluid rounded hw-50 mt-1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.reviews_bg_image')); ?> (1920 x 550) </label>
                                        <input type="file" class="form-control" name="reviews_bg_image">
                                        <?php $__errorArgs = ['reviews_bg_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span><br> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <img src="<?php echo e(Helper::image_path(@$getsettings->reviews_bg_image)); ?>" class="img-fluid rounded hw-50 mt-1">
                                    </div>
                                </div>
                                <hr class="divider">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.footer_title')); ?></label>
                                        <input type="text" class="form-control" placeholder="<?php echo e(trans('labels.footer_title')); ?>" name="footer_title" id="footer_title" value="<?php echo e(@$getsettings->footer_title == '' ? old('footer_title') : @$getsettings->footer_title); ?>">
                                        <?php $__errorArgs = ['footer_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.footer_description')); ?></label>
                                        <textarea class="form-control" name="footer_description" placeholder="<?php echo e(trans('labels.footer_description')); ?>" id="footer_description" rows="5"><?php echo e(@$getsettings->footer_description == '' ? old('footer_description') : @$getsettings->footer_description); ?></textarea>
                                        <?php $__errorArgs = ['footer_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.footer_logo')); ?> (250 x 250) </label>
                                        <input type="file" class="form-control" name="footer_logo" id="footer_logo">
                                        <?php $__errorArgs = ['footer_logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span><br> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <img src="<?php echo e(Helper::image_path(@$getsettings->footer_logo)); ?>" class="img-fluid rounded hw-50 mt-1">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.footer_bg_image')); ?> (1920 x 650) </label>
                                        <input type="file" class="form-control" name="footer_bg_image" id="footer_bg_image">
                                        <?php $__errorArgs = ['footer_bg_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span><br> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <img src="<?php echo e(Helper::image_path(@$getsettings->footer_bg_image)); ?>" class="img-fluid rounded hw-50 mt-1">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row justify-content-between">
                                            <label class="col-auto col-form-label" for=""><?php echo e(trans('labels.footer_features')); ?> <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="Ex. <i class='fa-solid fa-truck-fast'></i> Visit https://fontawesome.com/ for more info"> <i class="fa-solid fa-circle-info"></i> </span> </label>
                                            <?php if(count($getfooterfeatures) > 0): ?>
                                            <span class="col-auto">
                                                <button class="btn btn-sm btn-outline-info" type="button" onclick="add_features('<?php echo e(trans('labels.icon')); ?>','<?php echo e(trans('labels.title')); ?>','<?php echo e(trans('labels.description')); ?>')"> <i class="fa-sharp fa-solid fa-plus"></i> <?php echo e(trans('labels.add_new')); ?></button>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                        <?php $__empty_1 = true; $__currentLoopData = $getfooterfeatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $features): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <div class="row">
                                            <input type="hidden" name="edit_icon_key[]" value="<?php echo e($features->id); ?>">
                                            <div class="col-md-3 form-group">
                                                <div class="input-group">
                                                    <input type="text" class="form-control feature_required" onkeyup="show_feature_icon(this)" name="edi_feature_icon[<?php echo e($features->id); ?>]" placeholder="<?php echo e(trans('labels.icon')); ?>" value="<?php echo e($features->icon); ?>" required>
                                                    <p class="input-group-text"><?php echo $features->icon; ?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <input type="text" class="form-control" name="edi_feature_title[<?php echo e($features->id); ?>]" placeholder="<?php echo e(trans('labels.title')); ?>" value="<?php echo e($features->title); ?>" required>
                                            </div>
                                            <div class="col-md-5 form-group">
                                                <input type="text" class="form-control" name="edi_feature_description[<?php echo e($features->id); ?>]" placeholder="<?php echo e(trans('labels.description')); ?>" value="<?php echo e($features->description); ?>" required>
                                            </div>
                                            <div class="col-md-1 form-group">
                                                <button class="btn btn-danger" type="button" onclick="delete_features('<?php echo e(URL::to('admin/settings/delete-feature-' . $features->id)); ?>')"> <i class="fa fa-trash"></i> </button>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <div class="input-group">
                                                    <input type="text" class="form-control feature_required" onkeyup="show_feature_icon(this)" name="feature_icon[]" placeholder="<?php echo e(trans('labels.icon')); ?>">
                                                    <p class="input-group-text"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <input type="text" class="form-control feature_required" name="feature_title[]" placeholder="<?php echo e(trans('labels.title')); ?>">
                                            </div>
                                            <div class="col-md-5 form-group">
                                                <input type="text" class="form-control feature_required" name="feature_description[]" placeholder="<?php echo e(trans('labels.description')); ?>">
                                            </div>
                                            <div class="col-md-1 form-group">
                                                <button class="btn btn-info" type="button" onclick="add_features('<?php echo e(trans('labels.icon')); ?>','<?php echo e(trans('labels.title')); ?>','<?php echo e(trans('labels.description')); ?>')"> <i class="fa-sharp fa-solid fa-plus"></i> </button>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <span class="extra_footer_features"></span>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group text-end">
                                    <a href="<?php echo e(url('/admin/home')); ?>" class="btn btn-outline-danger"><?php echo e(trans('labels.cancel')); ?></a>
                                    <button class="btn btn-primary" <?php if(env('Environment')=='sendbox' ): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" name="web_update" value="1" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form action="<?php echo e(URL::to('admin/settings/update')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="mt-3 mb-2">
                        <h5><i class="fa-solid fa-mobile-notch"></i> <?php echo e(trans('labels.mobile_app_settings')); ?> </h5>
                    </div>
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.ios_app_link')); ?></label>
                                        <input type="text" class="form-control" name="ios" id="ios" value="<?php echo e(@$getsettings->ios == '' ? old('ios') : @$getsettings->ios); ?>" placeholder="<?php echo e(trans('labels.ios_app_link')); ?>">
                                        <?php $__errorArgs = ['ios'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.android_app_link')); ?></label>
                                        <input type="text" class="form-control" name="android" id="android" value="<?php echo e(@$getsettings->android == '' ? old('android') : @$getsettings->android); ?>" placeholder="<?php echo e(trans('labels.android_app_link')); ?>">
                                        <?php $__errorArgs = ['android'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.app_bottom_image')); ?> (1440 x 1600) </label>
                                        <input type="file" class="form-control" name="app_bottom_image" id="app_bottom_image">
                                        <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span><br> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <img src="<?php echo e(Helper::image_path(@$getsettings->app_bottom_image)); ?>" class="img-fluid rounded hw-50 mt-1">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group text-end">
                                    <a href="<?php echo e(url('/admin/home')); ?>" class="btn btn-outline-danger"><?php echo e(trans('labels.cancel')); ?></a>
                                    <button class="btn btn-primary" <?php if(env('Environment')=='sendbox' ): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" name="mobileapp_update" value="1" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form action="<?php echo e(URL::to('admin/settings/update')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="mt-3 mb-2">
                        <h5><i class="fa-solid fa-square-info"></i> <?php echo e(trans('labels.about_us')); ?> </h5>
                    </div>
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.about_content')); ?> </label>
                                        <textarea class="form-control" name="about_content" id="ckeditor" rows="5"><?php echo e(@$getsettings->about_content == '' ? old('about_content') : @$getsettings->about_content); ?></textarea>
                                        <?php $__errorArgs = ['about_content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group text-end">
                                    <a href="<?php echo e(url('/admin/home')); ?>" class="btn btn-outline-danger"><?php echo e(trans('labels.cancel')); ?></a>
                                    <button class="btn btn-primary" <?php if(env('Environment')=='sendbox' ): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" name="about_update" value="1" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(@Helper::appdata()->map); ?>&libraries=places&callback=initMap" async defer></script>
<script src="<?php echo e(url(env('ASSETSPATHURL').'admin-assets/assets/js/custom/settings.js')); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace('ckeditor');
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sup4foodan/app.supremeseafoodandsuya.com/resources/views/admin/cms/settings.blade.php ENDPATH**/ ?>