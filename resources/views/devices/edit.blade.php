@extends('layouts.app')

@section('content')
   <section class="content-header">
           <h1>
               Device
           </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">

           <div class="box-body">
               <div class="row">
                   {!! Form::model($device, ['route' => ['devices.update', $device->ip], 'method' => 'patch', 'id' => 'devices']) !!}

                    @include('devices.editfields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection