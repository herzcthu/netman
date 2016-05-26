@extends('layouts.app')

@section('content')
   <section class="content-header">
           <h1>
               LogicalDevice
           </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">

           <div class="box-body">
               <div class="row">
                   {!! Form::model($logicalDevice, ['route' => ['logicalDevices.update', $logicalDevice->ip], 'method' => 'patch']) !!}

                    @include('logicalDevices.editfields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection