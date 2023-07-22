
import Banner from '@/Components/Carousel/Banner'
import CardProduct from '@/Components/Cards/CardProduct'
import CarouselBanner from '@/Components/Carousel/CarouselBanner'
import SectionList from '@/Components/Sections/SectionList'

import Layout from '@/Layouts/Layout'
import { Head, usePage } from '@inertiajs/react'
import CarouselTop from './CarouselTop'
import GridProduct from '@/Components/Grids/GridProduct'
import CarouselSection from './CarouselSection'


export default function Home({ page, carouselTop, bannersTop, bestSeller, bannersMedium, newProducts, bannersBottom, categoriesProductCount }) {

	return (
		<>
			<Head title={page.meta_title} />
			<Layout>
				<div className="container">
					<div className="py-content grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-8 ">
						<div className="col-span-1 md:col-span-2 ">
							<CarouselTop images={carouselTop} />
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
					{(bestSeller.length > 0) && (
						<SectionList title="Los mas vendidos">

							<GridProduct>
								{bestSeller.map((product) => (
									<CardProduct key={product.id} product={product} />
								))}
							</GridProduct>
						</SectionList>
					)}

					{bannersMedium.length > 0 && (
						<div className="py-content ">
							<Banner image={bannersMedium[0]} />
						</div>
					)}

					<SectionList title={"Categorias"}>
						<CarouselSection items={categoriesProductCount} searchType="categories[]" />
					</SectionList>

					<SectionList title={"Los recién llegados"}>
						<div className=" py-2 relative">
							<GridProduct>
								{newProducts.map((item) => (
									<CardProduct key={item.id} product={item} productNew={true} />
								))}
							</GridProduct>
						</div>
					</SectionList>

					{bannersBottom.length > 0 && (
						<div className="py-content">
							<CarouselBanner images={bannersBottom} />
						</div>
					)}

					{/* <SectionList title={"Top Marcas"}>
						<CarouselSection items={brands} searchType="brands" />
					</SectionList> */}

				</div>


			</Layout>
		</>
	)
}
