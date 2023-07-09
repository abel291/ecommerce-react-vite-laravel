import React from 'react'
import FilterCheckbox from './FilterCheckbox'

const FilterAttribute = ({ list_attributes }) => {
	return (
		<>
			{list_attributes.map((item, key) => (
				<FilterContainer key={key} title={item.name}>
					<FilterCheckbox
						optionsList={item.attribute_values}
						filter={filtersActive.brands}
						setFilter={setFiltersActive}
						nameFilter="brands"
					/>
				</FilterContainer>
			))}
		</>
	)
}

export default FilterAttribute