import React from 'react'

export default function SectionTitle({ title = null, entry, children, className, ...props }) {
	return (
		<>
			<h2 {...props} className={"title-section " + className}>{title || children}</h2>
			{entry && (<span className="mt-2 inline-block">{entry}</span>)}
		</>

	)
}
