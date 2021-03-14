{{--@if($customFields)--}}
{{--<h5 class="col-12 pb-4">{!! trans('lang.main_fields') !!}</h5>--}}
{{--@endif--}}
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
    <!-- Name  Field -->
    <div class="form-group row ">
        {!! Form::label('timeslot', trans("lang.delivery_time_slot_name"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('timeslot', null,  ['class' => 'form-control','placeholder'=>  trans("lang.delivery_time_slot_name_placeholder")]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.delivery_time_slot_name_help") }}
            </div>

        </div>
    </div>

    <!-- 'Boolean Enabled Field' -->
    <div class="form-group row ">
        {!! Form::label('status', trans("lang.delivery_time_slot_status"),['class' => 'col-3 control-label text-right']) !!}
        <div class="checkbox icheck">
            <label class="col-9 ml-2 form-check-inline">
                {!! Form::hidden('status', 0) !!}
                {!! Form::checkbox('status', 1, null) !!}
            </label>
        </div>
    </div>
{{--    <div class="form-group row">--}}
{{--        {!! Form::label('status', 'status',['class' => 'col-3 control-label text-right']) !!}--}}
{{--        <div class="col-9 icheck-{{setting('theme_color')}}">--}}
{{--            {!! Form::hidden('status', 0) !!}--}}
{{--            {!! Form::checkbox('status', 1, null) !!}--}}
{{--            <label for="status"></label>--}}
{{--        </div>--}}
{{--    </div>--}}

</div>

<!-- Submit Field -->
<div class="form-group col-12 text-right">
    <button type="submit" class="btn btn-{{setting('theme_color')}}"><i
                class="fa fa-save"></i> {{trans('lang.save')}} {{trans('lang.delivery_time_slot')}}</button>
    <a href="{!! route('deliverytimeslot.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{trans('lang.cancel')}}
    </a>
</div>
