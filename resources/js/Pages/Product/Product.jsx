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

export default function Product({ product, relatedProducts, attributesDefault }) {

	let breadcrumb = [
		{
			title: product.department.name,
			path: route("search", { 'departments[]': product.department.slug })
		},
		{
			title: product.category.name,
			path: route("search", { 'categories[]': product.category.slug, 'departments[]': product.department.slug })
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
						<TitlePrice product={product} />
						<Feacture product={product} attributesDefault={attributesDefault} />
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
		</Layout >
	)
}
