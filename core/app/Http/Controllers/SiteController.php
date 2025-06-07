<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Page;
use App\Models\User;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Location;
use App\Models\Property;
use App\Constants\Status;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use App\Models\AdminNotification;
use App\Models\TimeSetting;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    public function index()
    {
        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }

        $pageTitle = 'Home';
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', '/')->first();
        return view($this->activeTemplate . 'home', compact('pageTitle', 'sections'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname', $this->activeTemplate)->where('slug', $slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle', 'sections'));
    }

    public function contact()
    {
        $pageTitle = "Contact Us";
        $contactContent = Frontend::where('data_keys', 'contact_us.content')->firstOrFail();
        $user = auth()->user();
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', 'contact')->first()->secs;
        return view($this->activeTemplate . 'contact', compact('pageTitle', 'user', 'contactContent', 'sections'));
    }

    public function contactSubmit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $request->session()->regenerateToken();

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = Status::PRIORITY_MEDIUM;

        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = Status::TICKET_OPEN;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new contact message has been submitted';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug, $id)
    {
        $policy = Frontend::where('id', $id)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle = $policy->data_values->title;
        return view($this->activeTemplate . 'policy', compact('policy', 'pageTitle'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return back();
    }

    public function blogs()
    {
        $pageTitle = 'Blogs';
        $blogs = Frontend::where('data_keys', 'blog.element')->orderByDesc('id')->paginate(getPaginate());
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', 'blog')->first()->secs;
        return view($this->activeTemplate . 'blogs', compact('pageTitle', 'blogs', 'sections'));
    }

    public function blogDetails($slug, $id)
    {
        $blog = Frontend::where('id', $id)->where('data_keys', 'blog.element')->firstOrFail();
        $pageTitle = 'Blog Details';
        $latestBlogs = Frontend::where('data_keys', 'blog.element')->where('id', '<>', $blog->id)->orderByDesc('id')->take(5)->get();

        $seoContents['keywords']           = Frontend::where('data_keys', 'seo.data')->first('data_values')?->data_values->keywords;
        $seoContents['social_title']       = $blog->data_values->title;
        $seoContents['description']        = strLimit(strip_tags($blog->data_values->description), 150);
        $seoContents['social_description'] = strLimit(strip_tags($blog->data_values->description), 150);
        $seoContents['image']              = getImage('assets/images/frontend/blog/' . @$blog->data_values->image, '840x412');
        $seoContents['image_size']         = '840x412';

        return view($this->activeTemplate . 'blog_details', compact('blog', 'pageTitle', 'latestBlogs', 'seoContents'));
    }

    public function property(Request $request)
    {
        $pageTitle  = 'Properties';

        //$excludedIds = [19, 20, 21, 22, 23, 24, 25, 26]; // List of IDs to exclude
        $excludedFromId = 19; // Starting ID to exclude
        $properties = Property::active()
            ->searchable(['title'])
            ->filter(['location_id', 'is_capital_back'])
            ->withSum('invests', 'total_invest_amount')
            ->withCount('invests')
            ->with(['location', 'profitScheduleTime', 'installmentDuration', 'invests'])
            //->whereNotIn('id', $excludedIds) // Exclude properties with the specified IDs
            ->where('id', '<', $excludedFromId) // Exclude properties with IDs greater than or equal to 
            //->sortBy('per_share_amount');
            ->orderBy('per_share_amount'); // Sort by 'per_share_amount'
            

        if ($request->invest_type) {
            $properties->where('invest_type', $request->invest_type);
        }

        if ($request->profit_schedule) {
            $properties->where('profit_schedule', $request->profit_schedule);
        }

        if ($request->minimum_invest) {
            $properties->where('per_share_amount', '>=', $request->minimum_invest);
        }

        if ($request->maximum_invest) {
            $properties->where('per_share_amount', '<=', $request->maximum_invest);
        }

        $properties       = $properties->paginate(getPaginate());
        $user             = auth()->user();
        $localities       = Location::active()->get();
        $activeProperties = Property::active()->get();
        $sections         = Page::where('tempname', $this->activeTemplate)->where('slug', 'property')->first()->secs;
        $times            = TimeSetting::orderBy('time')->active()->get();

        return view($this->activeTemplate . 'property', compact('pageTitle', 'properties', 'user', 'localities', 'sections', 'times'));
    }
    
    //Products controller function starts here
    public function foodCommunityPortal(Request $request)
    {
        $pageTitle  = 'Welcome To Salesman Capital Mall';
        
        //$includedIds = [19, 20, 21, 22, 23, 24, 25, 26]; // List of IDs to include
        $includedFromId = 19; // Starting ID to include
        $properties = Property::active()
            ->searchable(['title'])
            ->filter(['location_id', 'is_capital_back'])
            ->withSum('invests', 'total_invest_amount')
            ->withCount('invests')
            ->with(['location', 'profitScheduleTime', 'installmentDuration', 'invests'])
            ->where('id', '>=', $includedFromId) // Include properties with IDs greater than or equal to $includedFromId
            ->orderByDesc('id'); // Sort by ID in descending order


        if ($request->invest_type) {
            $properties->where('invest_type', $request->invest_type);
        }

        if ($request->profit_schedule) {
            $properties->where('profit_schedule', $request->profit_schedule);
        }

        if ($request->minimum_invest) {
            $properties->where('per_share_amount', '>=', $request->minimum_invest);
        }

        if ($request->maximum_invest) {
            $properties->where('per_share_amount', '<=', $request->maximum_invest);
        }

        $properties       = $properties->paginate(getPaginate());
        $user             = auth()->user();
        $localities       = Location::active()->get();
        $activeProperties = Property::active()->get();
        $sections         = Page::where('tempname', $this->activeTemplate)->where('slug', 'property')->first()->secs;
        $times            = TimeSetting::orderBy('time')->active()->get();

        return view($this->activeTemplate . 'product', compact('pageTitle', 'properties', 'user', 'localities', 'sections', 'times'));
    }

    public function propertyDetails($slug, $id)
    {
        $property = Property::active()
            ->with(['location', 'profitScheduleTime', 'invests' => function ($invests) {
                $invests->where('user_id', auth()->id());
            }, 'propertyGallery'])
            ->withSum('invests', 'total_invest_amount')
            ->withCount('invests')
            ->findOrFail($id);

        $pageTitle = 'Property Details';
        $user      = auth()->user();
        $investors = User::active()
            ->whereHas('invests', function ($invests) use ($property) {
                $invests->where('property_id', $property->id);
            })
            ->withCount('invests')
            ->take(5)->get();

        $latestProperties = Property::active()
            ->where('id', '<>', $property->id)
            ->with(['location'])
            ->orderByDesc('id')
            ->take(6)->get();

        $seoContents['keywords']           = $property->keywords ?? Frontend::where('data_keys', 'seo.data')->first('data_values')?->data_values->keywords;
        $seoContents['social_title']       = $property->title;
        $seoContents['description']        = strLimit(strip_tags($property->details), 150);
        $seoContents['social_description'] = strLimit(strip_tags($property->details), 150);
        $seoContents['image']              = getImage(getFilePath('propertyThumb') . '/' . @$property->thumb_image, getFileSize('propertyThumb'));
        $seoContents['image_size']         = getFileSize('propertyThumb');

        return view($this->activeTemplate . 'property_details', compact('pageTitle', 'property', 'user', 'investors', 'latestProperties', 'seoContents'));
    }

    public function cookieAccept()
    {
        Cookie::queue('gdpr_cookie', gs('site_name'), 43200);
    }

    public function cookiePolicy()
    {
        $pageTitle = 'Cookie Policy';
        $cookie = Frontend::where('data_keys', 'cookie.data')->first();
        return view($this->activeTemplate . 'cookie', compact('pageTitle', 'cookie'));
    }

    public function placeholderImage($size = null)
    {
        $imgWidth = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font/RobotoMono-Regular.ttf');
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function maintenance()
    {
        $pageTitle = 'Maintenance Mode';
        if (gs('maintenance_mode') == Status::DISABLE) {
            return to_route('home');
        }
        $maintenance = Frontend::where('data_keys', 'maintenance.data')->first();
        return view($this->activeTemplate . 'maintenance', compact('pageTitle', 'maintenance'));
    }

    public function addSubscriber(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:subscribers,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        $subscriber        = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->save();

        return response()->json(['success' => true, 'message' => 'Subscribed successfully']);
    }
}
