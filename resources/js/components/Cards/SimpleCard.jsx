import React from 'react'

function SimpleCard({ name, img }) {
	return (
		<div className="flex flex-col items-center">
			<div className="w-48 max-w-full h-48 p-4 rounded-lg bg-gray-50 flex items-center justify-center">
				<img src={img} className="max-w-full max-h-full" alt={name} />
			</div>

			<span className="font-semibold mt-4 text-sm md:text-base ">{name}</span>
		</div>
	)
}

export default SimpleCard