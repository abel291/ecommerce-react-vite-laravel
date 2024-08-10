import SectionTitle from "@/Components/Sections/SectionTitle"
import Specifications from "./Specifications"

const Description = ({ product }) => {
	return (
		<div className="">
			<div className="pt-content">
				<SectionTitle title="Especificaciones" />
				<div className="mt-5">
					<Specifications specifications={product.specifications} />
				</div>
			</div>

			<div className="py-content">
				<SectionTitle title="Descripción" />
				<div className="mt-5">
					<p className="break-words " dangerouslySetInnerHTML={{ __html: product.description_max }} />
				</div>
			</div>
		</div >
	)
}

export default Description
