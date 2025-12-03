<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Contact;
use App\Models\GeneralSetting;
use App\Models\Industry;
use App\Models\Project;
use App\Models\ServiceInfo;
use App\Models\WebsiteBanner;
use Illuminate\Http\Request;

class websiteController extends Controller
{
    public function index()
    {
        $generalSetting = GeneralSetting::first();
        $data['generalSetting'] = $generalSetting;
        $data['banner'] = WebsiteBanner::first();
        $data['servicesInfo'] = ServiceInfo::first();
        $data['projects'] = Project::all();
        $data['industries'] = Industry::all();
        $data['client'] = Client::all();
        $data['contact'] = Contact::first();
        return view('frontend.website.index', $data);
    }
}
