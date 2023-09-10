
import { formatCurrency } from "../../Helpers/helpers";


const OrderSummary = ({ total }) => {


    return (
        <div className="py-6  text-right border-y border-t border-b border-gray-200">

            <div className="inline-block space-y-3">
                <div className=" grid grid-cols-2 gap-x-4">
                    <div className="text-gray-600 ">Sub total</div>
                    <div className=" font-medium">{formatCurrency(total.subtotal)}</div>
                </div>
                <div className=" grid grid-cols-2 gap-x-4">
                    <div className="text-gray-600 ">Impuestos {total.tax_rate}%</div>
                    <div className=" font-medium">{formatCurrency(total.tax_value)}</div>
                </div>
                <div className=" grid grid-cols-2 gap-x-4">
                    <div className="text-gray-600 ">Envio</div>
                    <div className=" font-medium">{formatCurrency(total.shipping)}</div>
                </div>
                <div className="grid grid-cols-2 gap-x-4 ">
                    <div className="text-xl font-semibold mt-4">Total</div>
                    <div className="text-xl font-semibold mt-4">{formatCurrency(total.total)}</div>
                </div>
            </div>
        </div>


    )
}

export default OrderSummary
