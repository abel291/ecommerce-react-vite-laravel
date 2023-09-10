
import Badge from '@/Components/Badge'
import { formatCurrency } from '@/Helpers/helpers'
import { XMarkIcon } from '@heroicons/react/24/solid'
import { router, usePage } from '@inertiajs/react'
import { FilterTitle } from './Filters'

const FiltersList = ({ data, setData, changeFilter, changeAttribute }) => {
	const { listDepartments, listCategories, listAttributes } = usePage().props

	const handleClickRemoveFilter = (filterName, value = null) => {

		let newFilters = data

		if ((typeof newFilters[filterName]) == "object") {
			newFilters[filterName] = newFilters[filterName].filter((item) => item !== value)
		} else {
			newFilters[filterName] = ""
		}

		setData({ ...newFilters })
	}

	const handleClickRemoveAll = () => {
		router.get(route('search'))
	}

	return (
		<>

			<div className="flex items-center justify-between ">
				<FilterTitle>Filtros</FilterTitle>
				<button className="text-xs font-light" onClick={handleClickRemoveAll}>
					Borrar todo
				</button>
			</div>

			<div className="flex flex-wrap text-xs gap-2.5">
				{data.q && (
					<Badge color='gray' >
						<span className="mr-2 ">"{data.q}"</span>
						<button onClick={() => handleClickRemoveFilter("q")}>
							<XMarkIcon className="w-3 h-3" />
						</button>
					</Badge>

				)}
				{listDepartments.map((department, index) => (
					department.selected && (
						<Badge color='gray' key={"department" + index}>
							<span className="mr-2 up">{department.name}</span>
							<button onClick={() => changeFilter("departments", department.slug, false)}>
								<XMarkIcon className="w-3 h-3" />
							</button>
						</Badge>
					)
				))}
				{listCategories.map((category, index) => (
					category.selected && (
						<Badge color='gray' key={"category" + index}>
							<span className="mr-2 up">{category.name}</span>
							<button onClick={() => changeFilter("categories", category.slug, false)}>
								<XMarkIcon className="w-3 h-3" />
							</button>
						</Badge>
					)
				))}
				{listAttributes.map((attribute, index) => (
					attribute.attribute_values.map((attributeValue) => (
						attributeValue.selected && (
							<Badge color='gray' key={"attribute" + index}>
								<span className="mr-2 up">{attributeValue.name}</span>
								<button onClick={() => changeAttribute(attribute.slug, attributeValue.slug, false)}>
									<XMarkIcon className="w-3 h-3" />
								</button>
							</Badge>
						)
					)
					)))
				}


				{/* {data.brands.length > 0 &&
					data.brands.map((item) => (
						<Badge color='gray' key={item}>
							<span className="mr-2 up">{item}</span>
							<button onClick={() => handleClickRemoveFilter("brands", item)}>
								<XMarkIcon className="w-3 h-3" />
							</button>
						</Badge>
					))} */}



				{data.price_min && (
					<Badge color='gray'>
						<span className="mr-2 capitalize">Desde {formatCurrency(data.price_min)}</span>
						<button onClick={() => handleClickRemoveFilter("price_min")}>
							<XMarkIcon className="w-3 h-3" />
						</button>
					</Badge>
				)}
				{data.price_max && (
					<Badge color='gray' >
						<span className="mr-2 capitalize">Hasta {formatCurrency(data.price_max)}</span>
						<button onClick={() => handleClickRemoveFilter("price_max")}>
							<XMarkIcon className="w-3 h-3" />
						</button>
					</Badge>
				)}

				{data.sortBy && (
					<Badge color='gray' >
						<span className="mr-2 capitalize">{data.sortBy}</span>
						<button onClick={() => handleClickRemoveFilter("sortBy")}>
							<XMarkIcon className="w-3 h-3" />
						</button>
					</Badge>
				)}
				{data.offer && (
					<Badge color='gray' >
						<span className="mr-2 ">Descuentos desde {data.offer}%</span>
						<button onClick={() => handleClickRemoveFilter("offer")}>
							<XMarkIcon className="w-3 h-3" />
						</button>
					</Badge>
				)}
			</div>
			{/* <div className="mr-2 mt-2  px-2 py-2 bg-gray-50 border border-gray-200 rounded-md inline-flex items-center">
						<span className="mr-2 ">Descuento {data.offer}%</span>
						<button onClick={() => handleClickRemoveFilter("offer")}>
							<XMarkIcon className="w-3 h-3" />
						</button>
					</div> */}
		</>
	)
}

export default FiltersList
