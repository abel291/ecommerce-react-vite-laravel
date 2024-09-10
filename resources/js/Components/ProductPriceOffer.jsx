import { formatCurrency } from '@/Helpers/helpers'
import React from 'react'

const ProductPriceOffer = ({ price, old_price, offer }) => {
    return (
        <div>
            {offer > 0 ? (
                <>
                    <div className="text-xs text-gray-400 line-through">
                        {formatCurrency(old_price)}
                    </div>
                    <div className="flex items-center">
                        <div className="text-lg inline-block mr-2 font-semibold">
                            {formatCurrency(price)}
                        </div>
                        <div className="inline-block text-green-500 text-xs font-semibold">
                            {offer}%
                        </div>
                    </div>
                </>
            ) : (
                <div className="mr-2 text-lg font-semibold">
                    {formatCurrency(price)}
                </div>
            )}
        </div>
    )
}

export default ProductPriceOffer
