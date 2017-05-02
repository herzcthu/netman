<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'Phone:') !!}
    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
</div>

<!-- Server Field -->
<div class="form-group col-sm-6">
    {!! Form::label('server', 'Server:') !!}
    {!! Form::text('server', null, ['class' => 'form-control']) !!}
</div>

<!-- Service Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('service_type', 'Service Type:') !!}
    {!! Form::text('service_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Remark Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('remark', 'Remark:') !!}
    {!! Form::textarea('remark', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('phoneLists.index') !!}" class="btn btn-default">Cancel</a>
</div>
