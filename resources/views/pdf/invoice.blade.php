<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <title>Invoice #{{ $order->code }}</title>
    <style>
        body * {
            font-family: sans-serif;
            font-size: 14px;
        }

        @page {
            margin-bottom: 60px;
        }

        .text-gray-500 {
            color: rgb(107 114 128);
        }

        body section:first-child {
            margin-top: 0px
        }

        body section {
            margin-top: 30px;
        }
    </style>

    <style>
        /*! CSS Used from: http://127.0.0.1:5173/resources/css/app.css */
        *,
        ::before,
        ::after {
            box-sizing: border-box;
            border-width: 0;
            border-style: solid;
            border-color: #E5E7EB;
        }

        ::before,
        ::after {
            --tw-content: '';
        }

        body {
            margin: 0;
            line-height: inherit;
        }

        h1,
        h2,
        h4 {
            font-size: inherit;
            font-weight: inherit;
        }

        table {
            text-indent: 0;
            border-color: inherit;
            border-collapse: collapse;
        }

        h1,
        h2,
        h4,
        p {
            margin: 0;
        }

        :disabled {
            cursor: default;
        }

        *,
        ::before,
        ::after {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-scroll-snap-strictness: proximity;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(63 131 248 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
        }

        .relative {
            position: relative;
        }

        .mt-2 {
            margin-top: 0.5rem;
        }

        .mt-4 {
            margin-top: 1rem;
        }

        .mt-5 {
            margin-top: 1.25rem;
        }

        .inline-table {
            display: inline-table;
        }

        .w-auto {
            width: auto;
        }

        .w-full {
            width: 100%;
        }

        .w-1\/3 {
            width: 33.333333%;
        }

        .rounded {
            border-radius: 0.25rem;
        }

        .border {
            border-width: 1px;
        }

        .bg-gray-100 {
            background-color: rgb(243 244 246);
        }

        .p-2 {
            padding: 0.5rem;
        }

        .py-1 {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
        }

        .pl-7 {
            padding-left: 1.75rem;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-base {
            font-size: 1rem;
            line-height: 1.5rem;
        }

        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem;
        }

        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }

        .text-xl {
            font-size: 1.25rem;
            line-height: 1.75rem;
        }

        .font-semibold {
            font-weight: 600;
        }

        .not-italic {
            font-style: normal;
        }

        .text-gray-500 {

            color: rgb(107 114 128);
        }

        .text-indigo-600 {

            color: rgb(88 80 236);
        }

        .mt-2 {
            margin-top: 0.5rem
                /* 8px */
            ;
        }

        .text-2xl {
            font-size: 1.5rem
                /* 24px */
            ;
            line-height: 2rem
                /* 32px */
            ;
        }

        .border-t {
            border-top-width: 1px;
        }

        .p-3 {
            padding: 0.75rem
                /* 12px */
            ;
        }

        .mt-1 {
            margin-top: 0.25rem
                /* 4px */
            ;
        }

        .border-t-2 {
            border-top-width: 2px;
        }

        .rounded-lg {
            border-radius: 0.5rem
                /* 8px */
            ;
        }

        .h-8 {
            height: 2rem
                /* 32px */
            ;
        }

        .text-indigo-600 {
            color: rgb(88 80 236);
        }

        .font-light {
            font-weight: 300;
        }

        .text-xl {
            font-size: 1.25rem
                /* 20px */
            ;
            line-height: 1.75rem
                /* 28px */
            ;
        }
    </style>

</head>

<body class="relative">

    <section>
        <table class="w-full">
            <tr>
                <td valign="top">
                    <div class="text-indigo-600 text-xl">
                        React <strong class="font-semibold text-xl">Ecommerce</strong>
                    </div>

                    <address class="mt-4 not-italic">
                        45 Roker Terrace
                        Latheronwheel<br>
                        KW5 8NW, London
                        United Kingdom
                    </address>
                </td>
                <td>
                    <div class="text-right">
                        <h2 class="text-xl font-semibold ">
                            Pedido: #3682303
                        </h2>
                        <table class="inline-table w-auto mt-4">
                            <tr>
                                <td class="font-semibold">Fecha de la factura:</td>
                                <td class="text-gray-500">03/10/2018</td>
                            </tr>
                            <tr>
                                <td class="font-semibold">Fecha de vencimiento:</td>
                                <td class="text-gray-500">03/10/2018</td>
                            </tr>
                        </table>


                    </div>
                </td>
            </tr>
        </table>
    </section>

    <section>
        <table class="w-full">
            <tr>
                <td>
                    <div>
                        <div class="font-semibold">Facturado a:</div>
                        <div class="mt-2">
                            <div>{{ $order->user_data->name }}</div>
                            <div class="mt-1">{{ $order->user_data->email }}</div>
                            <div class="mt-1">{{ $order->user_data->phone }}</div>
                            <address class="mt-1 not-italic ">
                                {{ $order->user_data->address }}<br>
                                {{ $order->user_data->city }}
                            </address>
                        </div>
                    </div>
                </td>
                <td valign="bottom ">
                    <div class="text-right">

                    </div>
                </td>
            </tr>
        </table>
    </section>

    <section>
        <div class="border rounded-lg">
            <table class="w-full">
                <thead>
                    <tr class="">
                        <th class=" text-left p-3 ">Item</th>
                        <th class=" text-left p-3 ">Precio</th>
                        <th class=" text-left p-3 ">Cantidad</th>
                        <th class=" text-right p-3 ">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->order_products as $item)
                        <tr class="border-t">
                            <td class="text-left p-3">{{ $item->name }}</td>
                            <td class="text-left p-3">@money($item->price)</td>
                            <td class="text-left p-3">{{ $item->quantity_selected }}</td>
                            <td class="text-right p-3">@money($item->price_quantity)</td>
                        </tr>
                    @endforeach
                    <tr class="border-t-2">
                        <td class="p-3"></td>
                        <td class="p-3"></td>
                        <td class="p-3 font-semibold text-right">Subtotal:</td>
                        <td class="p-3 text-right font-semibold ">@money($order->sub_total)</td>
                    </tr>
                    <tr class="border-t ">
                        <td class="p-3"></td>
                        <td class="p-3"></td>
                        <td class="p-3 font-semibold text-right">Tax ({{ $order->tax_percent }}%):</td>
                        <td class="p-3 text-right font-semibold">
                            @money($order->tax_amount)
                        </td>
                    </tr>
                    <tr class="border-t ">
                        <td class="p-3"></td>
                        <td class="p-3"></td>
                        <td class="p-3 font-semibold text-right">Envio:</td>
                        <td class="p-3 text-right font-semibold">
                            @money($order->shipping)
                        </td>
                    </tr>
                    <tr class="border-t ">
                        <td class="p-3"></td>
                        <td class="p-3"></td>
                        <td class="p-3 font-semibold text-right">Total:</td>
                        <td class="p-3 text-right font-semibold">
                            @money($order->total)
                        </td>
                    </tr>


                </tbody>
            </table>
        </div>
    </section>

    <section>
        <div>
            <h4 class="text-lg font-semibold title">¡Gracias!</h4>
            <p class="mt-2">
                Si tiene alguna pregunta sobre esta factura, utilice la siguiente información de contacto:
            </p>
            <div class="mt-2">
                <p>example@site.com </p>
                <p>+1 (062) 109-9222</p>
            </div>
            <p class="mt-2 text-sm text-gray-500">© {{ date('Y') }} React Ecommerce Inc.</p>
        </div>
    </section>


</body>

</html>
