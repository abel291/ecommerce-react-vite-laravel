import React from 'react'
import SectionTitle from './SectionTitle'

const SectionList = ({ children, title, entry }) => {
	return (
		<div className="py-content">
			<SectionTitle title={title} entry={entry} />
			<div className="mt-8">
				{children}
			</div>
		</div>
	)
}

export default SectionList