const LoadingPage = ({ textLoaidng = "cargando..." }) => {
    return (
        <div className='container py-content animate-pulse'>
            <div className='grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-5 '>
                <div className=' relative col-span-1 md:col-span-2 md:h-32 lg:h-72 w-full rounded bg-gray-200 '>
                    <span className="absolute top-2 left-2 text-gray-400 ">{textLoaidng}</span>
                </div>
                <div className='rounded bg-gray-200 md:h-32 lg:h-80'></div>
                <div className='rounded bg-gray-200 md:h-32 lg:h-80'></div>
            </div>
            <div className='py-content'>
            <div className='h-5 w-40 bg-gray-200 rounded  '></div>
            <div className='grid grid-cols-2 gap-2 md:grid-cols-3 lg:grid-cols-4 md:gap-6 mt-4'>
                {[1, 2, 3, 4, 5, 6, 7, 8].map((item) => (
                    <div key={item} className=' space-y-2 '>
                        <div className=' rounded bg-gray-200 h-40'></div>
                        <div className='h-4 rounded bg-gray-200 w-1/2'></div>
                        <div className='h-4 rounded bg-gray-200 w-full'></div>
                        <div className='h-4 rounded bg-gray-200 w-full'></div>
                        <div className='h-4 rounded bg-gray-200 w-full'></div>
                    </div>
                ))}
            </div>
        </div>
        </div>
    )
}

export default LoadingPage
