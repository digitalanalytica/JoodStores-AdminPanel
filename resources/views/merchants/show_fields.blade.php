<!-- Id Field -->
<div class="form-group row col-6">
  {!! Form::label('id', 'Id:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $merchant->id !!}</p>
  </div>
</div>

<!-- Name Field -->
<div class="form-group row col-6">
  {!! Form::label('full_name', trans('lang.merchant_name'), ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $merchant->full_name !!}</p>
  </div>
</div>
<!-- Name Field -->
<div class="form-group row col-6">
  {!! Form::label('package_id', trans('lang.package'), ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $package !!}</p>
  </div>
</div>

<!-- Shop name Field -->
<div class="form-group row col-6">
  {!! Form::label('shop_name', trans('lang.merchant_shop_name'), ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $merchant->shop_name !!}</p>
  </div>
</div>

<!-- Shop name Field -->
<div class="form-group row col-6">
  {!! Form::label('email', trans('lang.merchant_email'), ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $merchant->email !!}</p>
  </div>
</div>


<!-- Image Field -->
<div class="form-group row col-6">
  {!! Form::label('image_id', 'Image:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $merchant->image_id !!}</p>
  </div>
</div>

<!-- Phone Field -->
<div class="form-group row col-6">
  {!! Form::label('phone', 'Phone:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $merchant->phone !!}</p>
  </div>
</div>


<!-- Created At Field -->
<div class="form-group row col-6">
  {!! Form::label('created_at', 'Created At:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $merchant->created_at !!}</p>
  </div>
</div>

<!-- Updated At Field -->
<div class="form-group row col-6">
  {!! Form::label('updated_at', 'Updated At:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $merchant->updated_at !!}</p>
  </div>
</div>

