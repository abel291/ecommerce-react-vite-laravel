
import { formatCurrency } from "../../Helpers/helpers";


const OrderSummary = ({ charges }) => {


	return (
		<div className="py-8  space-y-5 text-right border-y border-t border-b border-gray-200">
			<div className=" inline-grid grid-cols-2 gap-3">
				<div className="text-gray-600 ">Sub total</div>
				<div className=" font-medium">{formatCurrency(charges.sub_total)}</div>

				<div className="text-gray-600 ">Envío</div>
				<div className=" font-medium">{formatCurrency(charges.shipping)}</div>

				<div className=" text-gray-600 ">
					Impuestos
					<span className="  text-gray-400 font-light"> ({charges.tax_percent * 100}%)</span>
				</div>
				<div className=" font-medium">{formatCurrency(charges.tax_amount)}</div>

				<div className="text-xl font-semibold mt-4">Orden total</div>
				<div className="text-xl font-semibold mt-4">{formatCurrency(charges.total)}</div>
			</div>
		</div>

	)
}

export default OrderSummary
