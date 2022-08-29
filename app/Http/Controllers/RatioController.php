<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ratio;
class RatioController extends Controller
{
    //
    public function get_ratios(Request $request)
    {
      $validated = $request->validate([
        'currency_from' => 'required|int',
        'currency_to' => 'required|int',
      ]);
      $ratio = Ratio::where('currency_from_id', $validated['currency_from'])
          ->where('currency_to_id', $validated['currency_to'])
          ->first();

      return response()->json($ratio);
    }
    public function set_ratios(Request $request)
    {
    $validated = $request->validate([
      'currency_from' => 'required|int',
      'currency_to' => 'required|int',
      'ratio' => 'required|numeric'
    ]);
    if ($validated['currency_from'] == $validated['currency_to']) {
        return response()->json();
      }
      $ratio = Ratio::where('currency_from_id', $validated['currency_from'])
          ->where('currency_to_id', $validated['currency_to'])
          ->first();
      if ($ratio == null) {
        $ratio1 = new Ratio;
        $ratio1->currency_from_id = $validated['currency_from'];
        $ratio1->currency_to_id = $validated['currency_to'];
        $ratio1->ratio = $validated['ratio'];
        $ratio1->save();

        $ratio2 = new Ratio;
        $ratio2->currency_from_id = $validated['currency_to'];
        $ratio2->currency_to_id = $validated['currency_from'];
        $ratio2->ratio = (1/$validated['ratio']);
        $ratio2->save();

      } else {
        $ratio1 = Ratio::where('currency_from_id', $validated['currency_from'])
            ->where('currency_to_id', $validated['currency_to'])
            ->first();
        $ratio1->ratio = $validated['ratio'];
        $ratio1->save();

        $ratio2 = Ratio::where('currency_to_id', $validated['currency_from'])
            ->where('currency_from_id', $validated['currency_to'])
            ->first();
        $ratio2->ratio = (1/$validated['ratio']);
        $ratio2->save();
      }
      return response()->json();
    }
}
