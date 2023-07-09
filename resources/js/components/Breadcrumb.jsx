import React from 'react'

const Breadcrumb = ({ data = [] }) => {

	const breadcrumb = [
		{
			title: 'home',
			path: route('home')
		},
		...data
	]
	return (
		(data.length > 0) && (
			<nav aria-label="Breadcrumb" className='container py-6'>
				<ol role="list" className="mx-auto flex items-center space-x-2">
					{breadcrumb.map((item, key) => (
						<li key={key} className='text-sm font-medium flex items-center'>
							{(key != 0) && (
								<svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor" aria-hidden="true" className="h-5 w-4 text-gray-300 mr-2">
									<path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
								</svg>
							)}
							<div className="flex items-center ">
								{item.path ? (
									<a className='first-letter:capitalize' href={item.path} >{item.title}</a>
								) : (
									<span href="#" aria-current="page" className="font-medium text-gray-500 hover:text-gray-600 first-letter:capitalize">{item.title}</span>
								)}
							</div>
						</li>
					))}
				</ol>
			</nav >
		)
	)
}

export default Breadcrumb