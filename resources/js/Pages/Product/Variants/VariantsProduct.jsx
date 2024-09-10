import React, { createContext, useEffect, useState } from 'react'
import ColorVariants from './ColorVariants';
import SelectSkuSize from './SelectSkuSize';
import SelectQuantity from './SelectQuantity';
import { Link, useForm, usePage } from '@inertiajs/react';
import ButtonsProcessing from './ButtonsProcessing';

const VariantsProduct = () => {
    const { product, variants } = usePage().props
    const [selectedSkuSize, setSelectedSkuSize] = useState(null)

    const form = useForm({
        quantity: 1,
        skuId: null
    })

    useEffect(() => {
        console.log(variants[0])

        let newSelectedSkuSize = product.skus.find((sku) => {
            return sku.stock > 0
        })

        if (newSelectedSkuSize) {
            setSelectedSkuSize(newSelectedSkuSize);
        }

    }, [])

    useEffect(() => {
        console.log(selectedSkuSize)
        if (selectedSkuSize) {
            form.setData(data => ({
                ...data,
                quantity: 1,
                skuId: selectedSkuSize.id
            }));

        } else {
            form.setData(data => ({
                ...data,
                quantity: 1,
                skuId: null
            }));
        }

    }, [selectedSkuSize])


    return (

        <>


            {
                product.skus.length > 1 && (

                    <SelectSkuSize skuSizes={product.skus} selectedSkuSize={selectedSkuSize} setSelectedSkuSize={setSelectedSkuSize} />
                )
            }

            < SelectQuantity maxQuantity={product.max_quantity} selectedSkuSize={selectedSkuSize} form={form} />

            <ButtonsProcessing form={form} />


        </ >
    )
}

export default VariantsProduct

