import { Link } from '@inertiajs/react'
import React from 'react'

export default function Banner({ image }) {
	return (
		<a href={image.link}>
			<div className="w-full">
				<img className="w-full rounded md:rounded-xl shadow" src={image.img} alt={image.alt} />
			</div>
		</a>
	)
}
