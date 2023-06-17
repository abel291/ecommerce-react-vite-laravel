import React from 'react'

const GridProduct = ({ children }) => {
	return (
		<div className="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 md:gap-2">
			{children}
		</div>
	)
}

export default GridProduct