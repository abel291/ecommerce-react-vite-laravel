import React from 'react'

export const FormGrid = ({ children }) => {
	return (
		<div className="grid grid-cols-1 md:grid-cols-6 gap-x-6 gap-y-6">{children}</div>
	)
}
