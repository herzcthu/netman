<!-- Ip Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ip', 'IP:') !!}
    {!! $logicalDevice->ip !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', 'Type:') !!}
    {!! $logicalDevice->type !!}
</div>

<!-- Username Field -->
<div class="form-group col-sm-6">
    {!! Form::label('username', 'Username:') !!}
    {!! $logicalDevice->username !!}
</div>

<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', 'Password:') !!}
    {!! $logicalDevice->password !!}
</div>

<!-- Os Field -->
<div class="form-group col-sm-6">
    {!! Form::label('os[name]', 'OS:') !!}
    {!! isset($logicalDevice->os['name'])?$logicalDevice->os['name']:'' !!}
</div>

<!-- Os Field -->
<div class="form-group col-sm-6">
    {!! Form::label('os[version]', 'OS Version:') !!}
    {!! isset($logicalDevice->os['version'])?$logicalDevice->os['version']:'' !!}
</div>

<!-- Service Field -->
<div class="form-group col-sm-6">
    {!! Form::label('service', 'Service:') !!}
    <p>{!! $logicalDevice->service !!}</p>
</div>

<!-- Physicaldevice Field -->
<div class="form-group col-sm-6">
    {!! Form::label('device', 'Physical Device:') !!}
    <p>{!! $logicalDevice->device !!}</p>
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
            @if(is_array($logicalDevice->nicinfo))
                @foreach($logicalDevice->nicinfo as $ifname => $info)
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

<!-- Note Field -->
<div class="form-group col-sm-12">
    @if(!empty($logicalDevice->note))
    {!! Form::label('note', 'Note:') !!}
    
    <div class="jumbotron">
    <p>{!! $logicalDevice->note !!}</p>
    </div>
    @endif
</div>

