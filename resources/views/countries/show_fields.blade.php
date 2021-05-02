<!-- Id Field -->
<div class="form-group row col-6">
  {!! Form::label('id', 'Id:', ['class' => 'col-3 text-right']) !!}
  <div class="col-9">
    <p>{!! $country->id !!}</p>
  </div>
</div>

<!-- Name Field -->
<div class="form-group row col-6">
  {!! Form::label('country_name', 'Name:', ['class' => 'col-3  text-right']) !!}
  <div class="col-9">
    <p>{!! $country->country_name !!}</p>
  </div>
</div>

<!-- Description Field -->
<div class="form-group row col-6">
  {!! Form::label('country_description', 'Description:', ['class' => 'col-3  text-right']) !!}
  <div class="col-9">
    <p>{!! $country->country_description !!}</p>
  </div>
</div>


