<?php

namespace App\Http\Controllers\Admin;

use Hash;
use File;
use ImgUploader;
use Auth;
use DB;
use Input;
use Redirect;
use App\Package;
use App\Company;
use App\Country;
use App\State;
use App\City;
use App\Industry;
use App\OwnershipType;
use Carbon\Carbon;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\CompanyFormRequest;
use App\Http\Controllers\Controller;
use App\Traits\CompanyTrait;
use App\Traits\CompanyPackageTrait;

class CompanyController extends Controller
{

    use CompanyTrait;
	use CompanyPackageTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function indexCompanies()
    {
        return view('admin.company.index');
    }

    public function createCompany()
    {
        $countries = DataArrayHelper::defaultCountriesArray();
        $industries = DataArrayHelper::defaultIndustriesArray();
        $ownershipTypes = DataArrayHelper::defaultOwnershipTypesArray();
		$packages = Package::select('id', DB::raw("CONCAT(`package_title`, ', $', `package_price`, ', Days:', `package_num_days`, ', Listings:', `package_num_listings`) AS package_detail"))->where('package_for', 'like', 'employer')->pluck('package_detail', 'id')->toArray();
        
        return view('admin.company.add')
                        ->with('countries', $countries)
                        ->with('industries', $industries)
                        ->with('ownershipTypes', $ownershipTypes)
						->with('packages', $packages);
    }

    public function storeCompany(CompanyFormRequest $request)
    {
        $company = new Company();
        /*         * **************************************** */
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $fileName = ImgUploader::UploadImage('company_logos', $image, $request->input('name'), 300, 300, false);
            $company->logo = $fileName;
        }
        /*         * ************************************** */

        $company->name = $request->input('name');
        $company->email = $request->input('email');

        if (!empty($request->input('password'))) {
            $company->password = Hash::make($request->input('password'));
        }

        $company->ceo = $request->input('ceo');
        $company->industry_id = $request->input('industry_id');
        $company->ownership_type_id = $request->input('ownership_type_id');
        $company->description = $request->input('description');
        $company->location = $request->input('location');
		$company->map = $request->input('map');
        $company->no_of_offices = $request->input('no_of_offices');

        $website = $request->input('website');
        $company->website = (false === strpos($website, 'http')) ? 'http://' . $website : $website;

        $company->no_of_employees = $request->input('no_of_employees');
        $company->established_in = $request->input('established_in');
        $company->fax = $request->input('fax');
        $company->phone = $request->input('phone');
		$company->facebook = $request->input('facebook');
		$company->twitter = $request->input('twitter');
		$company->linkedin = $request->input('linkedin');
		$company->google_plus = $request->input('google_plus');
        $company->pinterest = $request->input('pinterest');
		$company->country_id = $request->input('country_id');
        $company->state_id = $request->input('state_id');
        $company->city_id = $request->input('city_id');
        $company->is_active = $request->input('is_active');
        $company->is_featured = $request->input('is_featured');

        $company->save();
		/**********************************/
		$company->slug = str_slug($company->name, '-').'-'.$company->id;
		/**********************************/
		$company->update();
		/*         * ************************************ */
		if($request->has('company_package_id') && $request->input('company_package_id') > 0)
		{
			$package_id = $request->input('company_package_id');
			$package = Package::find($package_id);
			$this->addCompanyPackage($company, $package);
		}
        /*         * ************************************ */

