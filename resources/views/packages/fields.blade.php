{{--@if($customFields)--}}
{{--<h5 class="col-12 pb-4">{!! trans('lang.main_fields') !!}</h5>--}}
{{--@endif--}}
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
    <!-- Name  Field -->
    <div class="form-group row ">
        {!! Form::label('name', trans("lang.package_name"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('name', null,  ['class' => 'form-control','placeholder'=>  trans("lang.package_name_placeholder")]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.package_name_help") }}
            </div>
        </div>
    </div>

    <!-- Name  Field -->
    <div class="form-group row ">
        {!! Form::label('name_ar', trans("lang.package_name_ar"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('name_ar', null,  ['class' => 'form-control','placeholder'=>  trans("lang.package_name_ar_placeholder")]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.package_name_ar_help") }}
            </div>

        </div>
    </div>
    <!-- Monthly price Field -->
    <div class="form-group row ">
        {!! Form::label('monthly_price', trans('lang.package_monthly_price'), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::number('monthly_price', null,  ['class' => 'form-control','placeholder'=>  trans("lang.package_monthly_price_placeholder"),'step'=>"any", 'min'=>"0"]) !!}
            <div class="form-text text-muted">
                {!! trans("lang.package_monthly_price_help")   !!}
            </div>
        </div>
    </div>

    <!-- 6 Month price Field -->
    <div class="form-group row ">
        {!! Form::label('six_month_price', trans('lang.package_six_month_price'), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::number('six_month_price', null,  ['class' => 'form-control','placeholder'=>  trans("lang.package_six_month_price_placeholder")  ]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.package_six_month_price_help") }}
            </div>
        </div>
    </div>

    <!-- 1 year price Field -->
    <div class="form-group row ">
        {!! Form::label('one_year_price', trans('lang.package_one_year_price'), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::number('one_year_price', null,  ['class' => 'form-control','placeholder'=>  trans("lang.package_one_year_price_placeholder")  ]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.package_one_year_price_help") }}
            </div>
        </div>
    </div>

    <!-- Number of ads Field -->
    <div class="form-group row ">
        {!! Form::label('number_of_ads', trans('lang.package_number_of_ads'), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::number('number_of_ads', null,  ['class' => 'form-control','placeholder'=>  trans("lang.package_number_of_ads_placeholder")  ]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.package_number_of_ads_help") }}
            </div>
        </div>
    </div>
    <!-- 'Boolean Enabled Field' -->
    <div class="form-group row ">
        {!! Form::label('status', trans("lang.package_status"),['class' => 'col-3 control-label text-right']) !!}
        <div class="checkbox icheck">
            <label class="col-9 ml-2 form-check-inline">
                {!! Form::hidden('status', 0) !!}
                {!! Form::checkbox('status', 1, null) !!}
            </label>
        </div>
    </div>
</div>
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
    <!-- Description Field -->
    <div class="form-group row ">
        {!! Form::label('description', trans("lang.package_description"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::textarea('description', null, ['class' => 'form-control','placeholder'=>
            trans("lang.package_description_placeholder")  ]) !!}
            <div class="form-text text-muted">{!! trans("lang.Package_description_help") !!}</div>
        </div>
    </div>
    <!--Arabic Description Field -->
    <div class="form-group row ">
        {!! Form::label('description_ar', trans("lang.market_description_ar"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::textarea('description_ar', null, ['class' => 'form-control','placeholder'=>
            trans("lang.market_description_ar_placeholder")  ]) !!}
            <div class="form-text text-muted">{{ trans("lang.market_description_ar_help") }}</div>
        </div>
    </div>
</div>
<!-- Submit Field -->
<div class="form-group col-12 text-right">
    <button type="submit" class="btn btn-{{setting('theme_color')}}"><i
                class="fa fa-save"></i> {{trans('lang.save')}} {{trans('lang.package')}}</button>
    <a href="{!! route('package.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{trans('lang.cancel')}}
    </a>
</div>
