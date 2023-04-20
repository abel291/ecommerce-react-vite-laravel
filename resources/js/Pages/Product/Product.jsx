import Layout from '@/Layouts/Layout'
import { Head, Link } from '@inertiajs/react'
import React from 'react'
import ImagesProduct from './ImagesProduct'
import Feacture from './Feacture'
import Description from './Description'
import CarouselProduct from './CarouselProduct'

export default function Product({ product, relatedProducts }) {
	return (
		<Layout>
			<Head title={product.name} />
			<div className="container py-content">
				<div className="hidden md:block text-sm text-gray-400">
					<span>
						<Link href={route("search", { categories: [product.category.slug] })}>
							{product.category.name}
						</Link>
					</span>
					<span> / </span>
					<span>{product.name}</span>
				</div>
				<div className="flex flex-col-reverse md:flex-row ">
					<div className="py-content w-full md:w-7/12">
						<ImagesProduct product={product} />
					</div>
					<div className="py-content w-full md:w-5/12 md:pl-10 py-content">
						<Feacture product={product} />
					</div>
				</div>
				<div className="w-full md:w-7/12">
					<Description product={product} />
				</div>
				<div className="py-content">
					<CarouselProduct products={relatedProducts} />
				</div>
			</div>w
		</Layout >
	)
}
