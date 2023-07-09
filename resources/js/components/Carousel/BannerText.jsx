import React from 'react'

function BannerText({ title, img = null, entry }) {
	const text = "La mejor forma de renovar tu ordenador o actualizar alguno de sus componentes es comprando en PcComponentes. ¿Por qué? Pues porque PcComponentes te ofrece el mayor catálogo de componentes de ordenador al mejor precio. Nuestro catálogo se actualiza día a día para que disfrutes de las últimas novedades en tecnología."
	return (
		<div className='gradient-primary'>
			<div className='container'>
				<div className='w-ful rounded-lg lg:flex lg:items-center lg:justify-around overflow-hidden h-96 py-10'>
					<div className='lg:w-5/12  lg:px-8  '>
						<h2 className='text-4xl font-bold tracking-tight text-white sm:text-6xl'>{title}</h2>
						<p className='mt-6 text-lg leading-7 text-white'>{entry}</p>

					</div>
					{img && (
						<div className='lg:w-7/12 mt-8 lg:mt-0 '>
							<img className='lg:h-80 object-contain lg:object-bottom rounded-xl mx-auto' src={img} alt={title} />
						</div>
					)}
				</div>
			</div>
		</div >
	)
}

export default BannerText
