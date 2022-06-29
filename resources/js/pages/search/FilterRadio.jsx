const FilterRadio = ({ items, filtersActive, setFiltersActive, nameInputs, title }) => {
    
    const handleChangeFilterRadio = (e) => {
        let target = e.target
        setFiltersActive({
            ...filtersActive,
            [target.name]: target.value,
            page: 1,
        })
    }

    return (
        <>
            <div className="font-medium mb-4 ">{title}</div>
            <div className="space-y-3 text-sm font-normal text-gray-700">
                {items.map((item) => (
                    <div key={item.slug} className="flex items-center">
                        <input
                            checked={filtersActive[nameInputs]===item.slug}
                            type="radio"
                            className="mr-3 h-5 w-5 rounded-full"
                            name={nameInputs}
                            value={item.slug}
                            onChange={handleChangeFilterRadio}
                        />
                        <label htmlFor="text-sm"> {item.name}</label>
                    </div>
                ))}
            </div>
        </>
    )
}

export default FilterRadio
