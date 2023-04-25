import CardProduct from "@/Components/Cards/Product"
import CarouselBanner from "@/Components/Carousel/CarouselBanner"
import SectionList from "@/Components/Sections/SectionList"
import Layout from "@/Layouts/Layout"
import { Head, Link } from "@inertiajs/react"


import React from 'react'

export default function Assemblies({ carousel, page, products }) {
	return (
		<Layout>
			<Head title={page.meta_title} />
			<div className="container">
				<div className="py-content">
					<CarouselBanner images={carousel} />
				</div>
				<SectionList title="Ensambles" entry="¡Encuentra precios increíbles cada día!">

					<div className="grid grid-cols-2 gap-2 md:grid-cols-3 lg:grid-cols-4 md:gap-6 ">
						{products.map((product) => (
							<CardProduct key={product.id} product={product} />
						))}
					</div>

				</SectionList>
				<div className="py-content">
					<div className="flex justify-center">
						<Link className="btn-secondary" href={route('search', { assemblies: 10 })} > Ver mas Ensambles</Link>
					</div>
				</div>
			</div>
		</Layout>
	)
}

