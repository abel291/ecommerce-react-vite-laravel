import Breadcrumb from '@/Components/Breadcrumb'
import { usePage } from '@inertiajs/react'
import React, { useEffect, useState } from 'react'

function BreadcrumbFilters({ filtersActive }) {
	const { breadcrumb } = usePage().props
	// const [breadcrumb, setBreadcrumb] = useState([])
	// useEffect(() => {


	// 	let new_breadcrumb = []

	// 	if (filtersActive.q) {
	// 		new_breadcrumb.push({
	// 			title: filtersActive.q,
	// 			path: route('search', { q: filtersActive.q })
	// 		})
	// 	};

	// 	let list_breadcrumb = {
	// 		department: filtersActive.department,
	// 		category: filtersActive.category,
	// 		brands: filtersActive.brands
	// 	};

	// 	Object.entries(list_breadcrumb).forEach(([key, filter]) => {

	// 		if (filter.length) {
	// 			filter.forEach((item) => {
	// 				new_breadcrumb.push({
	// 					title: item.replaceAll('-', ' '),
	// 					path: route('search', { key: item })
	// 				})
	// 			})
	// 		};
	// 	});

	// 	setBreadcrumb(new_breadcrumb)


	// }, [])


	return (
		<div className='w-full'>
			<Breadcrumb data={breadcrumb} />
		</div>
	)
}

export default BreadcrumbFilters