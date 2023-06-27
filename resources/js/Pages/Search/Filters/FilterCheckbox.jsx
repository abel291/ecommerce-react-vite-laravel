const FilterCheckbox = ({ optionsList, filter, setFilter, nameFilter }) => {

	const handleChangeFilterCheckbox = (e) => {
		let target = e.target
		let newfilter = filter;

		if (target.checked) {
			newfilter.push(target.value)
		} else {
			newfilter = newfilter.filter((item) => item !== target.value)
		}
		setFilter(nameFilter, newfilter)
	}



	return (
		<>
			<div className="space-y-3 text-sm font-normal">
				{optionsList.map((item, index) => (
					<div key={item.value} className="flex items-center">
						<input
							id={item.value}
							checked={filter.includes(item.value)}
							type="checkbox"
							className="rounded mr-3 h-4 w-4 input-checkbox"
							name={nameFilter}
							value={item.value}
							onChange={handleChangeFilterCheckbox}
						/>
						<label className=" text-gray-600" htmlFor={item.value}> {item.name}({item.products_count})</label>
					</div>
				))}
			</div>
		</>
	)
}

export default FilterCheckbox
