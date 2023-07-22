import React from 'react'
import FilterCheckbox from './FilterButton'

const FilterAttribute = ({ attribute, attributesSelected, setFilter }) => {

	const handleChange = (e) => {
		let target = e.target
		let newAttributesSelected = attributesSelected;

		if (target.checked) {
			newAttributesSelected.push(target.value)
		} else {
			newAttributesSelected = newAttributesSelected.filter((item) => item !== target.value)
		}

		setFilter('attributes', newAttributesSelected)
	}
	return (
		<>
			<div className="space-y-3 text-sm font-normal">
				{attribute.attribute_values.map((attributeValue, index) => (
					<div key={index} className="flex items-center">
						<input
							id={attribute.slug + ':' + attributeValue.slug}
							checked={attributesSelected.includes(attribute.slug + ':' + attributeValue.slug)}
							type="checkbox"
							className="rounded mr-3 h-4 w-4 input-checkbox"
							name={attribute.slug}
							value={attribute.slug + ':' + attributeValue.slug}
							onChange={handleChange}
						/>
						<label className=" text-gray-600 " htmlFor={attribute.slug + '_' + attributeValue.slug}>
							{attributeValue.name}
							<span className="text-xs text-gray-500 ml-1 font-light">({attributeValue.products_count})</span>
						</label>
					</div>
				))}
			</div>
		</>
	)
}

export default FilterAttribute