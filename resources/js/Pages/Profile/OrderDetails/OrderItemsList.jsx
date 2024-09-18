
import { formatCurrency } from '@/Helpers/helpers'
import React from 'react'

function OrderItemsList({ order }) {

    return (
        <div>
            <table className="table-list">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Item</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    {order.products.map((product, index) => (
                        <tr key={index}>
                            <td className='whitespace-nowrap'>
                                <img className="h-16 max-w-full rounded " src={product.thumb} alt={product.name} />

                            </td>
                            <td className='align-top'>
                                {product.name}
                                <div key={index} className='flex gap-x-1.5 text-xs mt-1 text-gray-500'>
                                    <div>Color {product.color.name}</div>
                                    {product.size && (
                                        <div className='border-l border-gray-300 pl-1.5'> Talla {product.size.name}</div>
                                    )}

                                </div>
                            </td>
                            <td className='whitespace-nowrap' >
                                <PriceOffer price={product.price}
                                    old_price={product.old_price}
                                    offer={product.offer} />
                                {/* {formatCurrency(product.price)} */}
                            </td>
                            <td>{product.quantity}</td>
                            <td className='whitespace-nowrap'>{formatCurrency(product.total)}</td>
                        </tr>
                    ))}

                </tbody>
            </table>
        </div >
    )
}

function PriceOffer({ price, old_price, offer }) {
    return (
        <div className='text-sm'>
            <span >
                {formatCurrency(price)}
            </span>
            {(offer > 0) && (
                <div className='flex gap-x-1'>
                    <div className="inline-block text-green-500 text-xs font-semibold">
                        -{offer}%
                    </div>
                    <div className="text-xs text-gray-400 line-through">
                        {formatCurrency(old_price)}
                    </div>
                </div>
            )}
        </div>
    )
}

export default OrderItemsList
