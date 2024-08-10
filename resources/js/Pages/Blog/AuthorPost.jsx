import { Link } from '@inertiajs/react'
import React from 'react'

const AuthorPost = ({ author }) => {
	return (
		<div className="relative flex items-center gap-x-4">
			<img src={author.img} className="h-10 w-10 rounded-full bg-gray-50 object-cover object-center"></img>
			<div className="text-sm leading-6 relative">
				<p className="font-semibold text-gray-900">
					<Link href={route('post.author', author.name)} >
						<span className="absolute inset-0"></span>
						{author.name}
					</Link>
				</p>
				<p className="text-gray-600">{author.position}</p>
			</div>
		</div>

	)
}

export default AuthorPost