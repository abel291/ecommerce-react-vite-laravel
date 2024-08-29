import Badge from '@/Components/Badge'
import { Radio, RadioGroup } from '@headlessui/react'
import { Link } from '@inertiajs/react'
import React from 'react'

const SelectColor = ({ product }) => {
    return (
        <div>
            {/* <h3 className="text-sm font-medium text-gray-900 mb-2">Variantes:</h3> */}
            <div className='flex gap-4 flex-wrap'>
                {product.variants.map((variant) => (
                    <Link
                        preserveScroll
                        key={variant.id}
                        href={route("product", { slug: product.slug, color: variant.color.slug })}
                        className={"rounded-sm overflow-hidden " + (product.variant.id == variant.id && "ring-2 ring-primary-500 ")}
                    >
                        <img
                            className={(' w-24 rounded-sm object-cover object-top overflow-hidden')}
                            src={variant.thumb}
                            alt={variant.color.name}
                            title={variant.color.name}
                        />
                    </Link>
                ))}
            </div>
        </div>
    )
}

export default SelectColor
