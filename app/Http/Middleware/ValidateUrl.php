<?php
namespace App\Http\Middleware;

use Closure;

class ValidateUrl
{
    public function handle($request, Closure $next)
    {
        $imageUrl = $request->input('img_url');

        if ($imageUrl===null&&filter_var($imageUrl, FILTER_VALIDATE_URL)===null) {
            return redirect('/')->with('error', 'Invalid URL provided for image');
        }

        return $next($request);
    }
}
?>