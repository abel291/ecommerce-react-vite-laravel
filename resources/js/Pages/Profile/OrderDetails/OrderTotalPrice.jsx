import React from 'react'
import { formatCurrency, formatDate } from "../../../Helpers/helpers";
function OrderTotalPrice({ order }) {
    return (
        <div className="mt-8 flex sm:justify-end  pr-3">
            <div className="sm:text-right">

                <div className="space-y-4">
                    <dl className="grid sm:grid-cols-5 gap-x-3 ">
                        <dt className="col-span-3 text-gray-500">Sub total:</dt>
                        <dd className="whitespace-nowrap col-span-2 font-medium  dark:text-gray-200">{formatCurrency(order.sub_total)}</dd>
                    </dl>
                    {order.discount && (
                        <dl className="grid sm:grid-cols-5 gap-x-3 ">
                            <dt className="col-span-3 text-gray-500">Descuento({order.discount.value}%):</dt>
                            <dd className="whitespace-nowrap col-span-2 font-medium text-green-500 dark:text-gray-200">-{formatCurrency(order.discount.applied)}</dd>
                        </dl>
                    )}
                    <dl className="grid sm:grid-cols-5 gap-x-3 ">
                        <dt className="col-span-3 text-gray-500">Envio:</dt>
                        <dd className="whitespace-nowrap col-span-2 font-medium  dark:text-gray-200">{formatCurrency(order.shipping)}</dd>
                    </dl>

                    <dl className="grid sm:grid-cols-5 gap-x-3 ">
                        <dt className="col-span-3 text-gray-500">Estimación de impuestos  {order.tax_rate}%:</dt>
                        <dd className="whitespace-nowrap col-span-2 font-medium  dark:text-gray-200">{formatCurrency(order.tax_value)}</dd>
                    </dl>

                    <dl className="grid sm:grid-cols-5 gap-x-3 ">
                        <dt className="col-span-3 text-gray-500">Total:</dt>
                        <dd className="whitespace-nowrap col-span-2 font-bold  dark:text-gray-200">{formatCurrency(order.total)}</dd>
                    </dl>

                </div>
                {/* End Grid */}
            </div>
        </div>
    )
}

export default OrderTotalPrice
