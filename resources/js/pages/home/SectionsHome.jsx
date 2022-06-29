import React from 'react'

const Sections = ({ children, title }) => {
    return (
        <div className="py-content space-y-4">
            <h2 className="font-semibold text-2xl">{title}</h2>
            {children}
        </div>
    )
}

export default Sections