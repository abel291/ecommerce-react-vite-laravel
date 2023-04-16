import CardProduct from '@/Components/Cards/Product'
import Pagination from '@/Components/Pagination'
import Layout from '@/Layouts/Layout'
import { Transition } from '@headlessui/react'
import { Head, router, useForm, usePage } from '@inertiajs/react'
import React from 'react'
import FiltersList from './FiltersList'
import FilterCheckbox from './FilterCheckbox'
import { useState, useEffect, useRef } from 'react'
import FilterPrice from './FilterPrice'
import FilterRadio from './FilterRadio'
import CarouselBanner from '@/Components/Carousel/CarouselBanner'

export default function Search({ page, banner, products, filters }) {
	const offers = [
		{
			name: "Desde 10%",
			slug: "10",
		},
		{
			name: "Desde 20%",
			slug: "20",
		},
		{
			name: "Desde 30%",
			slug: "30",
		},
		{
			name: "Desde 40%",
			slug: "40",
		},
	]
	const { categories, brands } = usePage().props

	const handlerChangePagination = (page) => {
		setFilter('page', page);
	}
	const { data: filtersActive, setData: setFiltersActive, get, processing, errors, reset } = useForm({
		categories: filters.categories || [],
		brands: filters.brands || [],
		offer: filters.offer || "",
		price_min: filters.price_min || "",
		price_max: filters.price_max || "",
		q: filters.q || "",
		sortBy: filters.sortBy || "",
		page: 1,
	})
	// const [filtersActive, setFiltersActive] = useState({
	// 	categories: filters.categories || [],
	// 	brands: filters.brands || [],
	// 	offers: filters.offers || "",
	// 	price_min: filters.price_min || "",
	// 	price_max: filters.price_max || "",
	// 	q: filters.q || "",
	// 	sortBy: filters.sortBy || "",
	// 	//page: filters.page || 1,
	// })


	const setFilter = (name, value) => {
		setFiltersActive({
			...filtersActive,
			[name]: value,
		})
	}
	const first = useRef(true);
	useEffect(() => {

		if (first.current) {
			first.current = false;
			return;
		}
		let newfiltersNoEmpty = {}
		for (const property in filtersActive) {
			let data = filtersActive[property]

			let isEmpty = false
			switch (property) {
				case "categories":
				case "brands":
					isEmpty = data.length === 0
					break
				default:
					isEmpty = data === ""
					break
			}

			if (!isEmpty) {
				newfiltersNoEmpty[property] = data
			}
		}
		get('search', { preserveScroll: true })

	}, [filtersActive])

	// function handleSubmit(e) {
	// 	e.preventDefault()
	// 	post('/subscribe', {
	// 		preserveScroll: true,
	// 		onSuccess: () => reset('email'),
	// 	})
	// }

	return (
		<Layout>
			<Head title={page.meta_title}></Head>
			<div className="container ">
				<div className="flex md:flex-row flex-col-reverse ">
					<div className="w-full md:w-3/12 py-content">
						<div className="pt-5 pr-12 divide-y divide-gray-200">
							{filtersActive && (
								<>
									<div className="py-5">
										<FiltersList
											filtersActive={filtersActive}
											setFiltersActive={setFiltersActive}
										/>
									</div>
									<div className="py-5">
										<FilterCheckbox
											options={categories}
											filter={filtersActive.categories}
											setFilter={setFilter}
											nameFilter="categories"
											title="Categorias"
										/>
									</div>

									<div className="py-5">
										<FilterPrice filtersActive={filtersActive} setFiltersActive={setFiltersActive} />
									</div>

									<div className="py-5">
										<FilterRadio
											options={offers}
											filter={filtersActive.offer}
											setFilter={setFilter}
											nameInputs="offer"
											title="Ofertas"
										/>
									</div>

									<div className="py-5">
										<FilterCheckbox
											options={brands}
											filter={filtersActive.brands}
											setFilter={setFilter}
											nameInputs="brands"
											title="Marcas"
										/>
									</div>
								</>
							)}
							<div className="py-6">
								<CarouselBanner images={banner} />
								{/* <a target="_black" href="https://www.logitechstore.com.ar/Gaming/Volantes">
									<img className="rounded-lg" src="/img/banner-sidebar-search.jpg" alt="" />
								</a> */}
							</div>
						</div>
					</div>
					<div className="w-full md:w-9/12 py-content">
						<div className="space-y-4 relative md:p-4">
							<div className="flex items-center justify-between">
								<h2 className="font-bold text-2xl">
									Busqueda
								</h2>
								<div className="flex flex-col items-end gap-x-4  md:flex-row md:items-center">
									<span className="text-sm w-full">{products.meta.total} artículos</span>
									<select
										onChange={e => setFilter('sortBy', e.target.value)}
										className="py-2 select-form text-sm" name="sortBy">
										<option disabled>Ordenar Por:</option>
										<option value="">Mas relevantes</option>
										<option value="price_asc">Menor precio</option>
										<option value="price_desc">Mayor precio</option>
									</select>
								</div>
							</div>
							<div className="relative">
								{products.data.length ? (
									<div className="py-content relative">
										<>
											<div className="grid grid-cols-2 gap-2 md:grid-cols-3 md:gap-4 ">
												{products.data.map((item) => (
													<CardProduct key={item.id} product={item} />
												))}
											</div>
											{products.meta.total > products.meta.per_page && (
												<div className="mt-8">
													<Pagination paginator={products.meta} />
												</div>
											)}
										</>
									</div>
								) : (
									<div className="text-center mt-10 pt-10 durac">No se encontraron registros</div>
								)}
								<Transition
									show={processing}
									enter="transition-opacity duration-100"
									enterFrom="opacity-0"
									enterTo="opacity-100"
									leave="transition-opacity duration-100"
									leaveFrom="opacity-100"
									leaveTo="opacity-0"
									className="absolute inset-0 backdrop-filter backdrop-blur-md z-10"
								>

								</Transition>
							</div>


						</div>
					</div>
				</div>
			</div>
		</Layout >
	)
}
