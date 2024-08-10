import Dropdown from '@/Components/Dropdown'
import { ShoppingBagIcon, UserCircleIcon } from '@heroicons/react/24/outline'

import React from 'react'

function MovileProfileDropdown() {
	return (
		<Dropdown>
			<Dropdown.Trigger>
				<button className="flex text-sm focus:outline-none focus:ring-2 focus:ring-primary-700 rounded-md focus:ring-offset-2">
					<span className="sr-only">Open user menu</span>
					<UserCircleIcon className="h-8 w-8 text-white" />
				</button>

			</Dropdown.Trigger>
			<Dropdown.Content>
				<Dropdown.Link href={route('profile')}>
					<div className="flex items-center">
						<UserCircleIcon className="h-5 w-5 mr-2 text-gray-400" />
						<span>Mi cuenta</span>
					</div>
				</Dropdown.Link>
				<Dropdown.Link href={route('orders')}>
					<div className="flex items-center">
						<ShoppingBagIcon className="h-5 w-5 mr-2 text-gray-400" />
						<span>Ordenes</span>
					</div>
				</Dropdown.Link>
				<Dropdown.Link href={route('logout')} method="post" className='border-t'>
					Cerrar sesión
				</Dropdown.Link>
			</Dropdown.Content>
		</Dropdown>
	)
}

export default MovileProfileDropdown