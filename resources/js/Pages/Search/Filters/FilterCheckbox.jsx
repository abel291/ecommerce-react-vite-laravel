const FilterCheckbox = ({
    optionsList,
    optionsChecked,
    changeFilterCheckbox,
    filterName,
    type = 'default'
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
                            id={filterName + item.id}
                            checked={optionsChecked.includes(item.id.toString())}
                            type="checkbox"
                            className="rounded mr-3 h-4 w-4 input-checkbox"
                            name={filterName}
                            value={item.id}
                            onChange={handleChange}
                        />
                        <label className=" text-gray-600  flex items-center gap-x-2 cursor-pointer" htmlFor={filterName + item.id}>
                            {type == 'color' && (
                                <span style={{ backgroundImage: "url(" + item.img + ")" }} aria-hidden="true" className="size-4 rounded-full  inline-block  border-gray-200"></span>
                            )}

                            <span>{item.name}</span>
                            {/* <span className="text-xs text-gray-500 ml-1 font-light">
                                ({item.products_count})
                            </span> */}
                        </label>
                    </div>
                ))}
            </div>
        </>
    );
};

export default FilterCheckbox;
