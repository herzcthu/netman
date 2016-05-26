<?php

namespace App\Http\Controllers;

use App\DataTables\LogicalDeviceDataTable;
use App\Http\Requests\CreateLogicalDeviceRequest;
use App\Http\Requests\UpdateLogicalDeviceRequest;
use App\Repositories\DeviceRepository;
use App\Repositories\LogicalDeviceRepository;
use ErrorException;
use Flash;
use InfyOm\Generator\Controller\AppBaseController;
use LaravelNmap\LaravelNmap;
use Response;

class LogicalDeviceController extends AppBaseController
{
    /** @var  LogicalDeviceRepository */
    private $logicalDeviceRepository;
    
    private $device;

    public function __construct(LogicalDeviceRepository $logicalDeviceRepo, DeviceRepository $device)
    {
        $this->logicalDeviceRepository = $logicalDeviceRepo;
        $this->device = $device;
        $this->nmap = new LaravelNmap(true);
    }

    /**
     * Display a listing of the LogicalDevice.
     *
     * @param LogicalDeviceDataTable $logicalDeviceDataTable
     * @return Response
     */
    public function index(LogicalDeviceDataTable $logicalDeviceDataTable)
    {
        return $logicalDeviceDataTable->render('logicalDevices.index');
    }

    /**
     * Show the form for creating a new LogicalDevice.
     *
     * @return Response
     */
    public function create()
    {
        $devices = $this->device->lists('ip','ip');
        return view('logicalDevices.create')->with('devices',$devices);
    }

    /**
     * Store a newly created LogicalDevice in storage.
     *
     * @param CreateLogicalDeviceRequest $request
     *
     * @return Response
     */
    public function store(CreateLogicalDeviceRequest $request)
    {
        $input = $request->all();
        $user = $request->user();
        $logicalDevice = $this->logicalDeviceRepository->create($input);
        $user->logicalDevices()->save($logicalDevice);
        Flash::success('LogicalDevice saved successfully.');

        return redirect(route('logicalDevices.index'));
    }

    /**
     * Display the specified LogicalDevice.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $logicalDevice = $this->logicalDeviceRepository->findWithoutFail($id);

        if (empty($logicalDevice)) {
            Flash::error('LogicalDevice not found');

            return redirect(route('logicalDevices.index'));
        }
        $devices = $this->device->lists('ip','ip');
        return view('logicalDevices.show')->with('logicalDevice', $logicalDevice)
                ->with('devices',$devices);
    }

    /**
     * Show the form for editing the specified LogicalDevice.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $logicalDevice = $this->logicalDeviceRepository->findWithoutFail($id);

        if (empty($logicalDevice)) {
            Flash::error('LogicalDevice not found');

            return redirect(route('logicalDevices.index'));
        }
        $devices = $this->device->lists('ip','ip');
        return view('logicalDevices.edit')->with('logicalDevice', $logicalDevice)
                ->with('devices',$devices);
    }

    /**
     * Update the specified LogicalDevice in storage.
     *
     * @param  int              $id
     * @param UpdateLogicalDeviceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLogicalDeviceRequest $request)
    {
        $logicalDevice = $this->logicalDeviceRepository->findWithoutFail($id);

        if (empty($logicalDevice)) {
            Flash::error('LogicalDevice not found');

            return redirect(route('logicalDevices.index'));
        }
        $user = $request->user();
        $logicalDevice = $this->logicalDeviceRepository->update($request->all(), $id);
        $logicalDevice->user()->associate($user);
        $logicalDevice->save();
        Flash::success('LogicalDevice updated successfully.');

        return redirect(route('logicalDevices.index'));
    }

    /**
     * Remove the specified LogicalDevice from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $logicalDevice = $this->logicalDeviceRepository->findWithoutFail($id);

        if (empty($logicalDevice)) {
            Flash::error('LogicalDevice not found');

            return redirect(route('logicalDevices.index'));
        }

        $this->logicalDeviceRepository->delete($id);

        Flash::success('LogicalDevice deleted successfully.');

        return redirect(route('logicalDevices.index'));
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
            }  catch (ErrorException $e) {
                $host = [];
            }
            $os = isset($host[$hostip])?$host[$hostip]['os']:[];
            $device = $this->logicalDeviceRepository->updateOrCreate(['ip'=>$hostip], ['ip'=>$hostip,'os'=>$os,'user_id'=>$user->id]);
            
            echo "|";
        }
        
    }
}
