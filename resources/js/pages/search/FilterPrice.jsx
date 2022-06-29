import { ChevronRightIcon } from "@heroicons/react/solid"
import { useRef } from "react"

const FilterPrice = ({ filtersActive, setFiltersActive }) => {
    const priceMinRef = useRef()
    const priceMaxRef = useRef()

    const handleClickFilterPrice = (e) => {
        e.preventDefault()

        let newFiltersActive = filtersActive

        newFiltersActive.price_min = priceMinRef.current.value

        newFiltersActive.price_max = priceMaxRef.current.value

        setFiltersActive({ ...newFiltersActive })
    }

    return (
        <>
            <div className="flex items-center justify-between mb-4">
                <span className="font-medium ">Precio</span>
            </div>
            <form onSubmit={handleClickFilterPrice} className="space-y-3 text-sm font-normal text-gray-700">
                <div className="flex  space-x-2 items-stretch">
                    <input
                        ref={priceMinRef}
                        defaultValue={filtersActive.price_min}
                        name="price_min"
                        type="number"
                        min="0"
                        className="px-2 py-1.5 w-full text-sm rounded"
                        placeholder="Minimo"
                    />

                    <input
                        ref={priceMaxRef}
                        defaultValue={filtersActive.price_max}
                        name="price_max"
                        type="number"
                        min="0"
                        className="px-2 py-1.5 w-full text-sm rounded"
                        placeholder="Maximo"
                    />
                    <button className="px-2 text-white bg-orange-500 rounded-md">
                        <ChevronRightIcon className="h-6 w-6" />
                    </button>
                </div>
            </form>
        </>
    )
}

export default FilterPrice
