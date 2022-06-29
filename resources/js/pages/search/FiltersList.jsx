import { XIcon } from "@heroicons/react/solid"


const FiltersList = ({ filtersActive, setFiltersActive ,filtersInitialise}) => {
    const handleClickRemoveFilter = (filterName, filtersValue) => {
        
        let newFiltersActive = filtersActive
        if (filterName === "categories" || filterName === "brands") {
            newFiltersActive[filterName] = newFiltersActive[filterName].filter((item) => item !== filtersValue)
        } else {
            newFiltersActive[filterName] = ""
        }

        setFiltersActive({ ...newFiltersActive })
    }
    const handleClickRemoveAll = () => {
        if (JSON.stringify(filtersActive) !== JSON.stringify(filtersInitialise)) {
            setFiltersActive({ ...filtersInitialise })
        }
    }

    return (
        <>
            <div className="flex items-center justify-between pb-4">
                <h2 className=" font-medium text-xl">Filtros</h2>
                <button className="text-xs font-light" onClick={handleClickRemoveAll}>
                    Borrar todo
                </button>
            </div>
            <div className="flex flex-wrap text-xs">
                {filtersActive.q && (
                    <div className="mr-2 mt-2  px-2 py-2 bg-gray-50 border border-gray-200 rounded-md inline-flex items-center">
                        <span className="mr-2 capitalize">"{filtersActive.q}"</span>
                        <button onClick={() => handleClickRemoveFilter("q")}>
                            <XIcon className="w-3 h-3" />
                        </button>
                    </div>
                )}
                {filtersActive.categories &&
                    filtersActive.categories.map((item) => (
                        <div
                            key={item}
                            className="mr-2 mt-2  px-2 py-2 bg-gray-50 border border-gray-200 rounded-md inline-flex items-center"
                        >
                            <span className="mr-2 capitalize">{item}</span>
                            <button onClick={() => handleClickRemoveFilter("categories", item)}>
                                <XIcon className="w-3 h-3" />
                            </button>
                        </div>
                    ))}

                {filtersActive.brands &&
                    filtersActive.brands.map((item) => (
                        <div
                            key={item}
                            className="mr-2 mt-2  px-2 py-2 bg-gray-50 border border-gray-200 rounded-md inline-flex items-center"
                        >
                            <span className="mr-2 capitalize">{item}</span>
                            <button onClick={() => handleClickRemoveFilter("brands", item)}>
                                <XIcon className="w-3 h-3" />
                            </button>
                        </div>
                    ))}

                {filtersActive.price_min && (
                    <div className="mr-2 mt-2  px-2 py-2 bg-gray-50 border border-gray-200 rounded-md inline-flex items-center">
                        <span className="mr-2 capitalize">Desde ${filtersActive.price_min}</span>
                        <button onClick={() => handleClickRemoveFilter("price_min")}>
                            <XIcon className="w-3 h-3" />
                        </button>
                    </div>
                )}
                {filtersActive.price_max && (
                    <div className="mr-2 mt-2  px-2 py-2 bg-gray-50 border border-gray-200 rounded-md inline-flex items-center">
                        <span className="mr-2 capitalize">Hasta ${filtersActive.price_max}</span>
                        <button onClick={() => handleClickRemoveFilter("price_max")}>
                            <XIcon className="w-3 h-3" />
                        </button>
                    </div>
                )}

                {filtersActive.sortBy && (
                    <div className="mr-2 mt-2  px-2 py-2 bg-gray-50 border border-gray-200 rounded-md inline-flex items-center">
                        <span className="mr-2 capitalize">{filtersActive.sortBy}</span>
                        <button onClick={() => handleClickRemoveFilter("sortBy")}>
                            <XIcon className="w-3 h-3" />
                        </button>
                    </div>
                )}
                {filtersActive.offers && (
                    <div className="mr-2 mt-2  px-2 py-2 bg-gray-50 border border-gray-200 rounded-md inline-flex items-center">
                        <span className="mr-2 capitalize">Descuento {filtersActive.offers}%</span>
                        <button onClick={() => handleClickRemoveFilter("offer")}>
                            <XIcon className="w-3 h-3" />
                        </button>
                    </div>
                )}
            </div>
        </>
    )
}

export default FiltersList
