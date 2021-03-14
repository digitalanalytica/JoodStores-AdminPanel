<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
<!-- Name Field -->
<div class="form-group row ">
  {!! Form::label('country_name', trans("lang.country_name"), ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    {!! Form::text('country_name', null,  ['class' => 'form-control','placeholder'=>  trans("lang.country_name_placeholder")]) !!}
    <div class="form-text text-muted">
      {{ trans("lang.country_name_help") }}
    </div>
  </div>
</div>

<!-- Description Field -->
<div class="form-group row ">
  {!! Form::label('country_description', trans("lang.country_description"), ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    {!! Form::textarea('country_description', null, ['class' => 'form-control','placeholder'=>
     trans("lang.country_description_placeholder")  ]) !!}
    <div class="form-text text-muted">{{ trans("lang.country_description_help") }}</div>
  </div>
</div>
</div>
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">

{{--<!-- Image Field -->--}}
{{--<div class="form-group row">--}}
{{--  {!! Form::label('image', trans("lang.country_image"), ['class' => 'col-3 control-label text-right']) !!}--}}
{{--  <div class="col-9">--}}
{{--    <div style="width: 100%" class="dropzone image" id="image" data-field="image">--}}
{{--      <input type="hidden" name="image">--}}
{{--    </div>--}}
{{--    <a href="#loadMediaModal" data-dropzone="image" data-toggle="modal" data-target="#mediaModal" class="btn btn-outline-{{setting('theme_color','primary')}} btn-sm float-right mt-1">{{ trans('lang.media_select')}}</a>--}}
{{--    <div class="form-text text-muted w-50">--}}
{{--      {{ trans("lang.country_image_help") }}--}}
{{--    </div>--}}
{{--  </div>--}}
{{--</div>--}}
{{--  @prepend('scripts')--}}
{{--    <script type="text/javascript">--}}
{{--      var var15671147011688676454ble = '';--}}
{{--      @if(isset($country) && $country->hasMedia('image'))--}}
{{--              var15671147011688676454ble = {--}}
{{--        name: "{!! $country->getFirstMedia('image')->name !!}",--}}
{{--        size: "{!! $country->getFirstMedia('image')->size !!}",--}}
{{--        type: "{!! $country->getFirstMedia('image')->mime_type !!}",--}}
{{--        collection_name: "{!! $country->getFirstMedia('image')->collection_name !!}"--}}
{{--      };--}}
{{--      @endif--}}
{{--      var dz_var15671147011688676454ble = $(".dropzone.image").dropzone({--}}
{{--        url: "{!!url('uploads/store')!!}",--}}
{{--        addRemoveLinks: true,--}}
{{--        maxFiles: 1,--}}
{{--        init: function () {--}}
{{--          @if(isset($country) && $country->hasMedia('image'))--}}
{{--          dzInit(this, var15671147011688676454ble, '{!! url($country->getFirstMediaUrl('image','thumb')) !!}')--}}
{{--          @endif--}}
{{--        },--}}
{{--        accept: function (file, done) {--}}
{{--          dzAccept(file, done, this.element, "{!!config('medialibrary.icons_folder')!!}");--}}
{{--        },--}}
{{--        sending: function (file, xhr, formData) {--}}
{{--          dzSending(this, file, formData, '{!! csrf_token() !!}');--}}
{{--        },--}}
{{--        maxfilesexceeded: function (file) {--}}
{{--          dz_var15671147011688676454ble[0].mockFile = '';--}}
{{--          dzMaxfile(this, file);--}}
{{--        },--}}
{{--        complete: function (file) {--}}
{{--          dzComplete(this, file, var15671147011688676454ble, dz_var15671147011688676454ble[0].mockFile);--}}
{{--          dz_var15671147011688676454ble[0].mockFile = file;--}}
{{--        },--}}
{{--        removedfile: function (file) {--}}
{{--          dzRemoveFile(--}}
{{--                  file, var15671147011688676454ble, '{!! url("country/remove-media") !!}',--}}
{{--                  'image', '{!! isset($country) ? $country->id : 0 !!}', '{!! url("uplaods/clear") !!}', '{!! csrf_token() !!}'--}}
{{--          );--}}
{{--        }--}}
{{--      });--}}
{{--      dz_var15671147011688676454ble[0].mockFile = var15671147011688676454ble;--}}
{{--      dropzoneFields['image'] = dz_var15671147011688676454ble;--}}
{{--    </script>--}}
{{--  @endprepend--}}
{{--</div>--}}

<!-- Submit Field -->
<div class="form-group col-12 text-right">
  <button type="submit" class="btn btn-{{setting('theme_color')}}" ><i class="fa fa-save"></i> {{trans('lang.save')}} {{trans('lang.country')}}</button>
  <a href="{!! route('country.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{trans('lang.cancel')}}</a>
</div>
