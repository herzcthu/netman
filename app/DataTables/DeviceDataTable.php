<?php

namespace App\DataTables;

use App\Models\Device;
use Form;
use Yajra\Datatables\Services\DataTable;

class DeviceDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query()->orderByRaw('LENGTH(ip),ip ASC'))
            ->editColumn('nicinfo', function ($data) {
                if(!empty($data->nicinfo)){
                $nicinfo = '<ul class="list-group">';
                foreach($data->nicinfo as $ifname => $info){
                    if(!empty($info['macaddr'])){
                    $nicinfo .= '<li class="list-group-item"><span class="badge">'.$ifname.'</span> Mac Address : '.$info['macaddr'].'</li>';
                    }
                    if(!empty($info['lanip'])){
                    $nicinfo .= '<li class="list-group-item"><span class="badge">'.$ifname.'</span> Private IP : '.$info['lanip'].'</li>';
                    }
                    if(!empty($info['wanip'])){
                    $nicinfo .= '<li class="list-group-item"><span class="badge">'.$ifname.'</span> Public IP : '.$info['wanip'].'</li>';
                    }
                }
                $nicinfo .= '</ul>';
                return $nicinfo;
                }
            })
            ->editColumn('user_id', function($data) {
                return $data->user->name;
            })
            ->editColumn('os', function($data) {
                $name = isset($data->os['name'])?$data->os['name']:'';
                return $name;
            })
            ->editColumn('os_version', function($data) {
                $version = isset($data->os['version'])?$data->os['version']:'';
                return $version;
            })
            ->addColumn('actions', function ($data) {
                            return '
                            ' . Form::open(['route' => ['devices.destroy', $data->ip], 'method' => 'delete']) . '
                            <div class=\'btn-group\'>
                                <a href="' . route('devices.show', [$data->ip]) . '" class=\'btn btn-default btn-xs\'><i class="glyphicon glyphicon-eye-open"></i></a>
                                <a href="' . route('devices.edit', [$data->ip]) . '" class=\'btn btn-default btn-xs\'><i class="glyphicon glyphicon-edit"></i></a>
                                ' . Form::button('<i class="glyphicon glyphicon-trash"></i>', [
                                'type' => 'submit',
                                'class' => 'btn btn-danger btn-xs',
                                'onclick' => "return confirm('Are you sure?')"
                            ]) . '
                            </div>
                            ' . Form::close() . '
                            ';
                        })
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $devices = Device::query();

        return $this->applyScopes($devices);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns(array_merge(
                $this->getColumns(),
                [
                    'actions' => [
                        'orderable' => false,
                        'searchable' => false,
                        'printable' => false,
                        'exportable' => false
                    ]
                ]
            ))
            ->parameters([
                'dom' => 'Bfrtip',
                'scrollX' => true,
                'buttons' => [
                    'csv',
                    'excel',
                    'pdf',
                    'print',
                    'reset',
                    'reload'
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    private function getColumns()
    {
        return [
            'ip' => ['name' => 'ip', 'data' => 'ip', 'title' => 'IP'],
            'deviceid' => ['name' => 'deviceid', 'data' => 'deviceid', 'title' => 'Device ID'],            
            'vendor' => ['name' => 'vendor', 'data' => 'vendor', 'title' => 'Vendor'],
            'os' => ['name' => 'os', 'data' => 'os', 'title' => 'OS'],
            'os_version' => ['name'=>'os', 'title' => 'OS Version'],
            'rack' => ['name' => 'rack', 'data' => 'rack'],
            'nicinfo' => ['name' => 'nicinfo', 'data' => 'nicinfo', 'title' => 'NIC Info'],
            'user_id' => ['name' => 'user_id', 'data' => 'user_id', 'title' => 'User']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'devices';
    }
}
