import InputError from '@/Components/Form/InputError'
import PrimaryButton from '@/Components/PrimaryButton'
import SecondaryButton from '@/Components/SecondaryButton'
import { ShoppingCartIcon } from '@heroicons/react/24/outline'

import React, { useState } from 'react'

const ButtonsProcessing = ({ form }) => {

    const [processing, setProcessing] = useState('')
    const handleClickAddProductToCart = () => {
        form.post(route('shopping-cart.store'), {
            preserveScroll: true,
            onStart: visit => { setProcessing('shoppingCart') },
            onFinish: visit => { setProcessing('') },
        })
    }

    const handleClickBuyProduct = () => {
        form.post(route('checkout.add-single-product'), {
            preserveScroll: true,
            onStart: visit => { setProcessing('checkout') },
            onFinish: visit => { setProcessing('') },
        })
    }
    return (
        <>
            <div className="flex flex-row items-center space-x-2 mt-8">
                <SecondaryButton disabled={!form.data.codePresentation} type="button" Icon={ShoppingCartIcon} isLoading={processing == "shoppingCart"} onClick={handleClickAddProductToCart}>
                    Agregar al Carrito
                </SecondaryButton>

                <PrimaryButton disabled={!form.data.codePresentation} isLoading={processing == "checkout"} onClick={handleClickBuyProduct}>
                    <div className="inline-flex ">
                        <span className=" text-sm font-semibold">Comprar ahora </span>
                    </div>
                </PrimaryButton>
            </div>
            <InputError className="mt-3" message={form.errors.quantity} />
            <InputError className="mt-3" message={form.errors.product_id} />
        </>
    )
}

export default ButtonsProcessing
