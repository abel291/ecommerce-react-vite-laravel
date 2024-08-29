import Layout from '@/Layouts/Layout'
import { Head, Link } from '@inertiajs/react'
import React from 'react'
import ImagesProduct from './ImagesProduct'
import Feacture from './Feacture'
import Description from './Description'
import CarouselProduct from './CarouselProduct'
import Breadcrumb from '@/Components/Breadcrumb'
import SectionTitle from '@/Components/Sections/SectionTitle'
import TitlePrice from './TitlePrice'

import { formatCurrency } from '@/Helpers/helpers'
import Presentations from './Variants/VariantsProduct'
import VariantsProduct from './Variants/VariantsProduct'

export default function Product({ product, relatedProducts, colors, sizes }) {
    // console.log(product)
    let breadcrumb = [
        {
            title: product.department.name,
            path: route("search", { 'departments[]': product.department.id })
        },
        {
            title: product.category.name,
            path: route("search", { 'categories[]': product.category.id, 'departments[]': product.department.id })
        },

        {
            title: product.name
        }]
    return (
        <Layout>
            <Head title={product.name} />
            <Breadcrumb data={breadcrumb} />
            <div className="container ">
                <div className="flex flex-col-reverse lg:flex-row py-content gap-8">
                    <div className=" w-full lg:w-7/12">
                        <ImagesProduct product={product} />
                    </div>
                    <div className="w-full lg:w-5/12 ">

                        <h2 className="font-bold text-3xl">
                            {product.name}
                        </h2>

                        <span className='text-gray-400 block mt-2 '>REF {product.variant.ref}</span>

                        <div className="mt-6 tracking-tight">
                            {product.offer &&
                                <span className="text-xs text-gray-400 font-medium line-through">
                                    {formatCurrency(product.old_price)}
                                </span>
                            }
                            <div className="flex items-center font-medium">
                                <div className="text-3xl inline-block mr-2 font-semibold">{formatCurrency(product.price)}</div>
                                {product.offer && <div className="inline-block text-green-500  ">{product.offer}%</div>}
                            </div>
                        </div>

                        <p className='mt-4 mb-10 '>{product.entry}</p>

                        <VariantsProduct product={product} />
                    </div>

                </div>
                <div className="w-full lg:w-8/12">
                    <Description product={product} />
                </div>
                <div className="py-content">
                    <SectionTitle title="Productos relacionados" />
                    <div className="mt-5">
                        <CarouselProduct products={relatedProducts} />
                    </div>
                </div>
            </div>
        </Layout>
    )
}
