<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $userType): Response
    {
        $user = $request->user();

        // Check if user type matches the required type
        if ($user->type !== $userType) {
            throw new UnauthorizedException();
        }

        // Check if student_id exists for student users
        if ($userType === 'student' && empty($user->student_id)) {
            throw new UnauthorizedException();
        }

        // Check if lecturer_id exists for lecturer users
        if ($userType === 'lecturer' && empty($user->lecturer_id)) {
            throw new UnauthorizedException();
        }

        return $next($request);
    }
}
