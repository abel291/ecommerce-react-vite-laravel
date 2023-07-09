import React from 'react'
import FiltersSelected from './FiltersSelected'
import { usePage } from '@inertiajs/react'
import FilterCheckbox from './FilterCheckbox'
import FilterPrice from './FilterPrice'
import FilterRadio from './FilterRadio'
import FilterContainer from './FilterContainer'
import FilterAttribute from './FilterAttribute'

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
const Filters = ({ filtersActive, setFiltersActive }) => {
	const { list_departments, list_categories, list_attributes, brands } = usePage().props
	return (
		<div className="divide-y divide-gray-200 space-y-5">

			<div >
				<FiltersSelected
					filtersActive={filtersActive}
					setFiltersActive={setFiltersActive}
				/>
			</div>


			{list_departments.length > 0 && (
				<FilterContainer title="Departamentos" >

					<FilterCheckbox
						optionsList={list_departments}
						filter={filtersActive.department}
						setFilter={setFiltersActive}
						nameFilter="department"

					/>
				</FilterContainer>
			)}

			{list_categories.length > 0 && (
				<FilterContainer title="Categorias">
					<FilterCheckbox
						optionsList={list_categories}
						filter={filtersActive.category}
						setFilter={setFiltersActive}
						nameFilter="category"

					/>
				</FilterContainer>
			)}

			{/* {brands.length > 0 && (
				<FilterContainer title="Marcas">

					<FilterCheckbox
						optionsList={brands}
						filter={filtersActive.brands}
						setFilter={setFiltersActive}
						nameFilter="brands"

					/>
				</FilterContainer>
			)} */}

			<>
				{list_attributes.map((item, index) => (
					<FilterContainer key={index} title={item.name}>
						<FilterCheckbox
							optionsList={item.attribute_values}
							filter={filtersActive.attribute_values}
							setFilter={setFiltersActive}
							nameFilter="attribute_values"
						/>
					</FilterContainer>
				))}
			</>



			<FilterContainer title="Precio">
				<FilterPrice filtersActive={filtersActive} setFiltersActive={setFiltersActive} />
			</FilterContainer>

			<FilterContainer title="Ofertas">
				<FilterRadio
					options={offers}
					filter={filtersActive.offer}
					setFilter={setFiltersActive}
					nameInputs="offer"

				/>
			</FilterContainer>




		</div >
	)
}

export default Filters

export const FilterTitle = ({ children }) => {
	return (<h3 className="font-medium mb-4 ">{children}</h3>);
}
// export const FilterContainer = ({ title = "", children }) => {
// 	return (
// 		<div className="py-5 max-h-96 mr-5">
// 			<FilterTitle>{title}</FilterTitle>
// 			<div>
// 				{children}
// 			</div>
// 		</div>
// 	)
// }
