
import Banner from '@/Components/Carousel/Banner'
import CardProduct from '@/Components/Cards/Product'
import CarouselBanner from '@/Components/Carousel/CarouselBanner'
import SectionList from '@/Components/Sections/SectionList'

import Layout from '@/Layouts/Layout'
import { Head, usePage } from '@inertiajs/react'
import CarouselHome from './CarouselHome'


export default function Home({ page, carouselTop, bannersTop, featured, bannersMedium, newProducts, bannersBottom }) {
	const { categories, brands } = usePage().props

	console.log(bannersBottom)
	return (
		<>
			<Head title={page.meta_title} />
			<Layout>
				<div className="container">
					<div className="py-content grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-8 ">
						<div className="col-span-1 md:col-span-2 ">
							<CarouselBanner images={carouselTop} />
						</div>

						{bannersTop.map((item) => (
							<div key={item.img}>
								<a href={item.link} target="blank">
									<img
										className="h-full mx-auto object-cover w-full rounded-lg overflow-hidden"
										src={item.img}
										alt={item.alt}
									/>
								</a>
							</div>
						))}
					</div>


					<SectionList title="Destacados">

						<div className="grid grid-cols-1 gap-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 md:gap-6 ">
							{featured.map((product) => (
								<CardProduct key={product.id} product={product} />
							))}
						</div>
					</SectionList>

					{bannersMedium.length > 0 && (
						<div className="py-content">
							<CarouselBanner images={bannersMedium} />
						</div>
					)}

					<SectionList title={"Categorias"}>
						<CarouselHome items={categories} searchType="categories" />
					</SectionList>

					<SectionList title={"Los recién llegados"}>
						<div className=" py-2 relative">
							<div className="grid grid-cols-2 gap-2 md:grid-cols-3 lg:grid-cols-4 md:gap-6 ">
								{newProducts.map((item) => (
									<CardProduct key={item.id} product={item} productNew={true} />
								))}
							</div>
						</div>
					</SectionList>

					{bannersBottom.length > 0 && (
						<div className="py-content">
							<CarouselBanner images={bannersBottom} />
						</div>
					)}

					<SectionList title={"Top Marcas"}>
						<CarouselHome items={brands} searchType="brands" />
					</SectionList>

				</div>


			</Layout>
		</>
	)
}
