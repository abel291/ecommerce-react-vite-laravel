import CardProduct from "@/Components/Cards/CardProduct"
import CarouselBanner from "@/Components/Carousel/CarouselBanner"
import GridProduct from "@/Components/Grids/GridProduct"
import SectionList from "@/Components/Sections/SectionList"
import Layout from "@/Layouts/Layout"
import { Head, Link } from "@inertiajs/react"


import React from 'react'

export default function Offers({ bannersTop, page, products }) {
	console.log(bannersTop)
	return (
		<Layout>
			<Head title={page.meta_title} />
			<div className="container">

				{bannersTop.length > 0 && (
					<div className="pt-content">
						<CarouselBanner images={bannersTop} />
					</div>
				)}

				<SectionList title="Ofertas" entry="¡Encuentra precios increíbles cada día!">
					<GridProduct>
						{products.map((product) => (
							<CardProduct key={product.id} product={product} />
						))}
					</GridProduct>
				</SectionList>

				<div className="py-content">
					<div className="flex justify-center">
						<Link className="btn btn-secondary" href={route('search', { offer: 10 })} > Ver mas ofertas</Link>
					</div>
				</div>

			</div>
		</Layout>
	)
}

