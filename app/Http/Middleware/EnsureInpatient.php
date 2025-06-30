<?php

namespace App\Http\Middleware;
use App\Models\Admission;
use Closure;

class EnsureInpatient
{
    public function handle($request, Closure $next)
    {
        // Make sure the user is authenticated
        if(auth()->check()){
            // check if the user has an active admission 
            if(! Admission::where(['patient_id' => auth()->id(), 'discharge_date' => null])->exists()){
                // The user does not have an active admission. Redirect to the correct page
                return redirect('/home'); // Assuming the main page is your home page.
            }
        }
        
        return $next($request); // The user is an inpatient, so continue.
    }
}
