
import { Link } from '@inertiajs/react'
import React from 'react'


const ColorVariants = ({ product, variants }) => {
    // console.log(variants)
    return (
        <div>
            <h3 className="text-sm font-medium text-gray-900 mb-4">Variantes</h3>
            <div className='flex gap-4 flex-wrap'>
                {variants.map((variant) => (
                    variant.inStock > 0 ? (
                        <Link
                            preserveScroll
                            key={variant.id}
                            href={route("product", { slug: variant.slug, ref: variant.ref })}
                            className={"rounded-md overflow-hidden  " +
                                (
                                    product.id == variant.id
                                        ? "ring-2 ring-primary-500 "
                                        : 'hover:ring-2 hover:ring-primary-500'
                                )}
                        >
                            <img
                                className={(' w-16  object-cover object-top overflow-hidden')}
                                src={variant.thumb}
                                alt={variant.color.name}
                                title={variant.color.name}
                            />
                        </Link>
                    ) : (
                        <div className='relative'>
                            <img
                                className={(' w-16 rounded-sm object-cover object-top overflow-hidden opacity-60')}
                                src={variant.thumb}
                                alt={variant.color.name}
                                title={variant.color.name}
                            />
                            <span
                                aria-hidden="true"
                                className="pointer-events-none absolute -inset-px rounded-md border-2 border-gray-300"
                            >
                                <svg
                                    stroke="currentColor"
                                    viewBox="0 0 100 100"
                                    preserveAspectRatio="none"
                                    className="absolute inset-0 h-full w-full stroke-2 text-gray-300"
                                >
                                    <line x1={0} x2={100} y1={100} y2={0} vectorEffect="non-scaling-stroke" />
                                </svg>
                            </span>
                        </div>
                    )
                ))}
            </div>
        </div>
    )
}

export default ColorVariants
