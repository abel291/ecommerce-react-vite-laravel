import CardProduct from "@/Components/Cards/Product"
import CarouselBanner from "@/Components/Carousel/CarouselBanner"
import SectionList from "@/Components/Sections/SectionList"
import Layout from "@/Layouts/Layout"
import { Head, Link } from "@inertiajs/react"


import React from 'react'

export default function Combos({ bannersTop, page, products }) {
	return (
		<Layout>
			<Head title={page.meta_title} />
			<div className="container">
				<div className="py-content">
					<CarouselBanner images={bannersTop} />
				</div>
				<SectionList title="Combos" entry="¡Todos nuestros ensambles disponibles, personalizados con marcas reconocidas y fiables del mercado gamer.!">

					<div className="grid grid-cols-2 gap-2 md:grid-cols-3 lg:grid-cols-4 md:gap-6 ">
						{products.map((product) => (
							<CardProduct key={product.id} product={product} />
						))}
					</div>

				</SectionList>
				<div className="py-content">
					<div className="flex justify-center">
						<Link className="btn-secondary " href={route('search', { 'categories[]': 'combos' })} > Ver mas combos</Link>
					</div>
				</div>
			</div>
		</Layout>
	)
}

