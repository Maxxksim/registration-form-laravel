<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleOrderSteps
{
    private const array STEPS_ORDER = ['one' => 1, 'two' => 2, 'thanks' => 3];

    public function handle(Request $request, Closure $next, string $step): Response
    {
        $current = $request->session()->get('currentStep');
        if (! $current) {
            $request->session()->put('currentStep', 'one');
            $current = 'one';
        }

        if (self::STEPS_ORDER[$step] > self::STEPS_ORDER[$current]) {
            return redirect("/register/steps/{$current}")
                ->withErrors(['order_step' => "You must pass step $current at first."]);
        }

        return $next($request);
    }
}
