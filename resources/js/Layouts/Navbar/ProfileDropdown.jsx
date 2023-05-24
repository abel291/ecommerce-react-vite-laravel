import Dropdown from "@/Components/Dropdown"
import { Menu, Transition } from "@headlessui/react"
import { ArrowLeftOnRectangleIcon, ArrowRightOnRectangleIcon, ShoppingBagIcon, UserCircleIcon } from "@heroicons/react/24/outline"

import { Link, usePage } from "@inertiajs/react"
import { Fragment } from "react"


export default function ProfileDropdown({ children }) {
	const navigation_profile = [
		{
			name: 'Perfil',
			href: route('profile'),
			current: route().current('profile'),
			icon: UserCircleIcon
		},
		{
			name: 'Ordenes',
			href: route('my-orders'),
			current: route().current('my-orders'),
			icon: ShoppingBagIcon
		},

	]
	const navigation_sing = [
		{
			name: 'Acceder ',
			href: route('login'),
			current: route().current('login'),
			icon: ArrowRightOnRectangleIcon
		},

		{
			name: 'Crear cuenta',
			href: route('register'),
			current: route().current('register'),
			icon: ArrowLeftOnRectangleIcon
		},
	]


	const { auth } = usePage().props
	return (
		<>
			<Dropdown>
				<Dropdown.Trigger>

					{children}
				</Dropdown.Trigger>
				<Dropdown.Content>
					{auth.user ? (
						<>
							{navigation_profile.map((item) => (
								<Dropdown.Link href={item.href} key={item.name} >
									<div className="flex items-center">
										<item.icon className="h-5 w-5 mr-2 text-indigo-600" />
										<span>{item.name}</span>
									</div>
								</Dropdown.Link>

							))}
							<Dropdown.Link href={route('logout')} method="post" className='border-t'>
								Cerrar sesión
							</Dropdown.Link>
						</>
					) : (
						navigation_sing.map((item) => (
							<Dropdown.Link href={item.href}>
								<div className="flex items-center">
									<item.icon className="h-5 w-5 mr-2 text-gray-400" />
									<span>{item.name}</span>
								</div>
							</Dropdown.Link>

						))
					)}




				</Dropdown.Content>
			</Dropdown >

		</>
	)
}
