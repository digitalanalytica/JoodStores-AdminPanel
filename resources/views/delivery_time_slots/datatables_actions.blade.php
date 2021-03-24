<div class='btn-group btn-group-sm'>
  @can('deliverytimeslot.edit')
  <a data-toggle="tooltip" data-placement="bottom" title="{{trans('lang.delivery_time_slot_edit')}}" href="{{ route('deliverytimeslots.edit', $id) }}" class='btn btn-link'>
    <i class="fa fa-edit"></i>
  </a>
  @endcan

  @can('deliverytimeslot.destroy')
{!! Form::open(['route' => ['deliverytimeslots.destroy', $id], 'method' => 'delete']) !!}
  {!! Form::button('<i class="fa fa-trash"></i>', [
  'type' => 'submit',
  'class' => 'btn btn-link text-danger',
  'onclick' => "return confirm('Are you sure?')"
  ]) !!}
{!! Form::close() !!}
  @endcan
</div>
