import React from 'react'

export default function SectionTitle({ title, entry }) {
	return (
		<>
			<h2 className="font-semibold text-3xl">{title}</h2>
			{entry && (<span className="mt-2 inline-block">{entry}</span>)}
		</>

	)
}
