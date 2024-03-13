<?php

use App\Models\District;
use App\Models\Farmer;
use App\Models\ThlaiThar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/stat', function () {
    $data = DB::table('thlai_thars as t')
        ->join('districts', 'districts.id', 't.district_id')
        ->join('vegetables', 'vegetables.id', 't.vegetable_id')
        ->select('districts.name as district', 'vegetables.name as vegetable', DB::raw('count(*) as total_thlai_thar'))
        ->groupBy('district', 'vegetable')
        ->get();

    return $data;
});


// Route::get('/stat', function () {
//     $thlaiData = ThlaiThar::query()
//         ->join('farmers', 'thlai_thars.farmer_id', '=', 'farmers.id')
//         ->select('thlai_thars.*', 'farmers.district_id', 'farmers.name AS farmer_name')
//         ->get();

//     $groupedData = $thlaiData->groupBy('district_id');

//     $formattedData = [];
//     foreach ($groupedData as $districtId => $districtItems) {
//         $formattedData[$districtId] = [
//             'district' => $districtItems->firstWhere('district_id', $districtId)['district_id'],
//             'vegetables' => $districtItems->groupBy('vegetable_id')
//                 ->map(function ($vegetableItems) {
//                     return [
//                         'vegetable_id' => $vegetableItems->firstWhere('vegetable_id', $vegetableItems->first()['vegetable_id'])['vegetable_id'],
//                         'total_thar' => $vegetableItems->sum('thar_zat'),
//                     ];
//                 })->values(),
//         ];
//     }

//     return response()->json($formattedData);
// });
