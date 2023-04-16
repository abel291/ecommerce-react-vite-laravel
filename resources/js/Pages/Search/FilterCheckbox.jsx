const FilterCheckbox = ({ options, filter, setFilter, nameFilter, title }) => {

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
			<div className="font-medium mb-4 ">{title}</div>
			<div className="space-y-3 text-sm font-normal text-gray-700">
				{options.map((item, index) => (
					<div key={item.slug} className="flex items-center">
						<input
							checked={filter.includes(item.slug)}
							type="checkbox"
							className="mr-3 h-5 w-5 input-checkbox"
							name={nameFilter}
							value={item.slug}
							onChange={handleChangeFilterCheckbox}
						/>
						<label htmlFor="text-sm"> {item.name}</label>
					</div>
				))}
			</div>
		</>
	)
}

export default FilterCheckbox
