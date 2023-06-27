import CardProduct from '@/Components/Cards/CardProduct'
import Pagination from '@/Components/Pagination'
import Layout from '@/Layouts/Layout'
import { Transition } from '@headlessui/react'
import { Head, router, useForm, usePage } from '@inertiajs/react'
import React from 'react'

import { useState, useEffect, useRef } from 'react'

import Filters from './Filters/Filters'
import CarouselBanner from '@/Components/Carousel/CarouselBanner'
import Breadcrumb from '@/Components/Breadcrumb'
import BreadcrumbFilters from './BreadcrumbFilters'

export default function Search({ page, banner, products, filters, breadcrumb }) {


	const { data: filtersActive, setData: setFiltersActive, get, processing, errors, reset } = useForm(filters)

	//console.log(filtersActive)

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

		// for (const property in filtersActive) {
		// 	let data = filtersActive[property]

		// 	let isEmpty = false
		// 	switch (property) {
		// 		case "departmen":
		// 		default:
		// 			isEmpty = data === ""
		// 			break
		// 	}

		// 	if (!isEmpty) {
		// 		newfiltersNoEmpty[property] = data
		// 	}
		// }
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
			<div className="container py-content">
				<BreadcrumbFilters filtersActive={filtersActive} />
				<div className="flex md:flex-row flex-col-reverse gap-x-14 pt-10">

					<div className="w-full md:w-3/12 ">
						<Filters filtersActive={filtersActive} setFiltersActive={setFiltersActive} />
						<div className="py-6">
							<CarouselBanner images={banner} />
						</div>
					</div>
					<div className="w-full md:w-9/12 ">
						<div className="space-y-4 relative ">
							<div className="flex items-start justify-between">
								<h2 className="font-bold text-2xl ">
									Busqueda
									<label className="text-xs block font-normal whitespace-nowrap w-full mt-1">{products.meta.total} artículos</label>
								</h2>
								<div className="flex flex-col items-end gap-x-2  md:flex-row md:items-center justify-end">

									<select
										onChange={e => setFilter('sortBy', e.target.value)}
										className="py-2 select-form text-sm flex-none" name="sortBy"
										defaultValue={filters.sortBy}>
										<option value="">Ordenar Por:</option>
										<option value="">Mas relevantes</option>
										<option value="price_asc">Menor precio</option>
										<option value="price_desc">Mayor precio</option>
									</select>
								</div>

							</div>
							<div className="relative">
								{products.data.length ? (
									<div className="relative">
										<>
											<div className=''>
												<div className="grid grid-cols-2 gap-2 md:grid-cols-2 lg:grid-cols-3 md:gap-x-2 md:gap-y-6 ">
													{products.data.map((item) => (
														<CardProduct key={item.id} product={item} />
													))}
												</div>
											</div>
											{products.meta.total > products.meta.per_page && (
												<div>
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
