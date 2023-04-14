import React from 'react'

const SectionList = ({ children, title }) => {
	return (
		<div className="py-content">
			<h2 className="font-semibold text-3xl">{title}</h2>
			<div className="mt-8">
				{children}
			</div>
		</div>
	)
}

export default SectionList