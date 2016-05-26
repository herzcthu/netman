<!-- Ip Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ip', 'IP:') !!}
    {!! Form::text('ip', null, ['class' => 'form-control']) !!}
</div>

<!-- Deviceid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('deviceid', 'Device ID:') !!}
    {!! Form::number('deviceid', null, ['class' => 'form-control']) !!}
</div>

<!-- Os Field -->
<div class="form-group col-sm-6">
    {!! Form::label('os[name]', 'OS:') !!}
    {!! Form::text('os[name]', null, ['class' => 'form-control']) !!}
</div>

<!-- Os Field -->
<div class="form-group col-sm-6">
    {!! Form::label('os[version]', 'OS Version:') !!}
    {!! Form::text('os[version]', null, ['class' => 'form-control']) !!}
</div>

<!-- Rack Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rack', 'Rack:') !!}
    {!! Form::number('rack', null, ['class' => 'form-control']) !!}
</div>

<!-- Vendor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('vendor', 'Vendor:') !!}
    {!! Form::text('vendor', null, ['class' => 'form-control']) !!}
</div>

<!-- Username Field -->
<div class="form-group col-sm-6">
    {!! Form::label('username', 'Username:') !!}
    {!! Form::text('username', null, ['class' => 'form-control']) !!}
</div>

<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', 'Password:') !!}
    {!! Form::text('password', null, ['class' => 'form-control']) !!}
</div>

<!-- Nicinfo Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('nicinfo', 'NIC Info:') !!}
    <button type="button" class="btn btn-sm btn-success btn-flat btn-green" id="btnAdd"> Add NIC</button>
    <table class="table table-striped table-bordered" id="table">
        <thead class="no-border">
        <tr>
            <th>Interface Name</th>
            <th>Mac Address</th>
            <th>Private IP</th>
            <th>Public IP</th>
            <th></th>
        </tr>
        </thead>
        <tbody id="container" class="no-border-x no-border-y ui-sortable">
            @if(is_array($device->nicinfo))
                @foreach($device->nicinfo as $ifname => $info)
                <tr class="item" style="display: table-row;">
                    <td style="vertical-align: middle">
                        <input value="{!! $ifname !!}" style="width: 100%" required="" class="form-control ifname" type="text">
                    </td>
                    <td style="vertical-align: middle">
                        <input value="{!! $info['macaddr'] !!}" class="form-control macaddr" type="text">
                    </td>
                    <td style="vertical-align: middle">
                        <input value="{!! $info['lanip'] !!}" class="form-control lanip" type="text">
                    </td>
                    <td style="vertical-align: middle">
                        <input value="{!! $info['wanip'] !!}" class="form-control wanip" type="text">
                    </td>
                    <td style="vertical-align: middle">
                        <i onclick="removeItem(this)" class="remove fa fa-trash-o" style="cursor: pointer;font-size: 20px;color: red"></i>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('devices.index') !!}" class="btn btn-default">Cancel</a>
</div>

@push('scripts')
<script type='text/javascript'>
$(document).ready(function () {
            var htmlStr =   '<tr class="item" style="display: table-row;"><td style="vertical-align: middle">';
                htmlStr +=  '<input type="text" style="width: 100%" required class="form-control ifname"/>';
                htmlStr +=  '</td>';
                htmlStr +=  '<td style="vertical-align: middle">';
                htmlStr +=  '<input type="text" class="form-control macaddr"/>';
                htmlStr +=  '</td>';
                htmlStr +=  '<td style="vertical-align: middle">';
                htmlStr +=  '<input type="text" class="form-control lanip"/>';
                htmlStr +=  '</td>';
                htmlStr +=  '<td style="vertical-align: middle">';
                htmlStr +=  '<input type="text" class="form-control wanip"/>';
                htmlStr +=  '</td>';
                htmlStr +=  '<td style="vertical-align: middle">';
                htmlStr +=  '<i onclick="removeItem(this)" class="remove fa fa-trash-o" style="cursor: pointer;font-size: 20px;color: red"></i>';
                htmlStr +=  '</td>';
                htmlStr +=  '</tr>';

            $("#btnAdd").on("click", function () {
                var item = $(htmlStr).clone();
                $("#container").append(item);
            });
            
            $("#devices").on("submit", function() {
                $('.item').each(function () {
                    var ifname = $(this).find('.ifname').val();
                    $(this).find('.ifname').attr('name','nicinfo['+ifname+'][ifname]');
                    $(this).find('.macaddr').attr('name','nicinfo['+ifname+'][macaddr]');
                    $(this).find('.lanip').attr('name','nicinfo['+ifname+'][lanip]');
                    $(this).find('.wanip').attr('name','nicinfo['+ifname+'][wanip]');
                });
            });
        });
function removeItem(e) {
    e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
}
</script>
@endpush