<!-- Ip Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ip', 'IP:') !!}
    {!! $device->ip !!}
</div>

<!-- Deviceid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('deviceid', 'Device ID:') !!}
    {!! $device->deviceid !!}
</div>

<!-- Os Field -->
<div class="form-group col-sm-6">
    {!! Form::label('os[name]', 'OS:') !!}
    {!! isset($device->os['name'])?$device->os['name']:'' !!}
</div>

<!-- Os Field -->
<div class="form-group col-sm-6">
    {!! Form::label('os[version]', 'OS Version:') !!}
    {!! isset($device->os['version'])?$device->os['version']:'' !!}
</div>

<!-- Rack Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rack', 'Rack:') !!}
    {!! $device->rack !!}
</div>

<!-- Vendor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('vendor', 'Vendor:') !!}
    {!! $device->vendor !!}
</div>

<!-- Username Field -->
<div class="form-group col-sm-6">
    {!! Form::label('username', 'Username:') !!}
    {!! $device->username !!}
</div>

<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', 'Password:') !!}
    {!! $device->password !!}
</div>

<!-- Nicinfo Field -->
<div class="form-group col-sm-12">
    {!! Form::label('nicinfo', 'Nicinfo:') !!}
    <table class="table table-striped table-bordered" id="table">
        <thead class="no-border">
        <tr>
            <th>Interface Name</th>
            <th>Mac Address</th>
            <th>Private IP</th>
            <th>Public IP</th>
        </tr>
        </thead>
        <tbody id="container" class="no-border-x no-border-y ui-sortable">
            @if(is_array($device->nicinfo))
                @foreach($device->nicinfo as $ifname => $info)
                <tr>
                    <td>{!! $ifname !!}</td>
                    <td>{!! $info['macaddr'] !!}</td>
                    <td>{!! $info['lanip'] !!}</td>
                    <td>{!! $info['wanip'] !!}</td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

