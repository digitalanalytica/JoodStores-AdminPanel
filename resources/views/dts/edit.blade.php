@extends('layouts.app')
@push('css_lib')
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- select2 -->
    <link rel="stylesheet" href="{{asset('plugins/select2/select2.min.css')}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">
    {{--dropzone--}}
    <link rel="stylesheet" href="{{asset('plugins/dropzone/bootstrap.min.css')}}">
@endpush
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{trans('lang.delivery_time_slot_plural')}} <small>{{trans('lang.delivery_time_slot_desc')}}</small></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> {{trans('lang.dashboard')}}</a></li>
                        <li class="breadcrumb-item"><a href="{!! route('deliverytimeslot.index') !!}">{{trans('lang.delivery_time_slot_plural')}}</a>
                        </li>
                        <li class="breadcrumb-item active">{{trans('lang.delivery_time_slot_edit')}}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="content">
        <div class="clearfix"></div>
        @include('flash::message')
        @include('adminlte-templates::common.errors')
        <div class="clearfix"></div>
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                    @can('deliverytimeslot.index')
                        <li class="nav-item">
                            <a class="nav-link" href="{!! route('deliverytimeslot.index') !!}"><i class="fa fa-list mr-2"></i>{{trans('lang.delivery_time_slot_table')}}</a>
                        </li>
                    @endcan
                    @can('deliverytimeslot.create')
                        <li class="nav-item">
                            <a class="nav-link" href="{!! route('deliverytimeslot.create') !!}"><i class="fa fa-plus mr-2"></i>{{trans('lang.delivery_time_slot_create')}}</a>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-pencil mr-2"></i>{{trans('lang.delivery_time_slot_edit')}}</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                {!! Form::model($dts, ['route' => ['deliverytimeslot.update', $dts->id], 'method' => 'patch']) !!}
                <div class="row">
                    @include('dts.fields')
                </div>
                {!! Form::close() !!}
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    @include('layouts.media_modal')
@endsection
@push('scripts_lib')
    <!-- select2 -->
    <script src="{{asset('plugins/select2/select2.min.js')}}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
    {{--dropzone--}}
    <script src="{{asset('plugins/dropzone/dropzone.js')}}"></script>
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        var dropzoneFields = [];
    </script>
@endpush