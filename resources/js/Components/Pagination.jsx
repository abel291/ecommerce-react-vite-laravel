import { Link } from "@inertiajs/react"

const Pagination = ({ paginator }) => {
	const prevPage = paginator.links[0].url
	const netxPage = paginator.links.slice(-1)[0].url
	return (

		paginator.total > paginator.per_page && (
			<div className="sm:flex-1 sm:flex sm:items-center sm:justify-between text-sm">
				<div className="hidden sm:block">
					<p className="">
						Muestra
						<span className="font-bold"> {paginator.from} </span>a<span className="font-bold"> {paginator.to} </span>
						de
						<span className="font-bold"> {paginator.total} </span>
						resultados
					</p>
				</div>
				<div>
					{paginator.total > paginator.per_page && (
						<nav role="navigation" aria-label="Pagination Navigation" className="flex justify-end space-x-2 ">
							{prevPage === null ? (
								<span className=" px-4 py-2 font-semibold bg-gray-100 border border-gray-100 text-gray-300 cursor-default rounded-md">
									Anterior
								</span>
							) : (
								<Link href={prevPage}
									rel="prev"
									className="px-4 py-2 border border-gray-300  font-semibold rounded-md  bg-white hover:bg-gray-50"
								>
									Anterior
								</Link>

							)}

							{netxPage === null ? (
								<span className=" px-4 py-2 font-semibold bg-gray-100 border border-gray-100 text-gray-300 cursor-default rounded-md">
									Siguente
								</span>
							) : (
								<Link href={netxPage}
									rel="next"
									className="px-4 py-2 border border-gray-300  font-semibold rounded-md  bg-white hover:bg-gray-50"
								>
									Siguente
								</Link>
							)}
						</nav>
					)}
				</div>
			</div>
		)

	)
}

export default Pagination
