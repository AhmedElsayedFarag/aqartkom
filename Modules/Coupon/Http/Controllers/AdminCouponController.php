<?php

namespace Modules\Coupon\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Http\Requests\CouponRequest;
use Illuminate\Pipeline\Pipeline;

class AdminCouponController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $coupons = app(Pipeline::class)
            ->send(Coupon::select([
                'id', 'name', 'code', 'type', 'value', 'max_use',
                'current_usage', 'expire_at', 'is_active', 'start_at',
                'usage', 'commission',
            ]))
            ->thenReturn()
            ->orderBy('id')
            ->paginate(15);

        return view('coupon::admin.index', ['coupons' => $coupons]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('coupon::admin.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CouponRequest $request)
    {
        Coupon::create($request->all());

        return \success_add('coupon.index');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Coupon $coupon)
    {
        return view('coupon::admin.edit', ['coupon' => $coupon]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(CouponRequest $request, Coupon $coupon)
    {
        $coupon->update($request->all());
        if ($coupon) {
            return \success_update('coupon.index');
        }
        abort(500);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return \success_delete('coupon.index');
    }

    public function deactivate(Coupon $coupon)
    {
        $coupon->update([
            'is_active' => false
        ]);

        return \success_update('coupon.index');
    }
}
