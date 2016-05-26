<?php

namespace App\Http\Controllers;

use App\DataTables\DeviceDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateDeviceRequest;
use App\Http\Requests\UpdateDeviceRequest;
use App\Repositories\DeviceRepository;
use Flash;
use InfyOm\Generator\Controller\AppBaseController;
use LaravelNmap\LaravelNmap;
use Response;

class DeviceController extends AppBaseController
{
    /** @var  DeviceRepository */
    private $deviceRepository;
    
    private $nmap;

    public function __construct(DeviceRepository $deviceRepo)
    {
        $this->middleware('auth');
        $this->deviceRepository = $deviceRepo;
        $this->nmap = new LaravelNmap(true);
    }

    /**
     * Display a listing of the Device.
     *
     * @param DeviceDataTable $deviceDataTable
     * @return Response
     */
    public function index(DeviceDataTable $deviceDataTable)
    {
        return $deviceDataTable->render('devices.index');
    }

    /**
     * Show the form for creating a new Device.
     *
     * @return Response
     */
    public function create()
    {
        return view('devices.create');
    }

    /**
     * Store a newly created Device in storage.
     *
     * @param CreateDeviceRequest $request
     *
     * @return Response
     */
    public function store(CreateDeviceRequest $request)
    {
        $input = $request->all();
        $user = $request->user();

        $device = $this->deviceRepository->create($input);
        $user->devices()->save($device);
        Flash::success('Device saved successfully.');

        return redirect(route('devices.index'));
    }

    /**
     * Display the specified Device.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $device = $this->deviceRepository->findWithoutFail($id);

        if (empty($device)) {
            Flash::error('Device not found');

            return redirect(route('devices.index'));
        }

        return view('devices.show')->with('device', $device);
    }

    /**
     * Show the form for editing the specified Device.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $device = $this->deviceRepository->findWithoutFail($id);

        if (empty($device)) {
            Flash::error('Device not found');

            return redirect(route('devices.index'));
        }

        return view('devices.edit')->with('device', $device);
    }

    /**
     * Update the specified Device in storage.
     *
     * @param  int              $id
     * @param UpdateDeviceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDeviceRequest $request)
    {
        $device = $this->deviceRepository->findWithoutFail($id);

        if (empty($device)) {
            Flash::error('Device not found');

            return redirect(route('devices.index'));
        }
        $user = $request->user();
        $device = $this->deviceRepository->update($request->all(), $id);
        $device->user()->associate($user);
        $device->save();
        Flash::success('Device updated successfully.');

        return redirect(route('devices.index'));
    }

    /**
     * Remove the specified Device from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $device = $this->deviceRepository->findWithoutFail($id);

        if (empty($device)) {
            Flash::error('Device not found');

            return redirect(route('devices.index'));
        }

        $this->deviceRepository->delete($id);

        Flash::success('Device deleted successfully.');

        return redirect(route('devices.index'));
    }
    
    public function generate(\Illuminate\Http\Request $request) {
        $user= $request->user();
        $timeout = 1200;
        set_time_limit($timeout);
        $target = $request->only('target')['target'];
        $nmap = $this->nmap->disablePortScan()->setTarget($target)->setTimeout($timeout)->getArray();
        
        $total = sizeof($nmap);
        
        echo '"total":"'.$total.'","progress":"';
        ob_implicit_flush(1);
        foreach ($nmap as $hostip => $hostinfo) {
            
            try{
                $host = $this->nmap->detectOS()->setTarget($hostip)->setTimeout($timeout)->getXmlObject();
            }  catch (\ErrorException $e) {
                $host = [];
            }
            $os = isset($host[$hostip])?$host[$hostip]['os']:[];
            $device = $this->deviceRepository->updateOrCreate(['ip'=>$hostip], ['ip'=>$hostip,'os'=>$os,'user_id'=>$user->id]);
            
            echo "|";
        }
        
    }
}
