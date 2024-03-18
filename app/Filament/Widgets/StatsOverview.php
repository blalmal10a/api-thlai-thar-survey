<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {

        $data = DB::table('thlai_thars as t')
            ->join('districts', 'districts.id', 't.district_id')
            ->join('vegetables', 'vegetables.id', 't.vegetable_id')
            ->select('districts.name as district', 'vegetables.name as vegetable', DB::raw('count(*) as total_thlai_thar'))
            ->groupBy('district', 'vegetable')
            ->get();
        $statistics = [];

        foreach ($data as $item) {
            array_push($statistics, Stat::make($item->district . '-a, ' . strtoupper($item->vegetable) . ' thartu awm zat', $item->total_thlai_thar));
        }
        return $statistics;
        return [

            // Stat::make('Unique views', '192.1k'),
            // Stat::make('Bounce rate', '21%'),
            // Stat::make('Average time on page', '3:12'),
        ];
    }
}
