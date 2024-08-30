import { MinusIcon, PlusIcon } from '@heroicons/react/24/solid'
import { useForm } from '@inertiajs/react'
import React, { useEffect } from 'react'

const SelectQuantity = ({ maxQuantity, form, selectedSkuSize }) => {

    const handleClickQuantity = (i) => {
        switch (i) {
            case "up":
                if (form.data.quantity >= maxQuantity) {
                    return
                }
                form.setData('quantity', form.data.quantity + 1)
                break
            case "down":
                if (form.data.quantity <= 1) {
                    return
                }
                form.setData('quantity', form.data.quantity - 1)

                break
            default:
                break
        }
    }
    return (
        <>
            <div>
                <div className="flex space-x-3 items-stretch mt-8">
                    <div className="flex items-center border border-gray-200 rounded-md divide-gray-200 divide-x bg-white  h-10">
                        <button onClick={() => handleClickQuantity("down")} className=" flex items-center px-4 h-full">
                            <MinusIcon className="h-4 w-4" />
                        </button>
                        <span id="countQuantity" className=" flex items-center  h-full w-14 justify-center">
                            {form.data.quantity}
                        </span>
                        <button disabled={form.data.quantity == maxQuantity} onClick={() => handleClickQuantity("up")} className="disabled:opacity-20 flex items-center px-4 h-full">
                            <PlusIcon className="h-4 w-4" />
                        </button>
                    </div>

                    <div className="flex items-center">
                        <span className=" text-sm font-light text-gray-400">( {selectedSkuSize ? selectedSkuSize.stock : 0} disponibles )</span>
                    </div>
                </div>
                <span className='text-xs text-gray-400'>Max unidades por compra : {maxQuantity}</span>
            </div>


        </>


    )
}

export default SelectQuantity
