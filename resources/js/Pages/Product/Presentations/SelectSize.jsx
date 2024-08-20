import { Radio, RadioGroup } from '@headlessui/react';
import React, { useState } from 'react'
function classNames(...classes) {
    return classes.filter(Boolean).join(' ')
}
const SelectSize = ({ selectedSize, setSelectedSize, sizesColor }) => {

    console.log(selectedSize)

    return (
        <div>
            <h3 className="text-sm font-medium text-gray-900">Talla</h3>
            <fieldset aria-label="Choose a size" className="mt-4">
                <RadioGroup
                    value={selectedSize}
                    onChange={setSelectedSize}
                    className="gap-4 flex items-center flex-wrap"
                >
                    {sizesColor.map((size) => (
                        <Radio
                            key={size.id}
                            value={size}
                            disabled={!size.stock}
                            className={classNames(
                                size.stock
                                    ? 'cursor-pointer bg-white text-gray-900 shadow-sm'
                                    : 'cursor-not-allowed bg-gray-50 text-gray-200',
                                'group relative flex items-center justify-center rounded-md border px-6 py-4 text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none data-[focus]:ring-4 data-[focus]:ring-primary-500 ',
                            )}
                        >
                            <span>{size.name}</span>
                            {size.stock ? (
                                <span
                                    aria-hidden="true"
                                    className="pointer-events-none absolute -inset-px rounded-md border-2 border-transparent group-data-[focus]:border group-data-[checked]:border-primary-500"
                                />
                            ) : (
                                <span
                                    aria-hidden="true"
                                    className="pointer-events-none absolute -inset-px rounded-md border-2 border-gray-200"
                                >
                                    <svg
                                        stroke="currentColor"
                                        viewBox="0 0 100 100"
                                        preserveAspectRatio="none"
                                        className="absolute inset-0 h-full w-full stroke-2 text-gray-200"
                                    >
                                        <line x1={0} x2={100} y1={100} y2={0} vectorEffect="non-scaling-stroke" />
                                    </svg>
                                </span>
                            )}
                        </Radio>
                    ))
                    }
                </RadioGroup>
            </fieldset>
        </div>
    )
}

export default SelectSize
