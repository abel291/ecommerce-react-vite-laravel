const FilterRadio = ({ options, data, setData, filterName }) => {

	const handleChangeFilterRadio = (e) => {
		let target = e.target
		setData(target.name, target.value)
	}

	return (
		<>
			<div className="space-y-3 text-sm font-normal text-gray-700">
				{options.map((item) => (
					<div key={item.slug} className="flex items-center">
						<input
							checked={data.offer === item.slug}
							type="radio"
							className="mr-3 h-4 w-4 input-radio"
							name={filterName}
							value={item.slug}
							onChange={handleChangeFilterRadio}
						/>
						<label htmlFor="text-gray-500"> {item.name}</label>
					</div>
				))}
			</div>
		</>
	)
}

export default FilterRadio
