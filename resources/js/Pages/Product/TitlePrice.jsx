import { formatCurrency } from '@/Helpers/helpers'
import React from 'react'

const TitlePrice = ({ product }) => {
    return (
        <>
            <div className="flex items-center">
                <span className="text-sm font-light">Nuevo | {product.stock.remaining} disponibles</span>
            </div>
            <h2 className="font-bold text-3xl mt-4  ">{product.name}</h2>
            <div className="mt-3 tracking-tight">
                {product.offer != 0 &&
                    <span className="text-xs text-gray-400 font-medium line-through">
                        {formatCurrency(product.price)}
                    </span>
                }
                <div className="flex items-center font-medium">
                    <div className="text-3xl inline-block mr-2">{formatCurrency(product.price_offer)}</div>
                    {product.offer != 0 && <div className="inline-block text-green-500  ">{product.offer}%</div>}
                </div>
            </div>
            <p className="mt-6">{product.description_min}</p></>
    )
}

export default TitlePrice
