@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            PhoneList
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                  @include('phoneLists.show_fields')
                  <a href="{!! route('phoneLists.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
