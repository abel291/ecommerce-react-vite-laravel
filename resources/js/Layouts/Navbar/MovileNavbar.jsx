import { Fragment } from 'react'
import { Disclosure, Menu, Transition } from '@headlessui/react'
import { Bars3Icon, BellIcon, UserCircleIcon, XMarkIcon } from '@heroicons/react/24/outline'
import { Link, usePage } from '@inertiajs/react'
import ApplicationLogo from '@/Components/ApplicationLogo'

const navigation = [
	{ name: 'Dashboard', href: '#', current: true },
	{ name: 'Team', href: '#', current: false },
	{ name: 'Projects', href: '#', current: false },
	{ name: 'Calendar', href: '#', current: false },
]

function classNames(...classes) {
	return classes.filter(Boolean).join(' ')
}

export default function MovilNavbar({ navigation }) {
	const { auth } = usePage().props
	return (
		<Disclosure as="nav" className="bg-gray-50 shadow text-gray-700 lg:hidden">
			{({ open }) => (
				<>
					<div className="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
						<div className="relative flex h-16 items-center justify-between">
							<div className="absolute inset-y-0 left-0 flex items-center">
								{/* Mobile menu button*/}
								<Disclosure.Button className="inline-flex items-center justify-center rounded-md p-2 text-gray-500  hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-orange-400">
									<span className="sr-only">Open main menu</span>
									{open ? (
										<XMarkIcon className="block h-6 w-6" aria-hidden="true" />
									) : (
										<Bars3Icon className="block h-6 w-6" aria-hidden="true" />
									)}
								</Disclosure.Button>
							</div>
							<div className="flex flex-1 items-center justify-center ">
								<div className="flex flex-shrink-0 items-center">
									<ApplicationLogo />
								</div>

							</div>
							<div className="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
								{/* Profile dropdown */}
								<Menu as="div" className="relative ml-3">
									<div>
										<Menu.Button className="flex text-sm focus:outline-none focus:ring-2 focus:ring-orange-600 rounded-md focus:ring-offset-2 ">
											<span className="sr-only">Open user menu</span>
											<UserCircleIcon className="h-8 w-8 text-orange-600" />

										</Menu.Button>
									</div>
									<Transition
										as={Fragment}
										enter="transition ease-out duration-100"
										enterFrom="transform opacity-0 scale-95"
										enterTo="transform opacity-100 scale-100"
										leave="transition ease-in duration-75"
										leaveFrom="transform opacity-100 scale-100"
										leaveTo="transform opacity-0 scale-95"
									>
										<Menu.Items className="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
											{auth.user ? (
												<>
													<Menu.Item>

														<Link
															href={route('profile')}
															className={'block px-4 py-2 text-sm text-gray-700'}
														>
															Tu perfil
														</Link>

													</Menu.Item>
													<Menu.Item>

														<Link
															href={route('my-orders')}
															className={'block px-4 py-2 text-sm text-gray-700'}
														>
															Ordenes
														</Link>

													</Menu.Item>
													<Menu.Item>

														<Link
															method="post"
															href={route('logout')}
															className={'block px-4 py-2 text-sm text-gray-700'}
														>
															Salir
														</Link>

													</Menu.Item>
												</>
											) : (
												<>
													<Menu.Item>

														<Link
															href={route('login')}
															className={'block px-4 py-2 text-sm text-gray-700'}
														>
															Iniciar Sesion
														</Link>

													</Menu.Item>
													<Menu.Item>

														<Link
															href={route('register')}
															className={'block px-4 py-2 text-sm text-gray-700'}
														>
															Registrarse
														</Link>

													</Menu.Item></>
											)}
										</Menu.Items>
									</Transition>
								</Menu>
							</div>
						</div>
					</div>

					<Disclosure.Panel >
						<div className="space-y-1 px-2 pb-3 pt-2">
							{navigation.map((item) => (
								<Link
									key={item.name}

									href={item.href}
									className={classNames(
										route().current(item.href) ? 'bg-orange-100 text-orange-600' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700',
										'block rounded-md px-3 py-2 text-base font-medium'
									)}
									aria-current={item.current ? 'page' : undefined}
								>
									{item.name}
								</Link>
							))}
						</div>
					</Disclosure.Panel>
				</>
			)}
		</Disclosure>
	)
}
