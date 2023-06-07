import { formatCurrency } from '@/Helpers/helpers'
import React from 'react'

function OrderItemsList({ order }) {
	return (
		<div>
			<table className="table-list w-full">
				<thead>
					<tr>
						<th>Item</th>
						<th>Precio</th>
						<th>Cantidad</th>
						<th>Monto</th>
					</tr>
				</thead>
				<tbody>
					{order.products.map((product) => (
						<tr key={product.id}>
							<td >{product.name}</td>
							<td >{formatCurrency(product.price)}</td>
							<td>{product.quantity_selected}</td>
							<td>{formatCurrency(product.price_quantity)}</td>
						</tr>
					))}
					{/* <tr>
						<td></td>
						<td></td>
						<td className="text-gray-500">Sub total:</td>
						<td className="font-medium">{formatCurrency(order.sub_total)}</td>
					</tr>

					<tr>
						<td></td>
						<td></td>
						<td className="text-gray-500">Envio:</td>
						<td className="font-medium">{formatCurrency(order.shipping)}</td>
					</tr>

					<tr>
						<td></td>
						<td></td>
						<td className="text-gray-500">Estimación de impuestos  ({order.tax_percent * 100}%):</td>
						<td className="font-medium">{formatCurrency(order.tax_amount)}</td>
					</tr>

					<tr>
						<td></td>
						<td></td>
						<td className="text-gray-500">Cantidad a pagar:</td>
						<td className="font-semibold">{formatCurrency(order.total)}</td>
					</tr> */}

				</tbody>
			</table>
		</div>
	)
}

export default OrderItemsList