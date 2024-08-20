import Breadcrumb from "@/Components/Breadcrumb"
import CardProduct from "@/Components/Cards/CardProduct"

import GridProduct from "@/Components/Grids/GridProduct"
import SectionList from "@/Components/Sections/SectionList"
import Layout from "@/Layouts/Layout"
import { Head, Link } from "@inertiajs/react"


import React from 'react'

import Hero from "@/Components/Hero/Hero"

export default function Offers({ page, offerProducts, offerBrands, bannersTop }) {
    return (
        <Layout>
            <Head title={page.meta_title} />
            <Breadcrumb data={[{ title: 'Ofertas', }]} />


            <div className="container">
                <Hero title="Ofertas" entry="¡Encuentra precios increíbles cada día!" />

                <SectionList title={"Top ofertas"}>
                    <div className=" py-2 relative">
                        <GridProduct>
                            {offerProducts.map((item) => (
                                <CardProduct key={item.id} product={item} productNew={true} />
                            ))}
                        </GridProduct>
                        <div className="flex justify-center mt-20">
                            <Link className="btn btn-secondary" href={route('search', { offer: 10 })} > Ver mas productos</Link>
                        </div>
                    </div>
                </SectionList>

                {/* {bannersTop.length > 0 && (
					<div className="py-content">
						<CarouselBanner images={bannersTop} />
					</div>
				)} */}

                {/* <SectionList title={"Top Marcas"}>
					<CarouselSection items={offerBrands} searchType="brands[]" parameters={{ offer: 10 }} />
				</SectionList> */}

            </div>


        </Layout >
    )
}

