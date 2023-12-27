import React from 'react'

const Hero = ({ title, entry, className }) => {
    return (
        <div className={"pt-content " + className}>
            <h2 className='text-3xl font-bold tracking-tight sm:text-5xl'>{title}</h2>
            <p className='mt-6 text-lg leading-7 '>{entry}</p>

        </div>
    )
}

export default Hero
