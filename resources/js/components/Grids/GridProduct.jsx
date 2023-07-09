import React from 'react'

const GridProduct = ({ children }) => {
	return (
		<div className="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 md:gap-4">
			{children}
		</div>
	)
}

export default GridProduct