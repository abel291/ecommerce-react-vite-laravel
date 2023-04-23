import NavLink from '@/Components/NavLink'
import Layout from '@/Layouts/Layout'
import { Head, Link } from '@inertiajs/react'
import React from 'react'
import Dashboard from './Dashboard'
import BannerWithTitle from '@/Components/Carousel/BannerWithTitle'
import { ArrowRightOnRectangleIcon, HomeIcon, IdentificationIcon, LockClosedIcon, ShoppingCartIcon, UserCircleIcon } from '@heroicons/react/24/outline'


export default function Profile({ children }) {
	const links = [
		{
			title: 'Dashboard',
			path: 'profile',
			Icon: HomeIcon
		},
		{
			title: 'Ordenes',
			path: 'my-orders',
			Icon: ShoppingCartIcon
		},
		{
			title: 'Detalles de cuenta',
			path: 'profile-details',
			Icon: IdentificationIcon
		},
		{
			title: 'Cambiar contraseña',
			path: 'profile-password',
			Icon: LockClosedIcon
		},

	]
	return (
		<Layout>

			<BannerWithTitle title="Mi cuenta" image="/img/banner-my-account.jpg" />
			<div className="container py-content">
				<div className="grid grid-cols-12 md:gap-6 gap-y-10 py-10">
					<div className="col-span-12 lg:col-span-3">
						<div className="flex flex-col space-y-1">

							{links.map((item) => (
								<Link preserveScroll key={item.path} href={route(item.path)} className={'block px-4 py-3 rounded-md ' + (route().current(item.path) ? 'bg-gray-100 font-medium' : '')}>
									<div className="flex items-center gap-3">
										<item.Icon className="w-6 h-6" />
										{item.title}

									</div>
								</Link>
							))}


						</div>
						<Link method="post" as="button" href={route('logout')} className={'block px-4 py-3 rounded-md border-t border-gray-100 mt-4'}>
							<div className="flex items-center gap-3">
								<ArrowRightOnRectangleIcon className="w-6 h-6" />
								Cerrar Session
							</div>
						</Link>
					</div>
					<div className="col-span-12 lg:col-span-9 md:pl-10">
						<div>
							{children}
						</div>
					</div>
				</div>
			</div>
		</Layout>
	)
}
