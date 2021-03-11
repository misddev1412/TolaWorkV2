<?php

namespace App\Http\Controllers\Admin;

use DB;
use Input;
use Redirect;
use App\Package;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\PackageFormRequest;
use App\Http\Controllers\Controller;

class PackageController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function indexPackages()
    {
        return view('admin.package.index');
    }

    public function createPackage()
    {
        return view('admin.package.add');
    }

    public function storePackage(PackageFormRequest $request)
    {
        $package = new Package();

        $package->package_title = $request->input('package_title');
        $package->package_price = $request->input('package_price');
        $package->package_num_days = $request->input('package_num_days');
        $package->package_num_listings = $request->input('package_num_listings');
        $package->package_for = $request->input('package_for');
        $package->save();
        /*         * ************************************ */
        flash('Package has been added!')->success();
        return \Redirect::route('edit.package', array($package->id));
    }

    public function editPackage($id)
    {
        $package = Package::findOrFail($id);
        return view('admin.package.edit')
                        ->with('package', $package);
    }

    public function updatePackage($id, PackageFormRequest $request)
    {
        $package = Package::findOrFail($id);

        $package->package_title = $request->input('package_title');
        $package->package_price = $request->input('package_price');
        $package->package_num_days = $request->input('package_num_days');
        $package->package_num_listings = $request->input('package_num_listings');
        $package->package_for = $request->input('package_for');

        $package->update();
        flash('Package has been updated!')->success();
        return \Redirect::route('edit.package', array($package->id));
    }

    public function deletePackage(Request $request)
    {
        $id = $request->input('id');
        try {
            $package = Package::findOrFail($id);
            $package->delete();
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    public function fetchPackagesData(Request $request)
    {
        $packages = Package::select([
                    'packages.id',
                    'packages.package_title',
                    'packages.package_price',
                    'packages.package_num_days',
                    'packages.package_num_listings',
                    'packages.package_for',
                ])->orderBy('packages.package_for');
        return Datatables::of($packages)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('package_title') && !empty($request->package_title)) {
                                $query->where('packages.package_title', 'like', "%{$request->get('package_title')}%");
                            }
                            if ($request->has('package_price') && !empty($request->package_price)) {
                                $query->where('packages.package_price', 'like', "{$request->get('package_price')}%");
                            }
                            if ($request->has('package_num_days') && !empty($request->package_num_days)) {
                                $query->where('packages.package_num_days', 'like', "{$request->get('package_num_days')}%");
                            }

                            if ($request->has('package_num_listings') && !empty($request->package_num_listings)) {
                                $query->where('packages.package_num_listings', 'like', "{$request->get('package_num_listings')}%");
                            }

                            if ($request->has('package_for') && !empty($request->package_for)) {
                                $query->where('packages.package_for', 'like', "{$request->get('package_for')}");
                            }
                        })
                        ->addColumn('action', function ($packages) {
                            return '
				<div class="btn-group">
					<button class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.package', ['id' => $packages->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deletePackage(' . $packages->id . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
					</ul>
				</div>';
                        })
                        ->rawColumns(['action'])
                        ->setRowId(function($packages) {
                            return 'packageDtRow' . $packages->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

}
