import { useState } from "react";
import { useQuery } from "react-query";
import { useParams } from "react-router-dom";
import Button from "../../components/Button";
import LoadingPage from "../../components/LoadingPage";
import OrderStatuBadges from "../../components/OrderStatuBadges";
import PageError from "../../components/PageError";
import Pagination from "../../components/Pagination";
import { formatCurrency, formatDate } from "../../Helpers/helpers";
import useAuth from "../../hooks/useAuth";
import usePage from "../../hooks/usePage";
import apiClient from "../apiClient";

const OrderDetails = () => {
	const { code } = useParams();
	const [page, setPage] = useState(1);
	const { data, isLoading, error } = useQuery(
		["orderDetails", code],

		async () => {
			const response = await apiClient
				.get("/auth/user/order-details/" + code)
				.then((response) => {
					return response.data;
				});
			return response;
		},
		{
			retry: 0,
			staleTime: Infinity,
			notifyOnChangePropsExclusions: ["isStale"],
		}
	);

	console.log(data);

	if (isLoading) return "Cargando....";

	if (error) return <PageError />;

	return (
		<>
			<div className="space-y-2 text-sm">
				<div className="flex items-center">
					<span className="mr-2 font-semibold">Nombre:</span>
					{data.order.user_data.name}
				</div>
				<div className="flex items-center">
					<span className="mr-2 font-semibold">Telefono:</span>
					{data.order.user_data.phone}
				</div>
				<div className="flex items-center">
					<span className="mr-2 font-semibold">Email:</span>
					{data.order.user_data.email}
				</div>

				<div className="flex items-center">
					<span className="mr-2 font-semibold">Fecha de Compra:</span>
					{formatDate(data.order.created_at)}
				</div>
			</div>
			<div className="mt-5">
				<table className="w-full table-fixed overflow-hidden rounded-lg text-sm">
					<thead>
						<tr>
							<th className="text-heading bg-gray-100 p-3 text-left font-semibold">
								Pedido
							</th>
							<th className="text-heading bg-gray-100 p-3 text-left font-semibold">
								Monto
							</th>
						</tr>
					</thead>
					<tbody className="divide-y divide-gray-200  ">
						{data.order.products.map((product, index) => (
							<tr key={index}>
								<td className="p-3">
									{product.quantity} x {product.name}
								</td>
								<td className="p-3">
									{formatCurrency(product.price_quantity)}
								</td>
							</tr>
						))}
						<tr className="bg-gray-100 font-semibold italic">
							<td className="p-3 ">Subtotal</td>
							<td className="p-3">{formatCurrency(data.order.sub_total)}</td>
						</tr>

						<tr className="font-semibold italic">
							<td className="p-3 ">
								Impuestos ({data.order.tax_percent * 100}%)
							</td>
							<td className="p-3">{formatCurrency(data.order.tax_amount)}</td>
						</tr>
						<tr className="font-semibold italic">
							<td className="p-3 ">Envio</td>
							<td className="p-3">{formatCurrency(data.order.shipping)}</td>
						</tr>
						<tr className="text-xl  font-bold">
							<td className="p-3 ">Total</td>
							<td className="p-3">{formatCurrency(data.order.total)}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</>
	);
};

export default OrderDetails;
