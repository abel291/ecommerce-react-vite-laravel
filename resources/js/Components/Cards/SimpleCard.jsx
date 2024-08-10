import React from 'react'

function SimpleCard({ name, img }) {
    return (
        <div className="flex flex-col items-center">
            <div className="w-52 max-w-full  first-line:w-52 px-6 py-5 rounded-lg bg-gray-50 flex items-center justify-center aspect-square">
                <img src={img} className="max-w-full pt-4 max-h-36" alt={name} />
            </div>

            <span className="font-medium mt-4 text-sm md:text-base ">{name}</span>
        </div>
    )
}

export default SimpleCard
