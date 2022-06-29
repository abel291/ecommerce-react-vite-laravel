const Pagination = ({ paginator, handleClickChangePage }) => {
    return (
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
                        {paginator.current_page === 1 ? (
                            <span className=" px-4 py-2 font-semibold bg-gray-100 border border-gray-100 text-gray-300 cursor-default rounded-md">
                                Anterior
                            </span>
                        ) : (
                            <button
                                onClick={() => handleClickChangePage(parseInt(paginator.current_page - 1))}
                                rel="prev"
                                className="  px-4 py-2 border border-gray-300  font-semibold rounded-md  bg-white hover:bg-gray-50"
                            >
                                Anterior
                            </button>
                        )}

                        {paginator.next_page_url == null ? (
                            <span className=" px-4 py-2 font-semibold bg-gray-100 border border-gray-100 text-gray-300 cursor-default rounded-md">
                                Siguente
                            </span>
                        ) : (
                            <button
                                onClick={() => handleClickChangePage(parseInt(paginator.current_page + 1))}
                                rel="next"
                                className=" px-4 py-2 border border-gray-300 font-semibold rounded-md  bg-white hover:bg-gray-50"
                            >
                                Siguiente
                            </button>
                        )}
                    </nav>
                )}
            </div>
        </div>
    )
}

export default Pagination
