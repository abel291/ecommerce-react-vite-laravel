import { formatCurrency } from "../../Helpers/helpers";
import { CheckCircleIcon, XMarkIcon } from "@heroicons/react/24/solid";

const OrderComplete = ({ charges, products }) => {

	return (
		<div className="container py-content max-w-6xl space-y-8">
			<div >
				<div className="bg-green-100 p-2 md:p-4 flex items-start space-x-2 rounded-md">
					<div>
						<CheckCircleIcon className="h-6 w-6 text-green-400" />
					</div>
					<div className="text-green-700 flex-grow">
						<span className="font-semibold block text-green-600">
							Gracias. Tu orden ha sido recibida.
						</span>
						<span className="text-green-600  font-light">
							Paga en efectivo al momento de la entrega
						</span>
					</div>

					<button type="button" onClick={(e) => setShow(false)} className="outline-none focus:outline-none">
						<XMarkIcon className="h-5 w-5 text-green-500" />
					</button>
				</div>
			</div>
			<div >
				<div className="flex flex-col md:flex-row justify-between rounded-md border bg-gray-50 border-gray-200 divide-y md:divide-x divide-gray-200">
					<div className="p-3 md:p-5">
						<span className="text-xs text-gray-500 font-light">Numero de orden</span>
						<div className="font-semibold text-lg ">XRQ4567</div>
					</div>
					<div className="p-3 md:p-5">
						<span className="text-xs text-gray-500 font-light">Fecha</span>
						<div className="font-semibold text-lg ">22/12/2022</div>
					</div>
					<div className="p-3 md:p-5">
						<span className="text-xs text-gray-500 font-light">Total</span>
						<div className="font-semibold text-lg ">{formatCurrency(charges.total)}</div>
					</div>
					<div className="p-3 md:p-5">
						<span className="text-xs text-gray-500 font-light">Email</span>
						<div className="font-semibold text-lg ">{user.email}</div>
					</div>
					<div className="p-3 md:p-5">
						<span className="text-xs text-gray-500 font-light">Metodo de Pago</span>
						<div className="font-semibold text-lg ">Contra Entrega</div>
					</div>
				</div>
			</div>
			<h3 className=" text-2xl font-semibold">Detalles de orden</h3>
			<div >
				<table className=" w-full table-fixed rounded-md overflow-hidden">
					<thead>
						<tr className="bg-gray-100">
							<th className="w-1/2 text-left px-2 md:px-4 py-3">Producto</th>
							<th className="w-1/2 text-left px-2 md:px-4 py-3">Total</th>
						</tr>
					</thead>
					<tbody className="divide-y divide-gray-200">
						{products.map((product) => (
							<tr key={product.id}>
								<td className="px-2 md:px-4 py-3">
									{product.name} * {product.quantity}
								</td>
								<td>{formatCurrency(product.total_price_quantity)}</td>
							</tr>
						))}
						<tr>
							<td className="px-2 md:px-4 py-3 italic font-semibold">Sub-Total</td>
							<td className="font-semibold">{formatCurrency(charges.sub_total)}</td>
						</tr>
						<tr>
							<td className="px-2 md:px-4 py-3 italic font-semibold">Envío</td>
							<td className="font-semibold">{formatCurrency(charges.shipping)}</td>
						</tr>
						<tr>
							<td className="px-2 md:px-4 py-3 italic font-semibold">Metodo de pago</td>
							<td className="font-semibold">Contra Entrega</td>
						</tr>
						<tr>
							<td className="px-2 md:px-4 py-3 italic font-semibold">
								Estimación de impuestos
								<span className=" text-gray-400 font-light text-sm"> ({charges.tax_percent * 100}%)</span>
							</td>
							<td className="font-semibold">{formatCurrency(charges.tax_amount)}</td>
						</tr>
						<tr>
							<td className="px-2 md:px-4 py-3 italic font-semibold">Order total</td>
							<td className="font-semibold">{formatCurrency(charges.total)}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	)
}

export default OrderComplete
