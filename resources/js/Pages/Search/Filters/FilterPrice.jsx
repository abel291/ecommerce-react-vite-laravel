import PrimaryButton from "@/Components/PrimaryButton"
import { ChevronDoubleRightIcon, ChevronRightIcon } from "@heroicons/react/24/solid"

import { useRef } from "react"

const FilterPrice = ({ data, setData }) => {
	const priceMinRef = useRef()
	const priceMaxRef = useRef()

	const onChange = (e) => {
		e.preventDefault()
		let target = e.target
		setData(target.name, target.value)
	}

	function debounce(callback, wait) {
		let timerId;
		return (...args) => {
			clearTimeout(timerId);
			timerId = setTimeout(() => {
				callback(...args);
			}, wait);
		};
	}

	const debouncedOnChange = debounce(onChange, 1000);

	return (
		<>

			<form className="space-y-3 text-sm">
				<div className="flex gap-x-2 items-stretch">
					<input
						onChange={debouncedOnChange}
						ref={priceMinRef}
						defaultValue={data.price_min}
						name="price_min"
						type="number"
						min="0"
						className="input-form shadow-none  w-full text-sm"
						placeholder="Minimo"
					/>

					<input
						onChange={debouncedOnChange}
						ref={priceMaxRef}
						defaultValue={data.price_max}
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
