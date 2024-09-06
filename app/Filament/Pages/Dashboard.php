<?php

use App\Models\Category;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;


    public static function filterDateSelected($selectMonth)
    {
        if (!$selectMonth)
            return null;
        return match ($selectMonth) {
            'today' => now()->startOfMonth(),
            'm1' => now()->subMonths(1)->startOfMonth(),
            'm2' => now()->subMonths(6)->startOfMonth(),
            'm3' => now()->subMonths(12)->startOfMonth(),
        };
    }
    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('select_month')->label('Filtrar por mes')
                            ->options([
                                'today' => 'Este mes',
                                'm1' => 'Mes Pasado',
                                'm2' => 'Ultimos 6 meses',
                                'm3' => 'Ultimos 12 meses',
                            ])
                            ->default('today')

                    ])
                    ->columns(3),
            ]);
    }
}
