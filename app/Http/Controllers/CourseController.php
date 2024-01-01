<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();

        return response()->json(['courses' => $courses]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }

    public function checkout()
    {
        $courses = Course::all();
        if (!Auth::attempt(['email' => 'jubayer@mail.com', 'password' => 'password'])) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Validate the request (you may want to add more validation)
        // $request->validate([
        //     'payment_method' => 'required',
        // ]);

        // Retrieve the authenticated user
        $user = Auth::user();


        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $lineItems = [];
        foreach ($courses as $key => $course) {
            $lineItems[] = [
                'price_data' => [
                  'currency' => 'usd',
                  'product_data' => [
                    'name' => $course->name,
                  ],
                  'unit_amount' => 200,
                ],
                'quantity' => 1,
            ];
        }

        // dd($lineItems);
        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true),
            'cancel_url' => route('checkout.cancel', [], true),
          ]);
          
        //   header("HTTP/1.1 303 See Other");
        //   header("Location: " . $checkout_session->url);
          return redirect($checkout_session->url);
    }

    public function success()
    {
        dd('succes');
    }

    public function cancel()
    {
        dd('cancel');
    }
}
