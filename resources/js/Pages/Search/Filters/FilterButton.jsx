const FilterCheckbox = ({ optionsList, setFilter, nameFilter }) => {

	const handleClick = (e, value) => {
		e.preventDefault()
		setFilter(nameFilter, value)
	}
	return (
		<>
			<div className="space-y-3 text-sm font-normal">
				{optionsList.map((item, index) => (
					<div key={index}>
						<button type="button" className="block text-gray-600 " onClick={(e) => handleClick(e, item.slug)}>
							{item.name}
							<span className="text-xs text-gray-500 ml-1 font-light">({item.products_count})</span>
						</button>
					</div>
					// <div key={index} className="flex items-center">
					// 	<input
					// 		id={item.slug}
					// 		checked={filter.includes(item.slug)}
					// 		type="checkbox"
					// 		className="rounded mr-3 h-4 w-4 input-checkbox"
					// 		name={nameFilter}
					// 		value={item.slug}
					// 		onChange={handleChangeFilterCheckbox}
					// 	/>
					// 	<label className=" text-gray-600 " htmlFor={item.slug}>
					// 		
					// 	</label>
					// </div>
				))}
			</div>
		</>
	)
}

export default FilterCheckbox
