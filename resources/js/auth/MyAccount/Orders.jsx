import { useState } from "react";
import { useQuery } from "react-query";
import { Link } from "react-router-dom";
import Button from "../../components/Button";
import LoadingPage from "../../components/LoadingPage";
import OrderStatuBadges from "../../components/OrderStatuBadges";
import PageError from "../../components/PageError";
import Pagination from "../../components/Pagination";
import { formatCurrency, formatDate } from "../../Helpers/helpers";
import useAuth from "../../hooks/useAuth";
import usePage from "../../hooks/usePage";
import apiClient from "../apiClient";

const Order = () => {

	const [page, setPage] = useState(1);
	const { data, isLoading, error } = useQuery(
		["orders", page],

		async ({ page = 1 }) => {
			const response = await apiClient
				.get("/auth/user/orders", {
					params: {
						page: page,
					},
				})
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
	const handleClickChangePage = (number) => {
		setPage(number);
	};
	console.log(data);

	if (isLoading) return "Cargando....";

	if (error) return <PageError />;

	return (
		<div className="space-y-2">
			<h3 className="mb-6 text-2xl font-bold">Ordenes</h3>
			<table className="w-full">
				<thead>
					<tr className="bg-gray-100 ">
						<th className="text-heading bg-gray-100 p-4 text-start font-semibold">
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
						<th className="text-heading bg-gray-100 p-4 text-start font-semibold">
							Acciones
						</th>
					</tr>
				</thead>
				<tbody className="text-sm">
					{data.orders.data.map((item, key) => (
						<tr>
							<td className="px-4 py-5 text-start">#{item.code}</td>
							<td className="px-4 py-5 text-start">
								{formatDate(item.created_at)}
							</td>
							<td className="px-4 py-5 text-start">
								<OrderStatuBadges status={item.status} />
							</td>
							<td className="px-4 py-5 text-start">
								{formatCurrency(item.total)} para {item.quantity} Productos
							</td>
							<td className="px-4  text-start">
								<Link className="btn btn-default" to={"/my-account/order-details/" + item.code}>Detalles</Link>
							</td>
						</tr>
					))}
				</tbody>
			</table>
			<div>
				<div className="mt-8">
					<Pagination
						paginator={data.orders}
						handleClickChangePage={handleClickChangePage}
					/>
				</div>
			</div>
		</div>
	);
};

export default Order;
