<?php

namespace App\Http\Controllers\Admin;

use App\Models\Location;
use App\Models\Property;
use App\Constants\Status;
use App\Models\TimeSetting;
use Illuminate\Http\Request;
use App\Models\PropertyGallery;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class PropertyController extends Controller
{
    public function index()
    {
        $pageTitle  = 'All Properties';
        $properties = $this->propertyData();
        return view('admin.property.index', compact('pageTitle', 'properties'));
    }

    public function investedProperty()
    {
        $pageTitle = 'Invested Properties';
        $properties = $this->propertyData('invested');
        return view('admin.property.index', compact('pageTitle', 'properties'));
    }

    protected function propertyData($scope = null)
    {
        $properties          = Property::withSum('invests', 'total_invest_amount')->with('location');
        if ($scope) $properties = $properties->$scope();
        //return $properties->searchable(['title', 'location:name'])->orderBy('id', 'desc')->paginate(getPaginate());
        return $properties->searchable(['title', 'location:name'])->orderBy('per_share_amount', 'asc')->paginate(getPaginate());

    }

    public function create()
    {
        $pageTitle  = 'Add New Property';
        $localities = Location::active()->get();
        $times      = TimeSetting::active()->get();
        abort_if(request()->step && !in_array(request()->step, [1, 2]), 404);
        $step = request()->step ??  1;

        $existingProperty = Property::where('complete_step', 1)->first();

        if ($existingProperty) {
            return redirect(route('admin.manage.property.edit', $existingProperty->id) . "?step=2");
        }

        return view('admin.property.form', compact('pageTitle', 'localities', 'times', 'step'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'step' => 'required|in:1,2'
        ]);
        $methods = [1 =>  'stepOne', 2 =>  'stepTwo'];
        $method  = $methods[$request->step];
        return $this->$method($request, $id);
    }

    private function stepOne($request, $id)
    {

        $this->propertyValidation($request, $id);

        if ($id) {
            $property = Property::findOrFail($id);
            $message  = 'Property updated successfully';
        } else {
            $property = new Property();
            $message  = 'Property created successfully';
        }

        $property->title       = $request->title;
        $property->location_id = $request->location_id;
        $property->details     = $request->details;
        $property->map_url     = $request->map_url;
        $property->keywords    = $request->keywords ?? null;

        if ($request->hasFile('thumb_image')) {
            $property->thumb_image = $this->uploadThumb($request, $property);
        }

        $property->save();

        $this->removeGalleryImages($request, $property);

        if ($request->hasFile('gallery_image')) {
            $this->uploadGalleryImages($request, $property);
        }

        if ($property->complete_step == 2) {
            $redirectUrl = route('admin.manage.property.edit', $property->id) . "?step=1";
        } else {
            $redirectUrl = route('admin.manage.property.edit', $property->id) . "?step=2";
        }

        $notify[] = ['success', $message];
        return redirect($redirectUrl)->withNotify($notify);
    }

    private function stepTwo($request, $id)
    {

        $this->propertyValidation($request, $id, 2);

        if ($id) {
            $property = Property::findOrFail($id);
            $message  = 'Property updated successfully';
        } else {
            $property = new Property();
            $message  = 'Property created successfully';
        }

        $perShareAmount = $request->per_share_amount;

        if ($request->invest_type == Status::INVEST_TYPE_INSTALLMENT) {
            $dowPaymentAmount         = ($perShareAmount / 100) * $request->down_payment;
            $amountExcludeDownPayment = $perShareAmount - $dowPaymentAmount;
            $perInstallment           = $amountExcludeDownPayment / $request->total_installment;
        }

        $property->invest_type      = $request->invest_type;
        $property->total_share      = $request->total_share;
        $property->per_share_amount = $perShareAmount;
        $property->goal_amount      = $perShareAmount * $request->total_share;
        $property->is_capital_back  = $request->is_capital_back;
        $property->profit_back      = $request->profit_back;

        $property->per_installment_amount = @$perInstallment ?? 0;
        $property->down_payment           = $request->down_payment ?? 0;
        $property->total_installment      = $request->total_installment ?? 0;
        $property->installment_late_fee   = $request->installment_late_fee ?? 0;
        $property->installment_duration   = $request->installment_duration ?? 0;

        $property->profit_type           = $request->profit_type;
        $property->profit_amount_type    = $request->profit_amount_type;
        $property->profit_amount         = $request->profit_amount ?? 0;
        $property->minimum_profit_amount = $request->minimum_profit_amount ?? 0;
        $property->maximum_profit_amount = $request->maximum_profit_amount ?? 0;

        $property->profit_schedule                 = $request->profit_schedule;
        $property->profit_schedule_period          = $request->profit_schedule_period ?? 0;
        $property->profit_repeat_time              = $request->profit_repeat_time ?? 0;
        $property->profit_distribution             = $request->profit_distribution;
        $property->auto_profit_distribution_amount = $request->auto_profit_distribution_amount ?? 0;
        $property->complete_step                   = 2;
        $property->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    protected function removeGalleryImages($request, $property)
    {
        $images         = PropertyGallery::where('property_id', $property->id)->pluck('id')->toArray();
        $imageToRemove  = array_values(array_diff($images, $request->old ?? []));
        $propertyImages = PropertyGallery::whereIn('id', $imageToRemove);
        foreach ($propertyImages->get() as $image) {
            fileManager()->removeFile(getFilePath('propertyGallery') . '/' . $image->image);
        }
        $propertyImages->delete();
    }

    protected function uploadGalleryImages($request, $property)
    {
        foreach ($request->gallery_image as $image) {
            $propertyGallery = new PropertyGallery();
            try {
                $imageName = fileUploader($image, getFilePath('propertyGallery'), getFileSize('propertyGallery'));
                $propertyGallery->property_id = $property->id;
                $propertyGallery->image = $imageName;
                $propertyGallery->save();
            } catch (\Exception $exp) {
                throw ValidationException::withMessages(['error' => 'Couldn\'t upload your image']);
            }
        }
    }
    protected function uploadThumb($request, $property)
    {
        @$old = $property->thumb_image;
        try {
            return fileUploader($request->thumb_image, getFilePath('propertyThumb'), getFileSize('propertyThumb'), @$old, @fileManager()->propertyThumb()->thumb);
        } catch (\Exception $exp) {
            throw ValidationException::withMessages(['error' => 'Couldn\'t upload your image']);
        }
    }

    public function edit($id)
    {
        $pageTitle       = 'Edit Property';
        $localities      = Location::active()->get();
        $times           = TimeSetting::active()->get();
        $property        = Property::findOrFail($id);
        $propertyGallery = PropertyGallery::where('property_id', $property->id)->get();

        $images = [];

        foreach ($propertyGallery as $key => $image) {
            $img['id']  = $image->id;
            $img['src'] = getImage(getFilePath('propertyGallery') . '/' . $image->image);
            $images[]   = $img;
        }

        abort_if(request()->step && !in_array(request()->step, [1, 2]), 404);
        $step = request()->step ??  1;

        return view('admin.property.form', compact('pageTitle', 'localities', 'property', 'times', 'images', 'step'));
    }

    public function changeStatus($id)
    {
        return Property::changeStatus($id);
    }

    public function changeFeaturedStatus($id)
    {
        return Property::changeStatus($id, 'is_featured');
    }

    private function propertyValidation($request, $id = 0, $step = 1)
    {
        if ($step == 2) {

            $profitSchedulePeriodValidation         = $request->profit_schedule == Status::PROFIT_REPEATED_TIME ? 'required|gt:0|' : 'nullable|';
            $installStatus                          = Status::INVEST_TYPE_INSTALLMENT;
            $profitFixedStatus                      = Status::PROFIT_TYPE_FIXED;
            $profitRangeStatus                      = Status::PROFIT_TYPE_RANGE;
            $autoProfitDistributionAmountValidation = $request->profit_type     == $profitRangeStatus && $request->profit_distribution == Status::PROFIT_DISTRIBUTION_AUTO ? 'required' : 'nullable';

            $request->validate([
                'invest_type'      => 'required|in:' . Status::INVEST_TYPE_ONETIME . ',' . Status::INVEST_TYPE_INSTALLMENT,
                'total_share'      => 'required|integer|gt:0',
                'per_share_amount' => 'required|integer|gt:0',
                'is_capital_back'  => 'required|in:' . Status::CAPITAL_BACK_YES . ',' . Status::CAPITAL_BACK_NO,
                'profit_back'      => 'required|integer',

                'total_installment'    => "required_if:invest_type,$installStatus|numeric|gt:0",
                'down_payment'         => "required_if:invest_type,$installStatus|numeric|gt:0",
                'installment_late_fee' => "required_if:invest_type,$installStatus|numeric|gt:0",
                'installment_duration' => "required_if:invest_type,$installStatus|integer|gt:0",

                'profit_type'           => "required|in:$profitFixedStatus,$profitRangeStatus",
                'profit_amount_type'    => 'required|in:' . Status::PROFIT_AMOUNT_TYPE_FIXED . ',' . Status::PROFIT_AMOUNT_TYPE_PERCENT,
               // 'profit_amount'         => "required_if:profit_type,$profitFixedStatus|gt:0",
                'profit_amount' => "nullable",
                'minimum_profit_amount' => "required_if:profit_type,$profitRangeStatus|gt:0",
                'maximum_profit_amount' => "required_if:profit_type,$profitRangeStatus|gt:0",

                'profit_schedule'                 => 'required|in:' . Status::PROFIT_ONETIME . ',' . Status::PROFIT_LIFETIME . ',' . Status::PROFIT_REPEATED_TIME,
                'profit_schedule_period'          => 'required_if:profit_schedule,' . Status::PROFIT_REPEATED_TIME . ',' . Status::PROFIT_LIFETIME . '|exists:time_settings,id',
                'profit_repeat_time'              => $profitSchedulePeriodValidation . 'integer',
                'profit_distribution'             => 'required|in:' . Status::PROFIT_DISTRIBUTION_MANUAL . ',' . Status::PROFIT_DISTRIBUTION_AUTO,
                'auto_profit_distribution_amount' => "$autoProfitDistributionAmountValidation|gt:0",
            ]);
        } else {
            $imageRequired = $id  ? 'nullable' :   'required';
            $request->validate([
                'thumb_image'     => [$imageRequired, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
                'gallery_image.*' => [$imageRequired, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],

                'title'             => 'required|max:255',
                'location_id'       => 'required|integer|gt:0',
                'map_url'           => 'required',
                'details'           => 'required',

            ]);
        }
    }
}
