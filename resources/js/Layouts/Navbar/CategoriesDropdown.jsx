import { Popover, Transition } from '@headlessui/react'
import { ChevronDownIcon } from '@heroicons/react/24/solid'
import { Link, usePage } from '@inertiajs/react'
import { Fragment } from 'react'

export default function CategoriesDropdown() {
	const { categories } = usePage().props
	return (
		<Popover >
			<Popover.Button className="focus:ring-0 focus:border-none focus:outline-none">
				<div className="flex items-center">
					<span>Categorias</span>
					<ChevronDownIcon className="h-4 w-4 ml-1" />
				</div>
			</Popover.Button>

			<Transition
				as={Fragment}
				enter="transition ease-out duration-200"
				enterFrom="opacity-0 translate-y-1"
				enterTo="opacity-100 translate-y-0"
				leave="transition ease-in duration-150"
				leaveFrom="opacity-100 translate-y-0"
				leaveTo="opacity-0 translate-y-1"
			>
				<Popover.Panel className="absolute inset-x-0 z-20 mt-2 max-w-3xl">
					{({ close }) => (
						<div className="overflow-hidden rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white">
							<div className="p-4 lg:p-7 grid  grid-cols-2  lg:grid-cols-3 gap-4 lg:gap-5 ">
								{categories.map((item) => (
									<div key={item.id}>
										<Popover.Button >
											<div>
												<Link
													href='/search' data={{ categories: item.slug }}

													onClick={close}
												>
													<div className="flex items-center">
														<div className="mr-3 w-16 h-16 p-1 bg-gray-200 rounded-lg flex items-center">
															<img src={"/img/categories/" + item.img} alt={item.name} />
														</div>
														<div className="lg:text-base font-semibold">{item.name}</div>
													</div>
												</Link>
											</div>
										</Popover.Button>
									</div>
								))}
							</div>
							<div className="p-4 lg:p-5 bg-gray-50 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus-visible:ring focus-visible:ring-red-500 focus-visible:ring-opacity-50">
								<div className="text-right">
									<Link to="/search">
										<span className="text-sm font-semibold ">Ver todo los productos</span>
									</Link>

								</div>
							</div>
						</div>
					)}
				</Popover.Panel>
			</Transition >

		</Popover >
	)
}
