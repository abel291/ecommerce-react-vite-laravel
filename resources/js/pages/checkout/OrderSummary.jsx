import { formatCurrency } from "../../Helpers/helpers";

const OrderSummary = ({ products, charges }) => {
    return (
        <div className="bg-gray-100 rounded-lg p-4 md:p-6 space-y-5">
            <span className="block font-medium text-lg">Resumen del pedido</span>
            {/* <div className="text-sm space-y-1">
                {products.map((product) => (
                    <div className="flex items-start justify-between">
                        <div className="text-gray-600 text-xs pr-4">{product.quantity} x {product.name}</div>
                        <div className="font-semibold whitespace-nowrap">{formatCurrency(product.price)}</div>
                    </div>
                ))}
            </div> */}
            <div className="divide-y divide-gray-300 text-sm">
                <div className="flex items-center justify-between py-4">
                    <div className="text-gray-600">Sub total</div>
                    <div className="font-semibold">{formatCurrency(charges.sub_total)}</div>
                </div>
                <div className="flex items-center justify-between py-4">
                    <div className="text-gray-600">Envío</div>
                    <div className="font-semibold">{formatCurrency(charges.shipping)}</div>
                </div>
                <div className="flex items-center justify-between py-4">
                    <div className="text-gray-600">
                        Estimación de impuestos <span className=" text-gray-400 font-light">({charges.tax_percent * 100}%)</span>
                    </div>
                    <div className="font-semibold">{formatCurrency(charges.tax_amount)}</div>
                </div>
                <div className="flex items-center justify-between py-4 text-base font-semibold">
                    <div className="">Order total</div>
                    <div className="">{formatCurrency(charges.total)}</div>
                </div>
            </div>
        </div>
    )
}

export default OrderSummary
