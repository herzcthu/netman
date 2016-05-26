@extends('layouts.app')

@push('scripts')
<script type='text/javascript'>
$(document).ready(function () {
    
    $('#generate').submit(function(e){
        e.preventDefault();
        var target = $('#target').val();
        $('.progress').show();
        $('.progress-bar').css('width', '1%').attr('aria-valuenow', 1);
        $.ajax({
          method: "GET",
          url: "{!! route('devices.generate') !!}",
          xhrFields: {
                        onprogress: function(e) {
                            response = e.target.responseText;
                            //console.log("'"+response+"'");
                            console.log(JSON.parse('{'+response+'"}'));

                            r=JSON.parse('{'+response+'"}');

                            var pct = (r.progress.length / r.total) * 100;

                            $('.progress-bar').css('width', pct+'%').attr('aria-valuenow', pct);
                            $('.progress').removeClass('hide');
                        }
                    },
          beforeSend: function () { 
                        $("#genbtn").hide();$("#loading").removeClass('hide');                        
                        $('.progress').show();
                    },
          complete: function () { 
              $("#loading").addClass('hide');$("#genbtn").show();
              $('.progress').delay( 1000 ).fadeOut(); 
              $('.progress-bar').css('width', '100%').attr('aria-valuenow', 100);
              $( ".buttons-reload" ).trigger( "click" );
          },
          data: { target: target }
        })
          .success(function( msg ) {
            
          })
                  .done(function(data){
                      
                  });
    });
});
</script>
@endpush
@section('content')
    <section class="content-header">
        <h1 class="pull-left">Devices </h1>
        <h1 class="pull-right form-inline">
            {!! Form::open(['method' => 'get', 'id'=>'generate']) !!}
            <input style="margin-top: -10px;margin-bottom: 5px" class="form-control" type="text" id="target"></input> 
            <img style="margin-top: -10px;margin-bottom: 5px;width:30px;height:30px;" src="{!!asset('img/loading.gif')!!}" id="loading" class="img-circle hide" alt="Generating..."/>
            <button id="genbtn" style="margin-top: -10px;margin-bottom: 5px" class="btn btn-primary" type="submit"> generate</button>            
            
            <a class="btn btn-primary" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('devices.create') !!}">Add New</a>
            {!! Form::close() !!}
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <div class="progress progress-striped active" style="display: none;">
                    <div class="progress-bar"  role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
                    @include('devices.table')
            </div>
        </div>
    </div>
@endsection