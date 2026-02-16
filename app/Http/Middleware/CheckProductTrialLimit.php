<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Product;

class CheckProductTrialLimit
{
    public function handle(Request $request, Closure $next)
    {
        if(config('trial.enabled')){
            $limit = config('trial.product_limit');
            $currentCount = Product::count();

            if($currentCount >= $limit){
                return redirect()
                ->route('products.index')
                ->with('error', 'Anda telah mencapai batas maksimal versi trial ('.$limit.' produk). Silakan upgrade ke versi pro.');
            }
        }
        return $next($request);
    }
}
