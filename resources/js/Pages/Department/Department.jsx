import CardProduct from '@/Components/Cards/CardProduct'
import GridProduct from '@/Components/Grids/GridProduct'
import SectionList from '@/Components/Sections/SectionList'
import Layout from '@/Layouts/Layout'
import { Head, Link } from '@inertiajs/react'
import React from 'react'
import CarouselProduct from '../Product/CarouselProduct'
import CarouselSection from '../Home/CarouselSection'
import BannerText from '@/Components/Carousel/BannerText'
import Breadcrumb from '@/Components/Breadcrumb'

function Department({ department, offertProduct, bestSellersProduct, categories }) {

	return (
		<Layout>
			<Head title={department.meta_title} />
			<Breadcrumb data={[
				{
					title: department.name,
				}
			]} />

			<BannerText title={department.name} img={department.img} entry={department.entry} />

			<div className="container">
				<SectionList title="Top Ofertas">
					<CarouselProduct products={offertProduct} />
				</SectionList>

				<SectionList title="Los mas vendidos">
					<CarouselProduct products={bestSellersProduct} />
				</SectionList>

				{categories.map((category) => (
					<SectionList key={category.slug} title={category.name}>
						<CarouselProduct products={category.products} />
					</SectionList>
				))}

				<div className="flex justify-center">
					<Link className="btn btn-secondary" href={route('search', { 'department[]': department.slug })} > Ver mas productos</Link>
				</div>
			</div>
		</Layout >
	)
}

export default Department