import SectionTitle from '@/Components/Sections/SectionTitle'
import React from 'react'

const Specifications = ({ specifications }) => {
	return (
		<>

			<div className="grid grid-cols-1 lg:grid-cols-2 gap-x-4 gap-y-8 mt-8">
				{Object.entries(specifications).map(([specificationsName, value]) => (
					<div className="w-full" key={specificationsName}>
						<h3 className="font-medium">{specificationsName}</h3>

						<div className="rounded-md border border-gray-100  mt-4">
							<table className="text-left w-full table-fixed  ">
								<tbody>
									{value.map((item) => (
										<tr key={item.id} className="even:bg-white odd:bg-gray-100">
											<td className="px-3 py-3 text-start text-sm font-medium pr-10 align-top">{item.name}</td>
											<td className="px-3 py-3 text-start text-sm">{item.value}</td>
										</tr>
									))}
								</tbody>
							</table>
						</div>
					</div>
				))}
			</div>

		</>

	)
}

export default Specifications