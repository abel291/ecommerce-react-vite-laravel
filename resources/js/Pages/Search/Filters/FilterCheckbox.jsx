const FilterCheckbox = ({ optionsList, changeFilter, filterName }) => {

	const handleChange = (e) => {
		let target = e.target;
		changeFilter(filterName, target.value, target.checked)
	}
	return (
		<>
			<div className="space-y-3 text-sm font-normal">
				{optionsList.map((item, index) => (
					<div key={index} className="flex items-center">
						<input
							id={item.slug}
							checked={item.selected}
							type="checkbox"
							className="rounded mr-3 h-4 w-4 input-checkbox"
							name={filterName}
							value={item.slug}
							onChange={handleChange}
						/>
						<label className=" text-gray-600 " htmlFor={item.slug}>
							{item.name}
							<span className="text-xs text-gray-500 ml-1 font-light">({item.products_count})</span>
						</label>
					</div>
				))}
			</div>
		</>
	)
}

export default FilterCheckbox
