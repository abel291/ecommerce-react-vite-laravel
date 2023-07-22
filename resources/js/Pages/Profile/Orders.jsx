
import { useState } from "react";
import { formatCurrency, formatDate } from "../../Helpers/helpers";


import LayoutProfile from "../../Layouts/LayoutProfile";
import OrderStatuBadges from "@/Components/OrderStatuBadges";
import { Head, Link } from "@inertiajs/react";
import Pagination from "@/Components/Pagination";
import Badge from "@/Components/Badge";

const Order = ({ orders }) => {

	const [page, setPage] = useState(1);

	const handleClickChangePage = (number) => {

		setPage(number);
	};

	return (
		<LayoutProfile title="Pedidos" breadcrumb={[
			{
				title: "Ordenes",
				path: route("profile.orders")

			},
		]}>
			<Head title="Pedidos" />


			<div className="space-y-2">

				<table className="table-list">
					<thead>
						<tr>
							<th>Codigo</th>
							<th>Status</th>
							<th>Total</th>
							<th>Fecha</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						{orders.data.map((item, key) => (
							<tr key={key}>
								<td>
									<span className="font-medium">#{item.code}</span>
								</td>

								<td>
									<Badge color={item.payment.status_color} >{item.payment.status}</Badge>
								</td>
								<td>
									<span className="font-medium">{formatCurrency(item.total)}</span> para {item.quantity} producto(s)
								</td>
								<td>
									{formatDate(item.created_at)}
									<span className='text-gray-500 block'>{item.createdAtRelative}</span>
								</td>
								<td className="px-4  text-start">
									<Link preserveScroll className="font-medium text-indigo-600" href={route('profile.order', item.code)}>Detalles</Link>
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
