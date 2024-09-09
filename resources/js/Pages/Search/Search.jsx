import CardProduct from "@/Components/Cards/CardProduct";
import Pagination from "@/Components/Pagination";
import Layout from "@/Layouts/Layout";
import { Transition } from "@headlessui/react";
import { Head, router, useForm, usePage } from "@inertiajs/react";
import React, { createContext } from "react";

import { useState, useEffect, useRef } from "react";

import Filters from "./Filters/Filters";
import CarouselBanner from "@/Components/Carousel/CarouselBanner";
import Breadcrumb from "@/Components/Breadcrumb";
import BreadcrumbFilters from "./BreadcrumbFilters";
import MetaTag from "@/Components/MetaTag";

export const SearchContext = createContext();

export default function Search({ page, products, filters, breadcrumb, banner, }) {

    const form = useForm(filters || []);

    const first = useRef(true);

    useEffect(() => {
        if (first.current) {
            first.current = false;
            return;
        }

        form.get("search", { preserveScroll: true });
    }, [form.data]);

    return (
        <Layout>
            <MetaTag metaTag={page.metaTag} />
            <Breadcrumb data={breadcrumb} />

            <div className="container py-content">
                <div className="flex lg:flex-row flex-col-reverse lg:gap-x-10 ">
                    <div className="w-full lg:w-3/12 xl:w-2/12 2xl:w-2/12 ">
                        <SearchContext.Provider value={form}>
                            <Filters />
                        </SearchContext.Provider>
                        <div className="py-6 mt-4">
                            <CarouselBanner images={banner} />
                        </div>

                    </div>
                    <div className="w-full lg:w-9/12 xl:w-10/12 2xl:w-10/12  ">
                        <div className="relative ">
                            <div className="flex items-start justify-between">
                                <h2 className="font-bold text-2xl ">
                                    Busqueda
                                    <label className="text-xs block font-normal whitespace-nowrap w-full mt-1">
                                        {products.meta.total} artículos
                                    </label>
                                </h2>
                                <div className="flex flex-col items-end gap-x-2  md:flex-row md:items-center justify-end">
                                    <span className="whitespace-nowrap block text-sm">Ordenar Por:</span>
                                    <select
                                        onChange={(e) =>
                                            form.setData("sortBy", e.target.value)
                                        }
                                        className="py-2 select-form text-sm flex-none"
                                        name="sortBy"
                                        defaultValue={form.data.sortBy}
                                    >

                                        <option value="">Mas relevantes</option>
                                        <option value="price_asc">
                                            Precio menor
                                        </option>
                                        <option value="price_desc">
                                            Precio mayor
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div className="relative mt-9">
                                {products.data.length ? (
                                    <div className="relative">
                                        <>
                                            <div className="grid grid-cols-2 gap-6 md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-4 2xl:grid-cols-4 md:gap-x-6 md:gap-y-6 ">
                                                {products.data.map(
                                                    (item) => (
                                                        <CardProduct
                                                            key={item.id}
                                                            product={item}
                                                        />
                                                    )
                                                )}
                                            </div>

                                            {products.meta.total >
                                                products.meta.per_page && (
                                                    <div className="mt-10">
                                                        <Pagination
                                                            paginator={
                                                                products.meta
                                                            }
                                                        />
                                                    </div>
                                                )}
                                        </>
                                    </div>
                                ) : (
                                    <div className="text-center mt-10 pt-10 durac">
                                        No se encontraron registros
                                    </div>
                                )}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Layout>
    );
}
