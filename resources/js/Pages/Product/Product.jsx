import Layout from '@/Layouts/Layout'
import { Head, Link } from '@inertiajs/react'
import React from 'react'
import ImagesProduct from './ImagesProduct'
import Feacture from './Feacture'
import Description from './Description'
import CarouselProduct from './CarouselProduct'
import Breadcrumb from '@/Components/Breadcrumb'

export default function Product({ product, relatedProducts }) {
	console.log(product)
	let breadcrumb = [
		{
			title: product.department.name,
			path: route("search", { 'department[]': product.department.slug })
		},
		{
			title: product.category.name,
			path: route("search", { 'category[]': product.category.slug })
		},
		{
			title: product.brand.name,
			path: route("search", { 'brands[]': product.brand.slug })
		},
		{
			title: product.name
		}]
	return (
		<Layout>
			<Head title={product.name} />
			<div className="container pt-content">
				<Breadcrumb data={breadcrumb} />

				<div className="flex flex-col-reverse lg:flex-row py-content gap-8">
					<div className=" w-full lg:w-7/12">
						<ImagesProduct product={product} />
					</div>
					<div className="w-full lg:w-5/12 ">
						<Feacture product={product} />
					</div>
				</div>
				<div className="w-full lg:w-8/12">
					<Description product={product} />
				</div>
				<div className="py-content">
					<CarouselProduct products={relatedProducts} />
				</div>
			</div>
		</Layout >
	)
}
