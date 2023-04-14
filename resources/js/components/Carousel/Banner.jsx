import { Link } from '@inertiajs/react'
import React from 'react'

export default function Banner({ img }) {
	return (
		<Link href="/search">
			<div className="w-full">
				<img className="w-full rounded md:rounded-xl shadow" src={img.img} alt={img.alt} />
			</div>
		</Link>
	)
}
