<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentMethodEnum;
use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Actions;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Number;
use Livewire\Attributes\On;
use Filament\Infolists\Components\Actions as ComponentsActions;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Support\Enums\Alignment;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    public function getTitle(): string
    {

        return "Venta {$this->record->code} - " . Number::currency($this->record->total);
    }

    #[On('refreshViewOrder')]
    public function refresh(): void {}

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([

                Grid::make(3)
                    ->schema([
                        ComponentsActions::make([
                            Action::make('status-change')->label('Cancelar Compra')
                                ->color('danger')
                                ->link()
                                ->icon('heroicon-o-x-circle')
                                ->visible(fn($record) => ($record->status == OrderStatusEnum::SUCCESSFUL))

                                ->requiresConfirmation()
                                ->modalIcon('heroicon-o-x-circle')
                                ->form([
                                    Toggle::make('refund')->label(fn(Order $record) => 'Rembolsar dinero ' . Number::currency($record->total))->onColor('danger')->required(),
                                ])
                                ->action(function (array $data, Order $record) {
                                    if ($data['refund']) {
                                        $record->status = OrderStatusEnum::REFUNDED;
                                    } else {
                                        $record->status = OrderStatusEnum::CANCELLED;
                                    }
                                    $record->refund_at = now();
                                    $record->save();
                                    Notification::make()
                                        ->title("La venta {$record->code} " . Number::currency($record->total) . " fue cancelada")
                                        ->success()
                                        ->send();
                                }),


                        ])->columns(4)->columnStart(2)->alignment(Alignment::End),
                        Section::make([

                            TextEntry::make('data.user.name')->label('Cliente'),
                            TextEntry::make('data.user.phone')->label('Telefono'),
                            TextEntry::make('data.user.email')->label('Email'),
                            // TextEntry::make('data.user.nit')->label('Nit'),
                            // TextEntry::make('location.nameType')->label('Ubicacion'),
                            // TextEntry::make('user.name')->label('Vendedor'),
                            TextEntry::make('status')->label('Estado')->badge(),

                            ViewEntry::make('order_products')->columnSpanFull()->view('filament.infolists.sales-view')
                        ])
                            ->columnSpan(2)
                            ->columns(4),

                        Grid::make(1)

                            ->columnSpan(1)
                            ->schema([
                                Section::make([
                                    TextEntry::make('created_at')->label('Fecha de  la venta')->dateTime(),
                                    TextEntry::make('refund_at')->visible(fn($state) => $state)->label('Fecha de devolucion')->dateTime(),

                                ])->columnSpan(1),

                                Section::make('Pago')
                                    // ->visible(fn($record) => $record->payment)
                                    ->columns(2)
                                    ->schema([
                                        TextEntry::make('payment.method')->badge()->label('Metodo de pago'),
                                        TextEntry::make('payment.reference')->label('Referencia'),
                                        TextEntry::make('payment.note')->columnSpanFull()->label('Observacion')->placeholder('- sin observacion')
                                    ]),
                                // Section::make('Pagos')
                                //     ->visible(fn($record) => $record->payment_type == PaymentMethodEnum::CREDIT)
                                //     ->columns(2)
                                //     ->schema([
                                //         TextEntry::make('payment_type')->label('Tipo de pago')->badge(),
                                //         TextEntry::make('payments')->label('Abonos realizados')->numeric()
                                //             ->state(fn(Sale $record) => $record->payments->count()),
                                //         TextEntry::make('pendingPayments')->label('Saldo pendiente')->money(locale: 'de')
                                //             ->state(fn(Sale $record) => $record->pendingPayments()),
                                //         TextEntry::make('totalPayments')->label('Saldo pagado')->money(locale: 'de')
                                //             ->state(fn(Sale $record) => $record->totalPayments()),
                                //     ])
                            ])
                    ]),



            ]);
    }
}
