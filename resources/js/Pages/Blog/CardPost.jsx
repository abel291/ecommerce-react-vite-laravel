import Badge from '@/Components/Badge'
import { formatDateRelative } from '@/Helpers/helpers'
import { ArrowDownLeftIcon, ArrowLeftIcon, ArrowRightIcon, CalendarDaysIcon } from '@heroicons/react/24/solid'
import { Link } from '@inertiajs/react'
import React from 'react'
import AuthorPost from './AuthorPost'

export default function CardPost({ post }) {
	return (
		<article className="flex max-w-xl flex-col items-start ">
			<div>
				<img className="aspect-video object-cover object-center rounded-lg" src={post.img} alt="" />
			</div>
			<div className="flex items-center gap-x-4 text-xs mt-6 w-full">
				<time dateTime={post.created_at} className="text-gray-500 uppercase font-medium">{post.date}</time>
				<Link href={route('blog', { category: post.category.slug })} >
					<Badge className="hover:bg-gray-200">{post.category.name}</Badge>
				</Link>
			</div>
			<div className="group grow relative mt-2">
				<h3 className=" text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
					<Link href={route('post', post.slug)}>
						<span className="absolute inset-0"></span>
						{post.title}
					</Link>
				</h3>
				<p className="mt-3 line-clamp-3 text-sm leading-6 text-gray-600">{post.entry}</p>
			</div>
			<div className="mt-3">
				<AuthorPost author={post.author} />
			</div>
		</article>


	)
}

