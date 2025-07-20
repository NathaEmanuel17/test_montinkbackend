<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCouponRequest;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CouponController extends Controller
{
    public function index(): View
    {
        $coupons = Coupon::latest()->paginate(10);
        return view('coupons.index', compact('coupons'));
    }

    public function create(): View
    {
        return view('coupons.create');
    }

    public function store(StoreCouponRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['status'] = $request->has('status');
        $data['user_id'] = Auth::id();

        Coupon::create($data);

        return redirect()->route('admin.coupons.index')->with('success', 'Cupom criado com sucesso!');
    }

    public function destroy(Coupon $coupon): RedirectResponse
    {
        $coupon->delete();
        return back()->with('success', 'Cupom excluído com sucesso!');
    }
}

