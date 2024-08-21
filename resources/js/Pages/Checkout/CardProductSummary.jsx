import { formatCurrency } from '@/Helpers/helpers'
import React from 'react'

const CardProductSummary = ({ product }) => {
    return (
        <div className="flex p-5 md:p-6" key={product.id}>
            <div className="">
                <img className=" h-20 max-w-full rounded-md" src={product.thumb} alt={product.name} />
            </div>
            <div className="grow px-5">
                <h3>{product.name}</h3>
                <div className=" text-gray-500 mt-1 font-normal"> Color: {product.presentation.color.name}</div>
                <div className=" text-gray-500 mt-1 font-normal">Talla: {product.presentation.size.name}</div>
            </div>
            <div className="font-medium whitespace-nowrap text-base ">{formatCurrency(product.total)}</div>
        </div>
    )
}

export default CardProductSummary
