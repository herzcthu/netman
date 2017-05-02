<?php

namespace App\Http\Controllers;

use App\DataTables\PhoneListDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePhoneListRequest;
use App\Http\Requests\UpdatePhoneListRequest;
use App\Repositories\PhoneListRepository;
use Flash;
use InfyOm\Generator\Controller\AppBaseController;
use Response;

class PhoneListController extends AppBaseController
{
    /** @var  PhoneListRepository */
    private $phoneListRepository;

    public function __construct(PhoneListRepository $phoneListRepo)
    {
        $this->phoneListRepository = $phoneListRepo;
    }

    /**
     * Display a listing of the PhoneList.
     *
     * @param PhoneListDataTable $phoneListDataTable
     * @return Response
     */
    public function index(PhoneListDataTable $phoneListDataTable)
    {
        return $phoneListDataTable->render('phoneLists.index');
    }

    /**
     * Show the form for creating a new PhoneList.
     *
     * @return Response
     */
    public function create()
    {
        return view('phoneLists.create');
    }

    /**
     * Store a newly created PhoneList in storage.
     *
     * @param CreatePhoneListRequest $request
     *
     * @return Response
     */
    public function store(CreatePhoneListRequest $request)
    {
        $input = $request->all();

        $phoneList = $this->phoneListRepository->create($input);

        Flash::success('PhoneList saved successfully.');

        return redirect(route('phoneLists.index'));
    }

    /**
     * Display the specified PhoneList.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $phoneList = $this->phoneListRepository->findWithoutFail($id);

        if (empty($phoneList)) {
            Flash::error('PhoneList not found');

            return redirect(route('phoneLists.index'));
        }

        return view('phoneLists.show')->with('phoneList', $phoneList);
    }

    /**
     * Show the form for editing the specified PhoneList.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $phoneList = $this->phoneListRepository->findWithoutFail($id);

        if (empty($phoneList)) {
            Flash::error('PhoneList not found');

            return redirect(route('phoneLists.index'));
        }

        return view('phoneLists.edit')->with('phoneList', $phoneList);
    }

    /**
     * Update the specified PhoneList in storage.
     *
     * @param  int              $id
     * @param UpdatePhoneListRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePhoneListRequest $request)
    {
        $phoneList = $this->phoneListRepository->findWithoutFail($id);

        if (empty($phoneList)) {
            Flash::error('PhoneList not found');

            return redirect(route('phoneLists.index'));
        }

        $phoneList = $this->phoneListRepository->update($request->all(), $id);

        Flash::success('PhoneList updated successfully.');

        return redirect(route('phoneLists.index'));
    }

    /**
     * Remove the specified PhoneList from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $phoneList = $this->phoneListRepository->findWithoutFail($id);

        if (empty($phoneList)) {
            Flash::error('PhoneList not found');

            return redirect(route('phoneLists.index'));
        }

        $this->phoneListRepository->delete($id);

        Flash::success('PhoneList deleted successfully.');

        return redirect(route('phoneLists.index'));
    }
}
