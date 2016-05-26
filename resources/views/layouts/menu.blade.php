<li class="{{ Request::is('users*') ? 'active' : '' }}">
    <a href="{!! route('users.index') !!}"><i class="fa fa-edit"></i><span>Users</span></a>
</li>

<li class="{{ Request::is('devices*') ? 'active' : '' }}">
    <a href="{!! route('devices.index') !!}"><i class="fa fa-edit"></i><span>Devices</span></a>
</li>

<li class="{{ Request::is('logicalDevices*') ? 'active' : '' }}">
    <a href="{!! route('logicalDevices.index') !!}"><i class="fa fa-edit"></i><span>LogicalDevices</span></a>
</li>

