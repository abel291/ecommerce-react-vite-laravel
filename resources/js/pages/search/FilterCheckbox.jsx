const FilterCheckbox = ({ items, filtersActive, setFiltersActive, nameInputs, title }) => {
    const handleChangeFilterCheckbox = (e) => {
        let target = e.target
        let newItemsActive = filtersActive[nameInputs]

        if (target.checked) {
            newItemsActive.push(target.value)
        } else {
            newItemsActive = newItemsActive.filter((item) => item !== target.value)
        }

        setFiltersActive({
            ...filtersActive,
            [nameInputs]: newItemsActive,
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
                            checked={filtersActive[nameInputs].includes(item.slug)}
                            type="checkbox"
                            className="mr-3 h-5 w-5 "
                            name={nameInputs}
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
