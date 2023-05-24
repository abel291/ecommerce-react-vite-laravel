import PrimaryButton from "@/Components/PrimaryButton"
import { ChevronDoubleRightIcon, ChevronRightIcon } from "@heroicons/react/24/solid"

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
			<form onSubmit={handleClickFilterPrice} className="space-y-3 text-sm">
				<div className="flex gap-x-2 items-stretch">
					<input
						ref={priceMinRef}
						defaultValue={filtersActive.price_min}
						name="price_min"
						type="number"
						min="0"
						className="input-form shadow-none  w-full text-sm"
						placeholder="Minimo"
					/>

					<input
						ref={priceMaxRef}
						defaultValue={filtersActive.price_max}
						name="price_max"
						type="number"
						min="0"
						className="input-form shadow-none  w-full text-sm"
						placeholder="Maximo"
					/>
					<div className="flex justify-end">
						<PrimaryButton>Filtrar</PrimaryButton>
					</div>
				</div>

			</form>
		</>
	)
}

export default FilterPrice
