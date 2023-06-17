import React from 'react'

const Breadcrumb = ({ data }) => {

	const lastItem = data[data.length - 1];
	return (
		<nav aria-label="Breadcrumb">
			<ol role="list" className="mx-auto flex items-center space-x-2">
				{data.map((item, key) => (
					<li key={key} className='text-sm font-medium'>
						{(lastItem != item) ? (
							<div className="flex items-center">
								{item.path ? (
									<a href={item.path} >{item.title}</a>
								) : (
									<span href={item.path} >{item.title}</span>
								)}

								<svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor" aria-hidden="true" className="h-5 w-4 text-gray-300 ml-2">
									<path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
								</svg>

							</div>
						) : (
							<span href="#" aria-current="page" className="font-medium text-gray-500 hover:text-gray-600 ">{item.title}</span>
						)}
					</li>
				))}



			</ol>
		</nav >
	)
}

export default Breadcrumb