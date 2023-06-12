import React from 'react'

export default function Badge({ children, className, color = 'gray' }) {
	let colors = {
		'gray': ' bg-gray-100  text-gray-700 ring-gray-500/10',
		'red': ' bg-red-50  text-red-700 ring-red-600/10',
		'yellow': ' bg-yellow-50  text-yellow-800 ring-yellow-600/20',
		'green': ' bg-green-100  text-green-700 ring-green-600/20',
		'blue': ' bg-blue-50  text-blue-700 ring-blue-700/10',
		'indigo': ' bg-primary-50  text-primary-700 ring-primary-700/10',
		'purple': ' bg-purple-50  text-purple-700 ring-purple-700/10',
		'pink': ' bg-pink-50  text-pink-700 ring-pink-700/10',
		'orange': 'bg-orange-50  text-orange-700 ring-orange-700/10',
	};
	return (
		<span className={className + " inline-flex items-center rounded-md  px-2 py-1 text-xs font-medium  ring-1 ring-inset  " + colors[color]}>{children}</span>
	)
}
// color bg-orange-50 text-orange-600 ring-orange-500/10
