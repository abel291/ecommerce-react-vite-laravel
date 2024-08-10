import CardProduct from '@/Components/Cards/CardProduct'
import Pagination from '@/Components/Pagination'
import Layout from '@/Layouts/Layout'
import { Transition } from '@headlessui/react'
import { Head, router, useForm, usePage } from '@inertiajs/react'
import React from 'react'

import { useState, useEffect, useRef } from 'react'

import Filters from './Filters/Filters'
import CarouselBanner from '@/Components/Carousel/CarouselBanner'
import Breadcrumb from '@/Components/Breadcrumb'
import BreadcrumbFilters from './BreadcrumbFilters'

export default function Search({ page, products, filters, breadcrumb, banner }) {

    const { data, setData, get, processing, errors, reset } = useForm(filters)

    //const getDATA

    const first = useRef(true);

    useEffect(() => {
        if (first.current) {
            first.current = false;

            return;
        }

        get('search', { preserveScroll: true })

    }, [data])


    return (
        <Layout>
            <Head title={page.meta_title}></Head>
            <Breadcrumb data={breadcrumb} />
            <div className="container py-content">
                <div className="flex lg:flex-row flex-col-reverse  ">

                    <div className="w-full lg:w-3/12 xl:w-3/12 2xl:w-2/12 ">
                        <Filters data={data} setData={setData} />
                        <div className="py-6 mt-4">
                            <CarouselBanner images={banner} />
                        </div>
                    </div>
                    <div className="w-full lg:w-9/12 xl:w-9/12 2xl:w-10/12 lg:pl-10  ">
                        <div className="relative ">
                            <div className="flex items-start justify-between">
                                <h2 className="font-bold text-2xl ">
                                    Busqueda
                                    <label className="text-xs block font-normal whitespace-nowrap w-full mt-1">{products.meta.total} artículos</label>
                                </h2>
                                <div className="flex flex-col items-end gap-x-2  md:flex-row md:items-center justify-end">

                                    <select
                                        onChange={e => setData('sortBy', e.target.value)}
                                        className="py-2 select-form text-sm flex-none" name="sortBy"
                                        defaultValue={data.sortBy}>
                                        <option value="">Ordenar Por:</option>
                                        <option value="">Mas relevantes</option>
                                        <option value="price_asc">Menor precio</option>
                                        <option value="price_desc">Mayor precio</option>
                                    </select>
                                </div>

                            </div>
                            <div className="relative mt-12">
                                {products.data.length ? (
                                    <div className="relative">
                                        <>
                                            <div className=''>
                                                <div className="grid grid-cols-2 gap-6 md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 md:gap-x-6 md:gap-y-6 ">
                                                    {products.data.map((item) => (
                                                        <CardProduct key={item.id} product={item} />
                                                    ))}
                                                </div>
                                            </div>
                                            {products.meta.total > products.meta.per_page && (
                                                <div>
                                                    <Pagination paginator={products.meta} />
                                                </div>
                                            )}
                                        </>
                                    </div>
                                ) : (
                                    <div className="text-center mt-10 pt-10 durac">No se encontraron registros</div>
                                )}
                                <Transition
                                    show={processing}
                                    enter="transition-opacity duration-100"
                                    enterFrom="opacity-0"
                                    enterTo="opacity-100"
                                    leave="transition-opacity duration-100"
                                    leaveFrom="opacity-100"
                                    leaveTo="opacity-0"
                                    className="absolute inset-0 backdrop-filter backdrop-blur-md z-10"
                                >

                                </Transition>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </Layout >
    )
}
