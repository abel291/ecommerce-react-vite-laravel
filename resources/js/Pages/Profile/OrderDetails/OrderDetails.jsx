

import { CheckCircleIcon } from "@heroicons/react/24/solid";
import { Head, usePage } from "@inertiajs/react";
import LayoutProfile from "../../../Layouts/LayoutProfile";
import SectionTitle from "@/Components/Sections/SectionTitle";
import { ArrowDownTrayIcon } from "@heroicons/react/24/outline";
import BuyerDetails from "./BuyerDetails";
import OrderItemsList from "./OrderItemsList";
import OrderTotalPrice from "./OrderTotalPrice";
import Badge from "@/Components/Badge";


const OderDetails = ({ order }) => {
	const { flash } = usePage().props

	return (
		<LayoutProfile>
			<Head title={"Pedido #" + order.code} />

			<div className="space-y-8">
				<div className="flex items-center justify-between ">
					<SectionTitle className="flex items-center">
						<span>Pedido: #  {order.code}</span>
						<Badge className="ml-3" color={order.payment.status_color}>{order.payment.status}</Badge>
					</SectionTitle>
					<div className="inline-flex gap-x-2">

						<a className="btn btn-secondary flex items-center gap-x-2" target="_black" href={route('profile.invoice', order.code)}>
							<ArrowDownTrayIcon className="w-4 h-4" />
							Descargar factura
						</a>

					</div>
				</div>
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
								<span className="text-green-600 ">
									{flash.success}
								</span>
							</div>
						</div>
					</div>
				)}

				{/* Invoice */}

				<BuyerDetails order={order} />

				<OrderItemsList order={order} />

				<OrderTotalPrice order={order} />


			</div>
		</LayoutProfile >
	)
}



export default OderDetails
