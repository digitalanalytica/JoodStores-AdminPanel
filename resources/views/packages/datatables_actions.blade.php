<div class='btn-group btn-group-sm'>
{{--  @can('package.create')--}}
{{--  <a data-toggle="tooltip" data-placement="bottom" title="{{trans('lang.view_details')}}" href="{{ route('package.show', $id) }}" class='btn btn-link'>--}}
{{--    <i class="fa fa-eye"></i>--}}
{{--  </a>--}}
{{--  @endcan--}}

  @can('package.edit')
  <a data-toggle="tooltip" data-placement="bottom" title="{{trans('lang.package_edit')}}" href="{{ route('package.edit', $id) }}" class='btn btn-link'>
    <i class="fa fa-edit"></i>
  </a>
  @endcan

  @can('package.destroy')
{!! Form::open(['route' => ['package.destroy', $id], 'method' => 'delete']) !!}
  {!! Form::button('<i class="fa fa-trash"></i>', [
  'type' => 'submit',
  'class' => 'btn btn-link text-danger',
  'onclick' => "return confirm('Are you sure?')"
  ]) !!}
{!! Form::close() !!}
  @endcan
</div>
