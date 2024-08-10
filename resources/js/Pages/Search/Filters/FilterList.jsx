import React from 'react'

function FilterList({ optionsList, setFilter, nameFilter, title }) {
    const handleClick = (value) => {
        setFilter(nameFilter, value)
    }

    return (
        <>
            <h3 className="font-medium mb-4 ">{title}</h3>
            <div className="space-y-2 text-sm font-normal text-gray-700">
                {optionsList.map((item, index) => (
                    <button key={item.value} className='block' onClick={() => handleClick(item.value)}> {item.name} ({item.products_count}) </button>
                ))}
            </div>
        </>
    )
}

export default FilterList
