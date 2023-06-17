import SectionTitle from "@/Components/Sections/SectionTitle"

const Description = ({ product }) => {
	return (
		<div className=" divide-y divide-gray-200">
			<div className="py-content space-y-5 ">
				<SectionTitle title="Especificaciones" />
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

			<div className="py-content space-y-5">
				<SectionTitle title="Descripción" />
				<p dangerouslySetInnerHTML={{ __html: product.description_max }} />
			</div>
		</div>
	)
}

export default Description
