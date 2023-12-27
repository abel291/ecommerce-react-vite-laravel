import { formatCurrency } from '@/Helpers/helpers'
import CartAttributes from '@/Pages/ShoppingCart/CartAttributes'
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
                    {order.products.map((product, index) => (
                        <tr key={index}>
                            <td>
                                {product.data.name}
                                {product.attributes.map((attribute, index) => (
                                    <div key={index} className='ml-2 flex gap-x-1.5 text-xs mb-0.5 text-gray-500'>
                                        <div>{attribute.name}:</div>
                                        <div>{attribute.value}</div>
                                    </div>
                                ))}
                            </td>
                            <td className='whitespace-nowrap' >{formatCurrency(product.price)}</td>
                            <td>{product.quantity}</td>
                            <td className='whitespace-nowrap'>{formatCurrency(product.total)}</td>
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
