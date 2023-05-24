import React from 'react'

export default function SectionTitle({ title, entry, ...props }) {
	return (
		<>
			<h2 {...props} className="title-section">{title}</h2>
			{entry && (<span className="mt-2 inline-block">{entry}</span>)}
		</>

	)
}
