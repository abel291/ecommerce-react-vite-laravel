const Description = ({ product }) => {
	return (
		<div className="divide-y divide-gray-200">
			<div className="py-content space-y-4">
				<h3 className="text-2xl font-bold">Especificaciones</h3>
				<div>
					<table className="text-left">
						<thead></thead>
						<tbody>
							{product.specifications.map((specification) => (
								<tr key={specification.id}>
									<td className=" font-semibold pr-10 pb-1">{specification.name}</td>
									<td>{specification.value}</td>
								</tr>
							))}
						</tbody>
					</table>
				</div>
			</div>

			<div className="py-content space-y-4">
				<h3 className="text-2xl font-bold">Descripción</h3>
				<p className="">{product.description_max}</p>
			</div>
		</div>
	)
}

export default Description
