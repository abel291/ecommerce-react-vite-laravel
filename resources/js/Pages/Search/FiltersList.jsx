
import { XMarkIcon } from '@heroicons/react/24/solid'
import { router } from '@inertiajs/react'

const FiltersList = ({ filtersActive, setFiltersActive, setFilter }) => {

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
				<h2 className=" font-medium text-xl">Filtros</h2>
				<button className="text-xs font-light" onClick={handleClickRemoveAll}>
					Borrar todo
				</button>
			</div>
			<div className="flex flex-wrap text-xs">
				{filtersActive.q && (
					<div className="mr-2 mt-2  px-2 py-2 bg-gray-50 border border-gray-200 rounded-md inline-flex items-center">
						<span className="mr-2 ">"{filtersActive.q}"</span>
						<button onClick={() => handleClickRemoveFilter("q")}>
							<XMarkIcon className="w-3 h-3" />
						</button>
					</div>
				)}
				{filtersActive.categories &&
					filtersActive.categories.map((item) => (
						<div
							key={item}
							className="mr-2 mt-2  px-2 py-2 bg-gray-50 border border-gray-200 rounded-md inline-flex items-center"
						>
							<span className="mr-2 up">{item}</span>
							<button onClick={() => handleClickRemoveFilter("categories", item)}>
								<XMarkIcon className="w-3 h-3" />
							</button>
						</div>
					))}

				{filtersActive.brands &&
					filtersActive.brands.map((item) => (
						<div
							key={item}
							className="mr-2 mt-2  px-2 py-2 bg-gray-50 border border-gray-200 rounded-md inline-flex items-center"
						>
							<span className="mr-2 ">{item}</span>
							<button onClick={() => handleClickRemoveFilter("brands", item)}>
								<XMarkIcon className="w-3 h-3" />
							</button>
						</div>
					))}

				{filtersActive.price_min && (
					<div className="mr-2 mt-2  px-2 py-2 bg-gray-50 border border-gray-200 rounded-md inline-flex items-center">
						<span className="mr-2 capitalize">Desde ${filtersActive.price_min}</span>
						<button onClick={() => handleClickRemoveFilter("price_min")}>
							<XMarkIcon className="w-3 h-3" />
						</button>
					</div>
				)}
				{filtersActive.price_max && (
					<div className="mr-2 mt-2  px-2 py-2 bg-gray-50 border border-gray-200 rounded-md inline-flex items-center">
						<span className="mr-2 capitalize">Hasta ${filtersActive.price_max}</span>
						<button onClick={() => handleClickRemoveFilter("price_max")}>
							<XMarkIcon className="w-3 h-3" />
						</button>
					</div>
				)}

				{filtersActive.sortBy && (
					<div className="mr-2 mt-2  px-2 py-2 bg-gray-50 border border-gray-200 rounded-md inline-flex items-center">
						<span className="mr-2 capitalize">{filtersActive.sortBy}</span>
						<button onClick={() => handleClickRemoveFilter("sortBy")}>
							<XMarkIcon className="w-3 h-3" />
						</button>
					</div>
				)}
				{filtersActive.offer && (
					<div className="mr-2 mt-2  px-2 py-2 bg-gray-50 border border-gray-200 rounded-md inline-flex items-center">
						<span className="mr-2 ">Descuento {filtersActive.offer}%</span>
						<button onClick={() => handleClickRemoveFilter("offer")}>
							<XMarkIcon className="w-3 h-3" />
						</button>
					</div>
				)}
			</div>
		</>
	)
}

export default FiltersList
