import React from 'react'

const CartAttributes = ({ attributes }) => {
	let newAttrributes = [];
	Object.entries(attributes).forEach(([attribute, value]) => {
		newAttrributes.push(
			<tr className="" key={attribute}>
				<td className=" font-medium pr-3 ">{attribute}</td>
				<td className=" text-gray-500">{value}</td>
			</tr>
		);
	});
	return (
		<div className="hidden lg:block text-sm">
			<div className="text-sm">
				<table>
					<tbody>
						{newAttrributes}
					</tbody>
				</table>
			</div>
		</div>
	);
}

export default CartAttributes