<?php

namespace App\Http\Middleware;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class HandleInertiaRequests
{
    /**
     * Handle the incoming requests and add global values to be used in views.
     *
     * @param Request $request
     * @param callable $next
     * @return Response|RedirectResponse|JsonResponse
     */
    public function handle(Request $request, callable $next): Response|RedirectResponse|JsonResponse
    {
        Inertia::share(array_filter([
            'flash' => function () use ($request) {
                return [
                    'success' => $request->session()->get('success'),
                    'error' => $request->session()->get('error'),
                ];
            },
            'route' => function () use ($request) {
                return $request->route()->getName();
            },
            'current_user' => function () {
                return [
                    'full_name' => auth()->guest() ? null : request()->user()->getFullName(),
                    'avatar' => auth()->guest() ? null : request()->user()->getAvatarPath(),
                    'role' => auth()->guest() ? null : request()->user()->role,
                ];
            }
        ]));

        return $next($request);
    }
}
