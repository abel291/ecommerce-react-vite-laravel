import React from 'react'

function LabelInput({ children }) {
	return (
		<label className="block text-sm font-medium leading-6 text-gray-900 mb-1">{children}</label>
	)
}

export default LabelInput