import { Menu, Transition } from "@headlessui/react"
import { ArrowsRightLeftIcon, ChevronDownIcon, ShoppingBagIcon, UserCircleIcon } from "@heroicons/react/24/solid"
import { Link, usePage } from "@inertiajs/react"
import { Fragment } from "react"


export default function ProfileDropdown() {

	const { auth } = usePage().props
	return (
		<Menu as="div" className="relative inline-block z-40 ">
			<Menu.Button className="inline-flex items-center rounded-md">
				{auth.user.name}
				<ChevronDownIcon className="w-4 h-4 ml-1 -mr-1 text-gray-800" aria-hidden="true" />
			</Menu.Button>

			<Transition
				as={Fragment}
				enter="transition ease-out duration-100"
				enterFrom="transform opacity-0 scale-95"
				enterTo="transform opacity-100 scale-100"
				leave="transition ease-in duration-75"
				leaveFrom="transform opacity-100 scale-100"
				leaveTo="transform opacity-0 scale-95"
			>
				<Menu.Items className="absolute right-0 w-52 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none overflow-hidden">
					<div className="">
						<Menu.Item>
							<Link href="/my-account" className="px-3 py-3 block hover:bg-gray-50">
								<div className="flex items-center">
									<UserCircleIcon className="h-5 w-5 mr-2 text-red-700" />
									<span>Mi cuenta</span>
								</div>
							</Link>
						</Menu.Item>
						<Menu.Item>
							<Link href="/my-account/order" className="px-3 py-3 block hover:bg-gray-50">
								<div className="flex items-center">
									<ShoppingBagIcon className="h-5 w-5 mr-2 text-red-700" />
									<span>Ordenes</span>
								</div>
							</Link>
						</Menu.Item>
					</div>
					<div className="">
						<Menu.Item>
							<Link method="post" href={route('logout')} as="button" className="px-3 py-3 block hover:bg-gray-50 w-full text-left">
								Cerrar sesión
							</Link>
						</Menu.Item>
					</div>
				</Menu.Items>
			</Transition>
		</Menu>
	)
}
