
import { useState } from "react";
import { formatCurrency, formatDate } from "../../Helpers/helpers";


import LayoutProfile from "../../Layouts/LayoutProfile";
import OrderStatuBadges from "@/Components/OrderStatuBadges";
import { Head, Link } from "@inertiajs/react";
import Pagination from "@/Components/Pagination";

const Order = ({ orders }) => {

	const [page, setPage] = useState(1);

	const handleClickChangePage = (number) => {
		console.log(number)
		setPage(number);
	};

	return (
		<LayoutProfile>
			<Head title="Ordenes" />
			<div className="space-y-2">
				<h3 className="mb-6 text-2xl font-bold">Ordenes</h3>
				<table className="w-full">
					<thead>
						<tr className="bg-gray-100 ">
							<th className="text-heading bg-gray-100 p-4 text-start font-semibold rounded-tl-lg ">
								Order
							</th>
							<th className="text-heading bg-gray-100 p-4 text-start font-semibold">
								Fecha
							</th>
							<th className="text-heading bg-gray-100 p-4 text-start font-semibold">
								Status
							</th>
							<th className="text-heading bg-gray-100 p-4 text-start font-semibold">
								Total
							</th>
							<th className="text-heading bg-gray-100 p-4 text-start font-semibold rounded-tr-lg">
								Acciones
							</th>
						</tr>
					</thead>
					<tbody>
						{orders.data.map((item, key) => (
							<tr key={key}>
								<td className="px-4 py-5 text-start">#{item.code}</td>
								<td className="px-4 py-5 text-start">
									{formatDate(item.created_at)}
								</td>
								<td className="px-4 py-5 text-start">
									<OrderStatuBadges status={item.status} />
								</td>
								<td className="px-4 py-5 text-start">
									<span className="font-medium">{formatCurrency(item.total)}</span> para {item.quantity} Productos
								</td>
								<td className="px-4  text-start">
									<Link preserveScroll className="font-medium text-blue-500" href={route('order', item.code)}>Detalles</Link>
								</td>
							</tr>
						))}
					</tbody>
				</table>
				<div>
					<div className="mt-8">
						{orders.meta.total > orders.meta.per_page && (
							<div className="mt-8">
								<Pagination paginator={orders.meta} />
							</div>
						)}
					</div>
				</div>
			</div>
		</LayoutProfile>
	);
};

export default Order;
