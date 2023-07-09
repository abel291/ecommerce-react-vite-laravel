import { RadioGroup } from '@headlessui/react'
import React, { useEffect, useState } from 'react'
function classNames(...classes) {
	return classes.filter(Boolean).join(' ')
}
const AttributeValues = ({ data, setData, attribute }) => {

	// const handlerChange = (e) => {
	// 	let target = e.target
	// 	setData('attributes', { ...data.attributes, [attribute.slug]: target.value })
	// }
	const [selectedAttribute, setSelectedAttribute] = useState(data.attributes[attribute.slug])
	useEffect(() => {
		setData('attributes', { ...data.attributes, [attribute.slug]: selectedAttribute })
	}, [selectedAttribute])

	return (
		// <>
		// 	<select
		// 		onChange={handlerChange}
		// 		className="py-2 select-form text-sm flex-none" name={attribute.slug}
		// 		defaultValue={data.attributes[attribute.slug]}>

		// 		{attribute.attribute_values.map((attributeValue) => (

		// 			<option value={attributeValue.slug} disabled={!attributeValue.in_stock}>{attributeValue.name}</option>
		// 		))}

		// 	</select>


		// </>
		<div>
			{(attribute.attribute_values.length == 1) ? (
				<span className='font-medium'>{attribute.attribute_values[0].name}</span>
			) : (
				<div className='flex flex-wrap gap-x-2'>
					<RadioGroup value={selectedAttribute} onChange={setSelectedAttribute}>
						<RadioGroup.Label className="sr-only">Choose a size</RadioGroup.Label>
						<div className="grid grid-cols-4 gap-3 sm:grid-cols-8 lg:grid-cols-4">
							{attribute.attribute_values.map((attributeValue) => (
								<RadioGroup.Option
									key={attribute.slug + attributeValue.slug}
									value={attributeValue.slug}
									disabled={!attributeValue.in_stock}
									className={({ active }) =>
										classNames(
											attributeValue.in_stock
												? 'cursor-pointer bg-white text-gray-900 shadow-sm'
												: 'cursor-not-allowed bg-gray-50 text-gray-200',
											active ? 'ring-2 ring-primary-500' : '',
											'group relative flex items-center justify-center rounded-md border py-2.5 px-4 text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-2'
										)
									}
								>
									{({ active, checked }) => (
										<>
											<RadioGroup.Label as="span">{attributeValue.name}</RadioGroup.Label>
											{attributeValue.in_stock ? (
												<span
													className={classNames(
														active ? 'border' : 'border-2',
														checked ? 'border-primary-500' : 'border-transparent',
														'pointer-events-none absolute -inset-px rounded-md'
													)}
													aria-hidden="true"
												/>
											) : (
												<span
													aria-hidden="true"
													className="pointer-events-none absolute -inset-px rounded-md border-2 border-gray-200"
												>
													<svg
														className="absolute inset-0 h-full w-full stroke-2 text-gray-200"
														viewBox="0 0 100 100"
														preserveAspectRatio="none"
														stroke="currentColor"
													>
														<line x1={0} y1={100} x2={100} y2={0} vectorEffect="non-scaling-stroke" />
													</svg>
												</span>
											)}
										</>
									)}
								</RadioGroup.Option>
							))}
						</div>
					</RadioGroup>

				</div >
			)}
		</div>
	)
}

export default AttributeValues