        flash('Company has been added!')->success();
        return \Redirect::route('edit.company', array($company->id));
    }

    public function editCompany($id)
    {
        $countries = DataArrayHelper::defaultCountriesArray();
        $industries = DataArrayHelper::defaultIndustriesArray();
        $ownershipTypes = DataArrayHelper::defaultOwnershipTypesArray();		
		
        $company = Company::findOrFail($id);
		if($company->package_id > 0)
		{
			$package = Package::find($company->package_id);
			$packages = Package::select('id', DB::raw("CONCAT(`package_title`, ', $', `package_price`, ', Days:', `package_num_days`, ', Listings:', `package_num_listings`) AS package_detail"))->where('package_for', 'like', 'employer')->where('id', '<>', $company->package_id)->where('package_price', '>=', $package->package_price)->pluck('package_detail', 'id')->toArray();
		}
		else
		{
			$packages = Package::select('id', DB::raw("CONCAT(`package_title`, ', $', `package_price`, ', Days:', `package_num_days`, ', Listings:', `package_num_listings`) AS package_detail"))->where('package_for', 'like', 'employer')->pluck('package_detail', 'id')->toArray();
		}
		
        return view('admin.company.edit')
                        ->with('company', $company)
                        ->with('countries', $countries)
                        ->with('industries', $industries)
                        ->with('ownershipTypes', $ownershipTypes)
						->with('packages', $packages);
    }

    public function updateCompany($id, CompanyFormRequest $request)
    {
        $company = Company::findOrFail($id);
        /*         * **************************************** */
        if ($request->hasFile('logo')) {
            $is_deleted = $this->deleteCompanyLogo($company->id);
            $image = $request->file('logo');
            $fileName = ImgUploader::UploadImage('company_logos', $image, $request->input('name'), 300, 300, false);
            $company->logo = $fileName;
        }
        /*         * ************************************** */

        $company->name = $request->input('name');
        $company->email = $request->input('email');
        if (!empty($request->input('password'))) {
            $company->password = Hash::make($request->input('password'));
        }
        $company->ceo = $request->input('ceo');
        $company->industry_id = $request->input('industry_id');
        $company->ownership_type_id = $request->input('ownership_type_id');
        $company->description = $request->input('description');
        $company->location = $request->input('location');
		$company->map = $request->input('map');
        $company->no_of_offices = $request->input('no_of_offices');

        $website = $request->input('website');
        $company->website = (false === strpos($website, 'http')) ? 'http://' . $website : $website;

        $company->no_of_employees = $request->input('no_of_employees');
        $company->established_in = $request->input('established_in');
        $company->fax = $request->input('fax');
        $company->phone = $request->input('phone');
		$company->facebook = $request->input('facebook');
		$company->twitter = $request->input('twitter');
		$company->linkedin = $request->input('linkedin');
		$company->google_plus = $request->input('google_plus');
		$company->pinterest = $request->input('pinterest');
        $company->country_id = $request->input('country_id');
        $company->state_id = $request->input('state_id');
        $company->city_id = $request->input('city_id');
        $company->is_active = $request->input('is_active');
        $company->is_featured = $request->input('is_featured');
		
		$company->slug = str_slug($company->name, '-').'-'.$company->id;

        $company->update();
		
		/*         * ************************************ */
		if($request->has('company_package_id') && $request->input('company_package_id') > 0)
		{
			$package_id = $request->input('company_package_id');
			$package = Package::find($package_id);
			if($company->package_id > 0)
			{
				$this->updateCompanyPackage($company, $package);
			}
			else
			{
				$this->addCompanyPackage($company, $package);
			}
		}
        /*         * ************************************ */

        flash('Company has been updated!')->success();
        return \Redirect::route('edit.company', array($company->id));
    }

    public function deleteCompany(Request $request)
    {
        $id = $request->input('id');
        try {
            $company = Company::findOrFail($id);
            $this->deleteCompanyLogo($company->id);
            $company->delete();
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    public function fetchCompaniesData(Request $request)
    {
        $companies = Company::select([
                    'companies.id',
                    'companies.name',
                    'companies.email',
                    'companies.password',
                    'companies.ceo',
                    'companies.industry_id',
                    'companies.ownership_type_id',
                    'companies.description',
                    'companies.location',
                    'companies.no_of_offices',
                    'companies.website',
                    'companies.no_of_employees',
                    'companies.established_in',
                    'companies.fax',
                    'companies.phone',
                    'companies.logo',
                    'companies.country_id',
                    'companies.state_id',
                    'companies.city_id',
                    'companies.is_active',
                    'companies.is_featured',
        ]);
        return Datatables::of($companies)
                        ->filter(function ($query) use ($request) {


                            if ($request->has('name') && !empty($request->name)) {
                                $query->where('companies.name', 'like', "%{$request->get('name')}%");
                            }

                            if ($request->has('email') && !empty($request->email)) {
                                $query->where('companies.email', 'like', "%{$request->get('email')}%");
                            }

                            if ($request->has('is_active') && $request->is_active != -1) {
                                $query->where('companies.is_active', '=', "{$request->get('is_active')}");
                            }

                            if ($request->has('is_featured') && $request->is_featured != -1) {
                                $query->where('companies.is_featured', '=', "{$request->get('is_featured')}");
                            }
                        })
                        ->addColumn('is_active', function ($companies) {
                            return ((bool) $companies->is_active) ? 'Yes' : 'No';
                        })
                        ->addColumn('is_featured', function ($companies) {
                            return ((bool) $companies->is_featured) ? 'Yes' : 'No';
                        })
                        ->addColumn('action', function ($companies) {

                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $companies->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $companies->is_active == 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $companies->id . ');';
                                $activeIcon = 'check-square-o';
                            }


                            /*                             * ************************* */
                            $featuredTxt = 'Make Featured';
                            $featuredHref = 'makeFeatured(' . $companies->id . ');';
                            $featuredIcon = 'square-o';
                            if ((int) $companies->is_featured == 1) {
                                $featuredTxt = 'Make Not Featured';
                                $featuredHref = 'makeNotFeatured(' . $companies->id . ');';
                                $featuredIcon = 'check-square-o';
                            }

                            return '
				<div class="btn-group">
					<button class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('list.jobs', ['company_id' => $companies->id]) . '" target="_blank"><i class="fa fa-list" aria-hidden="true"></i>List Jobs</a>
						</li>
						
						<li>
							<a href="' . route('edit.company', ['id' => $companies->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteCompany(' . $companies->id . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						
<li><a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $companies->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a></li>

						
<li><a href="javascript:void(0);" onClick="' . $featuredHref . '" id="onclickFeatured' . $companies->id . '"><i class="fa fa-' . $featuredIcon . '" aria-hidden="true"></i>' . $featuredTxt . '</a></li>

					</ul>
				</div>';
                        })
                        ->rawColumns(['action', 'is_active', 'is_featured'])
                        ->setRowId(function($companies) {
                            return 'companyDtRow' . $companies->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveCompany(Request $request)
    {
        $id = $request->input('id');
        try {
            $company = Company::findOrFail($id);
            $company->is_active = 1;
            $company->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveCompany(Request $request)
    {
        $id = $request->input('id');
        try {
            $company = Company::findOrFail($id);
            $company->is_active = 0;
            $company->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeFeaturedCompany(Request $request)
    {
        $id = $request->input('id');
        try {
            $company = Company::findOrFail($id);
            $company->is_featured = 1;
            $company->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotFeaturedCompany(Request $request)
    {
        $id = $request->input('id');
        try {
            $company = Company::findOrFail($id);
            $company->is_featured = 0;
            $company->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

}