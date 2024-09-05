import { formatCurrency } from '@/Helpers/helpers'
import React from 'react'

const CardProductPrice = ({ price, old_price, offer }) => {
    return (
        <div className='text-right'>
            <span className="text-lg font-semibold">
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

export default CardProductPrice
