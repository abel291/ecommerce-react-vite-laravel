import React, { createContext, useEffect, useState } from 'react'
import SelectColor from './SelectColor';
import SelectSize from './SelectSize';
import SelectQuantity from './SelectQuantity';
import { Link, useForm } from '@inertiajs/react';
import ButtonsProcessing from './ButtonsProcessing';

const VariantsProduct = ({ product }) => {


    // const [selectedColor, setSelectedColor] = useState(colors.find((color) => color.default))

    // const [sizesColor, setsizesColor] = useState([])

    const [selectedSize, setSelectedSize] = useState(null)

    const form = useForm({
        quantity: 1,
        variandRef: product.variant.ref,
        variantSizeId: null
    })

    // useEffect(() => {
    //     let sizesColor = sizes.filter(item => item.colorId == selectedColor.id)

    //     setsizesColor(sizesColor);

    //     let newselectedSize = sizesColor.find((size) => {
    //         return (size.default && size.stock > 0) || size.stock > 0
    //     })

    //     if (newselectedSize) {
    //         setSelectedSize(newselectedSize);
    //     } else {
    //         setSelectedSize(null);
    //     }

    // }, [selectedColor])
    useEffect(() => {


        let newselectedSize = product.variant.sizes.find((size) => {
            return size.stock > 0
        })

        if (newselectedSize) {
            setSelectedSize(newselectedSize);
        }

    }, [])

    useEffect(() => {

        if (selectedSize) {
            form.setData(data => ({
                ...data,
                quantity: 1,
                variantSizeId: selectedSize.id
            }));

        } else {
            form.setData(data => ({
                ...data,
                quantity: 1,
                variantSizeId: null
            }));
        }



    }, [selectedSize])


    return (
        <div className='space-y-6'>

            <SelectColor product={product} />

            <SelectSize sizes={product.variant.sizes} selectedSize={selectedSize} setSelectedSize={setSelectedSize} />

            <SelectQuantity maxQuantity={product.max_quantity} selectedSize={selectedSize} form={form} />

            <ButtonsProcessing form={form} />

        </div>
    )
}

export default VariantsProduct

