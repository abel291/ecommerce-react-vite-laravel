import { Fragment } from 'react'
import { Disclosure, Menu, Transition } from '@headlessui/react'

import { Link, usePage } from '@inertiajs/react'
import ApplicationLogo from '@/Components/ApplicationLogo'
import ProfileDropdown from '../ProfileDropdown';

import MobileMenuButton from './MobileMenuButton'
import MovileProfileDropdown from './MovileProfileDropdown';
import { UserCircleIcon } from '@heroicons/react/24/outline';

const navigation_profile = [
	{ name: 'Perfil', href: route('my-orders'), current: route().current('my-orders') },
	{ name: 'Ordenes', href: route('profile'), current: route().current('profile') },

]

const navigation_sing = [
	{ name: 'Acceder ', href: route('login'), current: route().current('login') },
	{ name: 'Crear cuenta', href: route('register'), current: route().current('register') },
]

function classNames(...classes) {
	return classes.filter(Boolean).join(' ')
}

export default function MovileNavbar({ navigation }) {
	const { auth } = usePage().props
	return (
		<Disclosure as="nav" className="shadow text-white lg:hidden bg-indigo-600">
			{({ open }) => (
				<>
					<div className="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
						<div className="relative flex h-16 items-center justify-between">

							<div className="absolute inset-y-0 left-0 flex items-center">
								<MobileMenuButton open={open} />
							</div>
							<div className="flex flex-1 items-center justify-center ">
								<div className="flex flex-shrink-0 items-center">
									<ApplicationLogo />
								</div>
							</div>
							<div className="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
								{/* Profile dropdown */}
								<ProfileDropdown >
									<button className="flex text-sm focus:outline-none focus:ring-2 focus:ring-indigo-700 rounded-md focus:ring-offset-2">
										<span className="sr-only">Open user menu</span>
										<UserCircleIcon className="h-8 w-8 text-white" />
									</button>
								</ProfileDropdown>
							</div>
						</div>
					</div>

					<Disclosure.Panel >
						<>
							<div className="space-y-1 px-2 pb-3 pt-2">
								{navigation.map((item) => (
									<Link
										key={item.name}
										href={item.href}
										className={"block rounded-md px-3 py-2 text-base font-medium " + classNames(
											route().current(item.href) ? 'bg-indigo-700' : ' hover:bg-indigo-500 ',
											''
										)}
										aria-current={item.current ? 'page' : undefined}
									>
										{item.name}
									</Link>
								))}


							</div>
							<div class="border-t border-indigo-700  pb-3 pt-4">
								{auth.user ? (
									<>
										<div class="flex items-center px-5">
											<div >
												<div class="text-base font-medium leading-none text-white">{auth.user.name}</div>
												<div class="text-sm font-medium leading-none text-indigo-300 mt-2">{auth.user.email}</div>
											</div>
										</div>
										<div class="mt-3 space-y-1 px-2">
											{navigation_profile.map((item) => (
												<Link
													key={item.name}
													href={item.href}
													className={"block rounded-md px-3 py-2 text-base font-medium " + classNames(
														item.current ? 'bg-indigo-700' : ' hover:bg-indigo-500 ',
														''
													)}
													aria-current={item.current ? 'page' : undefined}
												>
													{item.name}
												</Link>
											))}
											<Link
												key="logout"
												method="post" href={route('logout')}
												as="button"
												className="w-full text-left block rounded-md px-3 py-2 text-base font-medium hover:bg-indigo-500"
											>
												Cerrar sesión
											</Link>
										</div>
									</>
								) : (
									<div class=" space-y-1 px-2">
										{navigation_sing.map((item) => (
											<Link
												key={item.name}
												href={item.href}
												className={"block rounded-md px-3 py-2 text-base font-medium " + classNames(
													item.current ? 'bg-indigo-700' : ' hover:bg-indigo-500 ',
													''
												)}
												aria-current={item.current ? 'page' : undefined}
											>
												{item.name}
											</Link>
										))}

									</div>
								)}
							</div>
						</>

					</Disclosure.Panel>
				</>
			)
			}
		</Disclosure >
	)
}
