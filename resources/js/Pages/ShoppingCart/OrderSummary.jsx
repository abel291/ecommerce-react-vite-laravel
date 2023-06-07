
import { formatCurrency } from "../../Helpers/helpers";


const OrderSummary = ({ order }) => {


	return (
		<div className="py-8  space-y-5 text-right border-y border-t border-b border-gray-200">
			<div className=" inline-grid grid-cols-2 gap-3">
				<div className="text-gray-600 ">Sub total</div>
				<div className=" font-medium">{formatCurrency(order.sub_total)}</div>

				<div className="text-gray-600 ">Envío</div>
				<div className=" font-medium">{formatCurrency(order.shipping)}</div>

				<div className=" text-gray-600 ">
					Impuestos
					<span className="  text-gray-400 font-light"> ({order.tax_percent}%)</span>
				</div>
				<div className=" font-medium">{formatCurrency(order.tax_amount)}</div>

				<div className="text-xl font-semibold mt-4">Orden total</div>
				<div className="text-xl font-semibold mt-4">{formatCurrency(order.total)}</div>
			</div>
		</div>

	)
}

export default OrderSummary
