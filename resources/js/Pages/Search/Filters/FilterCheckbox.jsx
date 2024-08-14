const FilterCheckbox = ({
    optionsList,
    optionsChecked,
    changeFilterCheckbox,
    filterName,
}) => {

    const handleChange = (e) => {
        let target = e.target;

        let newOptionsChecked = [...optionsChecked];

        if (target.checked) {
            newOptionsChecked.push(target.value);
        } else {
            newOptionsChecked = newOptionsChecked.filter((item) => {
                return item != target.value;
            });
        }
        changeFilterCheckbox(filterName, newOptionsChecked);
    };

    return (
        <>
            <div className="space-y-3 text-sm font-normal">
                {optionsList.map((item, index) => (
                    <div key={index} className="flex items-center">
                        <input
                            id={item.name}
                            checked={optionsChecked.includes(item.name)}
                            type="checkbox"
                            className="rounded mr-3 h-4 w-4 input-checkbox"
                            name={filterName}
                            value={item.name}
                            onChange={handleChange}
                        />
                        <label className=" text-gray-600 " htmlFor={item.name}>
                            {item.name}
                            <span className="text-xs text-gray-500 ml-1 font-light">
                                ({item.products_count})
                            </span>
                        </label>
                    </div>
                ))}
            </div>
        </>
    );
};

export default FilterCheckbox;
