import React from 'react'

export default function Badge({ children, className }) {
	return (
		<span className={"inline-flex items-center rounded-md  px-2 py-1 text-xs font-medium  ring-1 ring-inset " + className}>{children}</span>
	)
}
// color bg-orange-50 text-orange-600 ring-orange-500/10 