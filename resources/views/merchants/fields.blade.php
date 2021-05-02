<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
    <!-- Full Name Field -->
    <div class="form-group row">
        {!! Form::label('full_name', trans("lang.merchant_name"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('full_name', null,  ['class' => 'form-control','placeholder'=>  trans("lang.merchant_name_placeholder")]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.merchant_name_help") }}
            </div>
        </div>
    </div>
    <!-- Name Field -->
    <div class="form-group row">
        {!! Form::label('shop_name', trans("lang.merchant_shop_name"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('shop_name', null,  ['class' => 'form-control','placeholder'=>  trans("lang.merchant_shop_name_placeholder")]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.merchant_name_help") }}
            </div>
        </div>
    </div>

    <!-- Email Field -->
    <div class="form-group row">
        {!! Form::label('email', trans("lang.merchant_email"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::email('email', null,  ['class' => 'form-control','placeholder'=>  trans("lang.merchant_email_placeholder")]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.merchant_email_help") }}
            </div>
        </div>
    </div>

    <!-- Phone Field -->
    <div class="form-group row ">
        {!! Form::label('phone', trans("lang.merchant_phone"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('phone', null,  ['class' => 'form-control','placeholder'=>  trans("lang.merchant_phone_placeholder")]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.merchant_phone_help") }}
            </div>
        </div>
    </div>
</div>
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
    <!-- Image Field -->
    <div class="form-group row">
        {!! Form::label('image_id', trans("lang.merchant_image_id"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            <div style="width: 100%" class="dropzone image_id" id="image" data-field="image">
                <input type="hidden" name="image_id">
            </div>
            <a href="#loadMediaModalID" data-dropzone="image_id" data-toggle="modal" data-target="#mediaModal"
               class="btn btn-outline-{{setting('theme_color','primary')}} btn-sm float-right mt-1">{{ trans('lang.media_select')}}</a>
            <div class="form-text text-muted w-50">
                {{ trans("lang.field_image_help") }}
            </div>
        </div>
    </div>
</div>
@prepend('scripts')
    <script type="text/javascript">
        var var15866134631720934041ble = '';
        @if(isset($merchant) && $merchant->hasMedia('image_id'))
            var15866134631720934041ble = {
            name: "{!! $merchant->getFirstMedia('image_id')->name !!}",
            size: "{!! $merchant->getFirstMedia('image_id')->size !!}",
            type: "{!! $merchant->getFirstMedia('image_id')->mime_type !!}",
            collection_name: "{!! $merchant->getFirstMedia('image_id')->collection_name !!}"
        };
        @endif
        var dz_var15866134631720934041ble = $(".dropzone.image_id").dropzone({
            url: "{!!url('uploads/store')!!}",
            addRemoveLinks: true,
            maxFiles: 1,
            init: function () {
                @if(isset($merchant) && $merchant->hasMedia('image_id'))
                dzInit(this, var15866134631720934041ble, '{!! url($merchant->getFirstMediaUrl('image_id','thumb')) !!}')
                @endif
            },
            accept: function (file, done) {
                dzAccept(file, done, this.element, "{!!config('medialibrary.icons_folder')!!}");
            },
            sending: function (file, xhr, formData) {
                dzSending(this, file, formData, '{!! csrf_token() !!}');
            },
            maxfilesexceeded: function (file) {
                dz_var15866134631720934041ble[0].mockFile = '';
                dzMaxfile(this, file);
            },
            complete: function (file) {
                dzComplete(this, file, var15866134631720934041ble, dz_var15866134631720934041ble[0].mockFile);
                dz_var15866134631720934041ble[0].mockFile = file;
            },
            removedfile: function (file) {
                dzRemoveFile(
                    file, var15866134631720934041ble, '{!! url("merchants/remove-media") !!}',
                    'image_id', '{!! isset($merchant) ? $merchant->id : 0 !!}', '{!! url("uplaods/clear") !!}', '{!! csrf_token() !!}'
                );
            }
        });
        dz_var15866134631720934041ble[0].mockFile = var15866134631720934041ble;
        dropzoneFields['image_id'] = dz_var15866134631720934041ble;
    </script>
@endprepend

<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
    <!-- Image Field -->
    <div class="form-group row">
        {!! Form::label('image_cr', trans("lang.merchant_image_cr"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            <div style="width: 100%" class="dropzone image_cr" id="image_cr" data-field="image">
                <input type="hidden" name="image_cr">
            </div>
            <a href="#loadMediaModal" data-dropzone="image_cr" data-toggle="modal" data-target="#mediaModal"
               class="btn btn-outline-{{setting('theme_color','primary')}} btn-sm float-right mt-1">{{ trans('lang.media_select')}}</a>
            <div class="form-text text-muted w-50">
                {{ trans("lang.field_image_help") }}
            </div>
        </div>
    </div>
</div>
@prepend('scripts')
    <script type="text/javascript">
        var var15866134631720934041ble = '';
        @if(isset($merchant) && $merchant->hasMedia('image_cr'))
            var15866134631720934041ble = {
            name: "{!! $merchant->getFirstMedia('image_cr')->name !!}",
            size: "{!! $merchant->getFirstMedia('image_cr')->size !!}",
            type: "{!! $merchant->getFirstMedia('image_cr')->mime_type !!}",
            collection_name: "{!! $merchant->getFirstMedia('image_cr')->collection_name !!}"
        };
        @endif
        var dz_var15866134631720934041ble = $(".dropzone.image_cr").dropzone({
            url: "{!!url('uploads/store')!!}",
            addRemoveLinks: true,
            maxFiles: 1,
            init: function () {
                @if(isset($merchant) && $merchant->hasMedia('image_cr'))
                dzInit(this, var15866134631720934041ble, '{!! url($merchant->getFirstMediaUrl('image_cr','thumb')) !!}')
                @endif
            },
            accept: function (file, done) {
                dzAccept(file, done, this.element, "{!!config('medialibrary.icons_folder')!!}");
            },
            sending: function (file, xhr, formData) {
                dzSending(this, file, formData, '{!! csrf_token() !!}');
            },
            maxfilesexceeded: function (file) {
                dz_var15866134631720934041ble[0].mockFile = '';
                dzMaxfile(this, file);
            },
            complete: function (file) {
                dzComplete(this, file, var15866134631720934041ble, dz_var15866134631720934041ble[0].mockFile);
                dz_var15866134631720934041ble[0].mockFile = file;
            },
            removedfile: function (file) {
                dzRemoveFile(
                    file, var15866134631720934041ble, '{!! url("merchants/remove-media") !!}',
                    'image_cr', '{!! isset($merchant) ? $merchant->id : 0 !!}', '{!! url("uplaods/clear") !!}', '{!! csrf_token() !!}'
                );
            }
        });
        dz_var15866134631720934041ble[0].mockFile = var15866134631720934041ble;
        dropzoneFields['image_cr'] = dz_var15866134631720934041ble;
    </script>
@endprepend
<!-- Submit Field -->
<div class="form-group col-12 text-right">
    <button type="submit" class="btn btn-{{setting('theme_color')}}"><i
                class="fa fa-save"></i> {{trans('lang.save')}} {{trans('lang.merchant')}}</button>
    <a href="{!! route('merchants.index') !!}" class="btn btn-default"><i
                class="fa fa-undo"></i> {{trans('lang.cancel')}}
    </a>
</div>
