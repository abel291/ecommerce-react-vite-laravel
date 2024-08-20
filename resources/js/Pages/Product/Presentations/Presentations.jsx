import React, { createContext, useEffect, useState } from 'react'
import SelectColor from './SelectColor';
import SelectSize from './SelectSize';
import SelectQuantity from './SelectQuantity';
import { useForm } from '@inertiajs/react';
import ButtonsProcessing from './ButtonsProcessing';

const Presentations = ({ product, colors, sizes }) => {

    const [selectedColor, setSelectedColor] = useState(colors.find((color) => color.default))

    const [sizesColor, setsizesColor] = useState([])

    const [selectedSize, setSelectedSize] = useState(null)

    const form = useForm({
        quantity: 1,
        product_id: product.id,
        codePresentation: null
    })

    useEffect(() => {
        let sizesColor = sizes.filter(item => item.colorId == selectedColor.id)

        setsizesColor(sizesColor);

        let newselectedSize = sizesColor.find((size) => {
            return (size.default && size.stock > 0) || size.stock > 0
        })

        if (newselectedSize) {
            setSelectedSize(newselectedSize);
        } else {
            setSelectedSize(null);
        }

    }, [selectedColor])

    useEffect(() => {

        if (selectedSize) {

            form.setData(data => ({
                ...data,
                quantity: 1,
                codePresentation: selectedSize.code
            }));

        } else {
            form.setData(data => ({
                ...data,
                quantity: 1,
                codePresentation: null
            }));
        }



    }, [selectedSize])


    return (
        <div className='mt-10 space-y-6'>

            <SelectColor colors={colors} selectedColor={selectedColor} setSelectedColor={setSelectedColor} />

            <SelectSize selectedSize={selectedSize} setSelectedSize={setSelectedSize} sizesColor={sizesColor} />

            <SelectQuantity maxQuantity={product.max_quantity} selectedSize={selectedSize} form={form} />

            <ButtonsProcessing form={form} />

        </div>
    )
}

export default Presentations

