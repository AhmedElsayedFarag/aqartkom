<?php

namespace Modules\SEO\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\SEO\Entities\SEO;
use Modules\SEO\Http\Requests\UpdateSeoRequest;

class SEOController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $seoSettings = SEO::all();

        return view('seo::edit', compact('seoSettings'));
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(UpdateSeoRequest $request)
    {
        $seoSettings = SEO::all();
        if ($request->hasFile('og:image')) {
            $request->file('og:image')->store('public');
            $request->merge([
                'og:image' => Storage::disk('public')->url($request->file('og:image')->hashName()),
            ]);
        }
        if ($request->hasFile('twitter:image')) {
            $request->file('twitter:image')->store('public');
            $request->merge([
                'twitter:image' => Storage::disk('public')->url($request->file('twitter:image')->hashName()),
            ]);
        }
        $formattedSeo = [];
        foreach ($seoSettings as $seoSetting) {
            if ($request->get($seoSetting->key))
                $formattedSeo[] = [
                    'key' => $seoSetting->key,
                    'value' => $request->input($seoSetting->key)
                ];
        }
        DB::table('s_e_os')->upsert($formattedSeo, ['key'], ['value']);
        Cache::forget('seo');
        return success_update('seo.index');
    }
}