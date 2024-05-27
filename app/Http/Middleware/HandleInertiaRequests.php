<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\Setting;
use App\Models\ListMenu;
use App\Models\Configuration;
use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Http\Resources\UserResource;
use App\Http\Resources\SettingResource;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        $currentRole = (\Auth::check()) ? \Auth::user()->role : null;
        $overall = []; $menus = []; $listahan = [];
        $lists = ListMenu::when($currentRole != 'Administrator', function ($query) {
            $query->where('is_active',1);
        })
        ->where('is_mother',1)->where('group','Menu')->orderBy('order','ASC')->get();
        foreach($lists as $list){
            
            $submenus = [];
            if($list['has_child']){
                $subs = ListMenu::where('is_active',1)->where('group',$list['name'])->get();
                foreach($subs as $menu){
                    $submenus[] = $menu;
                }
            }
            $menus[] = [
                'main' => $list,
                'submenus' => $submenus
            ];
        }

        $lists = ListMenu::when($currentRole !== 'Administrator', function ($query) {
            $query->where('is_active',1);
        })
        ->where('is_mother',1)->where('group','Lists')->get();
        foreach($lists as $list){
            
            $submenus = [];
            if($list['has_child']){
                $subs = ListMenu::where('is_active',1)->where('group',$list['name'])->get();
                foreach($subs as $menu){
                    $submenus[] = $menu;
                }
            }
            $listahan[] = [
                'main' => $list,
                'submenus' => $submenus
            ];
        }

        $settings = Setting::with('agency.region','semester','trimester','quarter')->first();
        $region_code = ($settings)? $settings->agency->region_code : NULL;
        $semester_year = ($settings)? $settings->year : NULL;

        return [
            ...parent::share($request),
            'user' => (\Auth::check()) ? new UserResource(User::with('profile','userrole.role')->where('id',\Auth::user()->id)->first()) : '',
            'flash' => [
                'data' => session('data'),
                'message' => session('message'),
                'info' => session('info'),
                'status' => session('status'),
                'type' => session('type')
            ],
            'configuration' => Configuration::where('id',1)->first(),
            'menus' => [
                'menus' => $menus,
                'lists' => $listahan
            ],
            'region_code' => $region_code,
            'semester_year' => $semester_year,
            'settings' => ($settings) ? new SettingResource($settings) : null
        ];
    }
}
