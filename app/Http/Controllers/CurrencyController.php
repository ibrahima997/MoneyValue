<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currency;
class CurrencyController extends Controller
{
    //
    public function index()
    {
        $currencies = Currency::all();
        return response()->json($currencies);
    }


    public function add(Request $request)
    {
      $validated = $request->validate([
        'name' => 'required|max:20'
      ]);

      $currency = new Currency;
      $currency->name = $validated['name'];
      $currency->save();

      return response()->json();
    }


    public function delete($id)
    {
        Currency::find($id)->delete();
        return response()->json();
    }


}
