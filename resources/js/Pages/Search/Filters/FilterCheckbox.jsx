const FilterCheckbox = ({ optionsList, filter, setFilter, nameFilter }) => {

	const handleChangeFilterCheckbox = (e) => {
		let target = e.target
		let newfilter = filter;

		if (target.checked) {
			newfilter.push(target.value)
		} else {
			newfilter = newfilter.filter((item) => item !== target.value)
		}
		console.log(target.value)
		setFilter(nameFilter, newfilter)
	}
	return (
		<>
			<div className="space-y-3 text-sm font-normal">
				{optionsList.map((item, index) => (
					<div key={index} className="flex items-center">
						<input
							id={item.slug}
							checked={filter.includes(item.slug)}
							type="checkbox"
							className="rounded mr-3 h-4 w-4 input-checkbox"
							name={nameFilter}
							value={item.slug}
							onChange={handleChangeFilterCheckbox}
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
