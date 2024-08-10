import Layout from "@/Layouts/Layout";
import { formatCurrency, formatDate } from "../../Helpers/helpers";
import { CheckCircleIcon, XMarkIcon } from "@heroicons/react/24/solid";
import { Head, usePage } from "@inertiajs/react";
import LayoutProfile from "../../Layouts/LayoutProfile";
import OrderStatuBadges from "@/Components/OrderStatuBadges";
import SectionTitle from "@/Components/Sections/SectionTitle";
import PrimaryButton from "@/Components/PrimaryButton";
import { PaperClipIcon } from "@heroicons/react/24/outline";

const OrderComplete = ({ order, products }) => {
	const { flash } = usePage().props
	return (
		<LayoutProfile>
			<Head title="Pedidos" />
			<div className="space-y-8">
				{flash.success && (
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
						</div>
					</div>
				)}
				<div className="space-y-2">
					<div className="flex items-center">
						<span className="mr-2 font-medium">Codigo:</span>
						{order.code}
					</div>
					<div className="flex items-center">
						<span className="mr-2 font-medium">Nombre:</span>
						{order.user.name}
					</div>
					<div className="flex items-center">
						<span className="mr-2 font-medium">Telefono:</span>
						{order.user.phone}
					</div>
					<div className="flex items-center">
						<span className="mr-2 font-medium">Email:</span>
						{order.user.email}
					</div>

					<div className="flex items-center">
						<span className="mr-2 font-medium">Fecha de Compra:</span>
						{formatDate(order.created_at)}
					</div>
					<div className="flex items-center">
						<span className="mr-2 font-medium">Status de pago:</span>
						<OrderStatuBadges status={order.payment.status} />
					</div>
				</div>
				{/* <div>
					<div className="flex flex-col md:flex-row justify-between rounded-md border bg-gray-50 border-gray-200 divide-y md:divide-y-0 md:divide-x divide-gray-200">
						<div className="p-3 md:p-5">
							<span className="text-xs text-gray-500 font-light">Numero de orden</span>
							<div className="font-semibold text-lg ">{order.code}</div>
						</div>
						<div className="p-3 md:p-5">
							<span className="text-xs text-gray-500 font-light">Fecha</span>
							<div className="font-semibold text-lg ">{order.created_at}</div>
						</div>
						<div className="p-3 md:p-5">
							<span className="text-xs text-gray-500 font-light">Total</span>
							<div className="font-semibold text-lg ">{formatCurrency(order.total)}</div>
						</div>
						<div className="p-3 md:p-5">
							<span className="text-xs text-gray-500 font-light">Email</span>
							<div className="font-semibold text-lg ">{order.user.email}</div>
						</div>
						<div className="p-3 md:p-5">
							<span className="text-xs text-gray-500 font-light">Metodo de Pago</span>
							<div className="font-semibold text-lg ">Contra Entrega</div>
						</div>
					</div>
				</div> */}
				<div className="flex justify-between items-center">
					<SectionTitle title="Detalles de orden" />
					<div>

						<PrimaryButton Icon={PaperClipIcon}> Descargar Orden </PrimaryButton>
					</div>
				</div>
				<div >
					<table className=" w-full table-fixed rounded-md overflow-hidden">
						<thead>
							<tr className="bg-gray-100">
								<th className="w-1/2 text-left px-2 md:px-4 py-3">Producto</th>
								<th className="w-1/2 text-left px-2 md:px-4 py-3">Total</th>
							</tr>
						</thead>
						<tbody className="divide-y divide-gray-200">
							{order.products.map((product) => (
								<tr key={product.id}>
									<td className="px-2 md:px-4 py-3">
										{product.quantity_selected} * {product.name}
									</td>
									<td>{formatCurrency(product.price_quantity)}</td>
								</tr>
							))}
							<tr>
								<td className="px-2 md:px-4 py-3 italic font-semibold">Sub-Total</td>
								<td className="font-semibold">{formatCurrency(order.sub_total)}</td>
							</tr>
							<tr>
								<td className="px-2 md:px-4 py-3 italic font-semibold">Envío</td>
								<td className="font-semibold">{formatCurrency(order.shipping)}</td>
							</tr>
							<tr>
								<td className="px-2 md:px-4 py-3 italic font-semibold">Metodo de pago</td>
								<td className="font-semibold">Contra Entrega</td>
							</tr>
							<tr>
								<td className="px-2 md:px-4 py-3 italic font-semibold">
									Estimación de impuestos
									<span className=" text-gray-400 font-light text-sm"> ({order.tax_percent * 100}%)</span>
								</td>
								<td className="font-semibold">{formatCurrency(order.tax_amount)}</td>
							</tr>
							<tr>
								<td className="px-2 md:px-4 py-3 italic font-semibold">Order total</td>
								<td className="font-semibold">{formatCurrency(order.total)}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</LayoutProfile>
	)
}

export default OrderComplete
