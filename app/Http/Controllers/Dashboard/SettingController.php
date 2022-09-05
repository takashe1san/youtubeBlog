<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        
        $data = [
            'logo'      => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
            'favicon'   => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
            'facebook'  => 'nullable|string',
            'instagram' => 'nullable|string',
            'twitter'   => 'nullable|string',
            'email'     => 'nullable|email',
        ];
        foreach(config('app.languages') as $key => $value){
            $data[$key.'.title']   = 'nullable|string';
            $data[$key.'.content'] = 'nullable|string';
            $data[$key.'.address'] = 'nullable|string';
        }

        $valiData = $request->validate($data);
        $setting->update($request->except('logo', 'favicon', '_token'));
        if($request->has('logo')){
            $path = $request->file('logo')->store('images');
            if($setting->logo != null)
            unlink($setting->logo);
            $setting->update(['logo' => $path]);
        }
        if($request->has('favicon')){
            $path = $request->file('favicon')->store('images');
            if($setting->favicon != null)
            unlink($setting->favicon);
            $setting->update(['favicon' => $path]);
        }
    }

}
