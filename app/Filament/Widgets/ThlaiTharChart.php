<?php

namespace App\Filament\Widgets;

use App\Models\District;
use App\Models\Vegetable;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ThlaiTharChart extends ChartWidget
{
    protected static ?string $maxHeight = '50vh';
    protected static ?string $heading = 'Thlaithar statistics';

    protected function getData(): array
    {
        $data = $this->retrieveData();

        return [
            'datasets' => $data['datasets'],
            'labels' => $data['districts']
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'stacked' => true,
                ],

                'x' => [
                    'stacked' => true,
                ],
            ]
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    public function retrieveData()
    {
        $allDistricts = District::pluck('name');
        $allVegetables = Vegetable::pluck('name');
        $result = [];
        foreach ($allVegetables as $index => $vegetable) {
            $result[$vegetable] = [
                'label' => $vegetable,
                'barThickness' => 40,
                'backgroundColor' => $this->nameToHex($vegetable),
                'hoverBackgroundColor' => 'cornflowerblue',
                'data' => [],
            ];

            foreach ($allDistricts as $district) {
                $result[$vegetable]['data'][$district] = 0;
            }
        }

        $data = DB::table('thlai_thars as t')
            ->join('districts', 'districts.id', 't.district_id')
            ->join('vegetables', 'vegetables.id', 't.vegetable_id')
            ->select('districts.name as district', 'vegetables.name as vegetable', DB::raw('count(*) as total_thlai_thar'))
            ->groupBy('district', 'vegetable')
            ->get();

        foreach ($data as $key => $item) {
            $district = $item->district;
            $vegetable = $item->vegetable;
            $result[$vegetable]['data'][$district] = $item->total_thlai_thar;
        }

        return [
            'datasets' => array_values($result),
            'districts' => $allDistricts,
        ];
    }


    public function nameToHex($name)
    {
        // Convert the name to uppercase and remove spaces
        $name = strtoupper(str_replace(" ", "", $name));

        // Get the sum of ASCII character codes
        $codeSum = 0;
        for ($i = 0; $i < strlen($name); $i++) {
            $codeSum += ord($name[$i]);
        }

        // Convert the sum to a hex string and return it with zero-padding for 6 digits
        return "#" . str_pad(dechex($codeSum * 0.8), 6, "0", STR_PAD_LEFT);
    }
}
