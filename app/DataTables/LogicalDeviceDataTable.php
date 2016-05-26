<?php

namespace App\DataTables;

use App\Models\LogicalDevice;
use Form;
use Yajra\Datatables\Services\DataTable;

class LogicalDeviceDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
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
            ->editColumn('device', function($data) {
                if(!empty($data->device))
                    return'<a href="' . route('devices.show', [$data->device]) . '" class=\'btn btn-default btn-xs\'>'.
                    '<i class="glyphicon glyphicon-eye-open"></i>'.$data->device.'</a>';
            })
            ->addColumn('actions', function ($data) {
                            return '
                            ' . Form::open(['route' => ['logicalDevices.destroy', $data->ip], 'method' => 'delete']) . '
                            <div class=\'btn-group\'>
                                <a href="' . route('logicalDevices.show', [$data->ip]) . '" class=\'btn btn-default btn-xs\'><i class="glyphicon glyphicon-eye-open"></i></a>
                                <a href="' . route('logicalDevices.edit', [$data->ip]) . '" class=\'btn btn-default btn-xs\'><i class="glyphicon glyphicon-edit"></i></a>
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
        $logicalDevices = LogicalDevice::query();

        return $this->applyScopes($logicalDevices);
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
            'ip' => ['name' => 'ip', 'data' => 'ip'],
            'type' => ['name' => 'type', 'data' => 'type'],
            'username' => ['name' => 'username', 'data' => 'username'],
            'password' => ['name' => 'password', 'data' => 'password'],
            'os' => ['title'=>'OS'],
            'os_version' => ['title'=>'OS Version'],
            'service' => ['name' => 'service', 'data' => 'service'],
            'nicinfo' => ['name' => 'nicinfo', 'data' => 'nicinfo','title'=>'NIC Info'],
            'device' => ['name' => 'device', 'data' => 'device'],
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
        return 'logicalDevices';
    }
}
