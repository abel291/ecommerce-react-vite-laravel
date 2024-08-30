import React, { createContext, useEffect, useState } from 'react'
import SelectColor from './SelectColor';
import SelectSkuSize from './SelectSkuSize';
import SelectQuantity from './SelectQuantity';
import { Link, useForm } from '@inertiajs/react';
import ButtonsProcessing from './ButtonsProcessing';

const VariantsProduct = ({ product }) => {

    const [selectedSkuSize, setSelectedSkuSize] = useState(null)

    const form = useForm({
        quantity: 1,
        skuId: null
    })



    useEffect(() => {
        console.log(product.variants[0])

        let newSelectedSkuSize = product.variant.skus.find((sku) => {
            return sku.stock > 0
        })

        if (newSelectedSkuSize) {
            setSelectedSkuSize(newSelectedSkuSize);
        }

    }, [])

    useEffect(() => {

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
        <div className='space-y-6'>

            {product.variants.length > 1 && (
                <SelectColor product={product} />
            )}
            {product.variant.skus.length > 1 && (

                <SelectSkuSize skuSizes={product.variant.skus} selectedSkuSize={selectedSkuSize} setSelectedSkuSize={setSelectedSkuSize} />
            )}
            <SelectQuantity maxQuantity={product.max_quantity} selectedSkuSize={selectedSkuSize} form={form} />

            <ButtonsProcessing form={form} />

        </div>
    )
}

export default VariantsProduct

