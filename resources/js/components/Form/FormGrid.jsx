import React from 'react'

export const FormGrid = ({ children, className, ...props }) => {
	return (
		<div className={"grid grid-cols-1 md:grid-cols-6 gap-x-4 gap-y-6 " + className} {...props}>

			{children}

		</div>
	)
}
