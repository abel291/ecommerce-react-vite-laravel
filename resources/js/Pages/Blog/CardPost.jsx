import { formatDateRelative } from '@/Helpers/helpers'
import { ArrowDownLeftIcon, ArrowLeftIcon, ArrowRightIcon, CalendarDaysIcon } from '@heroicons/react/24/solid'
import { Link } from '@inertiajs/react'
import React from 'react'

export default function CardPost({ post }) {
	return (

		<article className=" bg-white flex flex-col ">
			<div className="mb-5 overflow-hidden rounded-lg">
				<img src={post.img} alt="" className=" xl:h-64  w-full object-cover object-center transition hover:scale-110" />
			</div>
			<div className="px-1 flex flex-col grow">
				<div className="flex justify-between items-center mb-2 text-gray-500">
					<div className="flex items-center">
						<CalendarDaysIcon className="w-5 h-5 mr-2" />
						<span className="text-sm">{post.dateRelative}</span>
					</div>
				</div>
				<h2 className=" mb-2 text-xl font-semibold tracking-tight text-gray-900 ">{post.title}</h2>
				<div className="grow">
					<p className="mb-3  text-gray-500 line-clamp-4">{post.entry}</p>
				</div>
				<div className="flex justify-end items-center">

					<Link href={route('post', post.slug)} className="inline-flex items-center font-medium text-primary-600 hover:underline text-blue-500">
						Leer mas
						<ArrowRightIcon className="w-4 h-4 ml-1" />
					</Link>
				</div>
			</div>
		</article>

	)
}
