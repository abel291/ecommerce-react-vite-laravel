import { RadioGroup } from '@headlessui/react'
import { usePage } from '@inertiajs/react'
import React, { useEffect } from 'react'
import AtributeValues from './AttributeValues'
import AttributeValues from './AttributeValues'

const Attributes = ({ product, data, setData }) => {

	return (
		<div className='space-y-4'>
			{product.attributes.map((attribute, key) => (
				<div className='mt-8' key={key}>
					{(attribute.attribute_values.length == 1) ? (
						<div className='grid grid-cols-1 md:grid-cols-3 items-center'>
							<div>
								<h3 className='text-sm font-medium'>{attribute.name}:</h3>
							</div>
							<div className='md:col-span-2'>
								<span className='font-medium'>{attribute.attribute_values[0].name}</span>
							</div>
						</div>
					) : (
						<div className='grid grid-cols-1 md:grid-cols-3 items-center'>
							<div>
								<h3 className='text-sm font-medium'>{attribute.name}:</h3>
							</div>
							<div className='md:col-span-2'>
								<AttributeValues data={data} setData={setData} attribute={attribute} />
							</div>
						</div>
					)}
				</div>
			))}
		</div >
	)
}



export default Attributes