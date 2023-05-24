import React from 'react'

export default function Badge({ children, className, color = 'gray' }) {
	let colors = {
		'gray': 'bg-gray-100 text-gray-500',
		'red': 'bg-red-100 text-red-700',
		'yellow': 'bg-yellow-100 text-yellow-600',
		'green': 'bg-green-100 text-green-600',
		'blue': 'bg-blue-100 text-blue-700',
		'indigo': 'bg-indigo-100 text-indigo-700',
		'purple': 'bg-purple-100 text-purple-700',
		'pink': 'bg-pink-100 text-pink-700',
		'orange': 'bg-orange-100 text-orange-600',
	};
	return (
		<span className={className + " text-xs inline-flex items-center rounded-md whitespace-nowrap px-2 py-1 font-medium " + colors[color]}>{children}</span>
	)
}
// color bg-orange-50 text-orange-600 ring-orange-500/10 