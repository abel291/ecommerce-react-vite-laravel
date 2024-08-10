import React from 'react'

const GridProduct = ({ children }) => {
    return (
        <div className="grid grid-cols-1 gap-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
            {children}
        </div>
    )
}

export default GridProduct
