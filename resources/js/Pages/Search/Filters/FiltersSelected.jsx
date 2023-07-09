
import Badge from '@/Components/Badge'
import { formatCurrency } from '@/Helpers/helpers'
import { XMarkIcon } from '@heroicons/react/24/solid'
import { router } from '@inertiajs/react'
import { FilterTitle } from './Filters'

const FiltersList = ({ filtersActive, setFiltersActive, setFilter }) => {
	console.log(filtersActive)
	const handleClickRemoveFilter = (filterName, filtersValue) => {

		let newFiltersActive = filtersActive
		if ((typeof newFiltersActive[filterName]) == "object") {
			newFiltersActive[filterName] = newFiltersActive[filterName].filter((item) => item !== filtersValue)
		} else {
			newFiltersActive[filterName] = ""
		}

		setFiltersActive({ ...newFiltersActive })
	}

	const handleClickRemoveAll = () => {
		router.get(route('search'))
	}

	return (
		<>

			<div className="flex items-center justify-between pb-4">
				<FilterTitle>Filtros</FilterTitle>
				<button className="text-xs font-light" onClick={handleClickRemoveAll}>
					Borrar todo
				</button>
			</div>

			<div className="flex flex-wrap text-xs gap-2.5">
				{filtersActive.q && (
					<Badge color='gray' >
						<span className="mr-2 ">"{filtersActive.q}"</span>
						<button onClick={() => handleClickRemoveFilter("q")}>
							<XMarkIcon className="w-3 h-3" />
						</button>
					</Badge>

				)}
				{filtersActive.department.length > 0 &&
					filtersActive.department.map((item) => (
						<Badge color='gray' key={item}>
							<span className="mr-2 up">{item}</span>
							<button onClick={() => handleClickRemoveFilter("department", item)}>
								<XMarkIcon className="w-3 h-3" />
							</button>
						</Badge>

					))}
				{filtersActive.category.length > 0 &&
					filtersActive.category.map((item) => (
						<Badge color='gray' key={item}>
							<span className="mr-2 up">{item}</span>
							<button onClick={() => handleClickRemoveFilter("category", item)}>
								<XMarkIcon className="w-3 h-3" />
							</button>
						</Badge>

					))}
				{filtersActive.attribute_values.length > 0 &&
					filtersActive.attribute_values.map((item) => (
						<Badge color='gray' key={item}>
							<span className="mr-2 up">{item}</span>
							<button onClick={() => handleClickRemoveFilter("attribute_values", item)}>
								<XMarkIcon className="w-3 h-3" />
							</button>
						</Badge>
					))}

				{filtersActive.brands.length > 0 &&
					filtersActive.brands.map((item) => (
						<Badge color='gray' key={item}>
							<span className="mr-2 up">{item}</span>
							<button onClick={() => handleClickRemoveFilter("brands", item)}>
								<XMarkIcon className="w-3 h-3" />
							</button>
						</Badge>
					))}



				{filtersActive.price_min && (
					<Badge color='gray'>
						<span className="mr-2 capitalize">Desde {formatCurrency(filtersActive.price_min)}</span>
						<button onClick={() => handleClickRemoveFilter("price_min")}>
							<XMarkIcon className="w-3 h-3" />
						</button>
					</Badge>
				)}
				{filtersActive.price_max && (
					<Badge color='gray' >
						<span className="mr-2 capitalize">Hasta {formatCurrency(filtersActive.price_max)}</span>
						<button onClick={() => handleClickRemoveFilter("price_max")}>
							<XMarkIcon className="w-3 h-3" />
						</button>
					</Badge>
				)}

				{filtersActive.sortBy && (
					<Badge color='gray' >
						<span className="mr-2 capitalize">{filtersActive.sortBy}</span>
						<button onClick={() => handleClickRemoveFilter("sortBy")}>
							<XMarkIcon className="w-3 h-3" />
						</button>
					</Badge>
				)}
				{filtersActive.offer && (
					<Badge color='gray' >
						<span className="mr-2 ">Descuento {filtersActive.offer}%</span>
						<button onClick={() => handleClickRemoveFilter("offer")}>
							<XMarkIcon className="w-3 h-3" />
						</button>
					</Badge>
				)}
			</div>
			{/* <div className="mr-2 mt-2  px-2 py-2 bg-gray-50 border border-gray-200 rounded-md inline-flex items-center">
						<span className="mr-2 ">Descuento {filtersActive.offer}%</span>
						<button onClick={() => handleClickRemoveFilter("offer")}>
							<XMarkIcon className="w-3 h-3" />
						</button>
					</div> */}
		</>
	)
}

export default FiltersList
