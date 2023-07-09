import { Disclosure, Transition } from '@headlessui/react'
import { MinusIcon, PlusIcon } from '@heroicons/react/24/outline'
import React from 'react'

const FilterContainer = ({ title, children, ...props }) => {
	return (
		<Disclosure {...props} as="div" className="border-b border-gray-200 pt-5  " defaultOpen={true}>
			{({ open = true }) => (
				<>
					<h3 className="-my-2 flow-root ">
						<Disclosure.Button className="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500">
							<span className="font-medium text-gray-900">{title}</span>
							<span className="ml-6 flex items-center">
								{open ? (
									<MinusIcon className="h-5 w-5" aria-hidden="true" />
								) : (
									<PlusIcon className="h-5 w-5" aria-hidden="true" />
								)}
							</span>
						</Disclosure.Button>
					</h3>
					<Transition
						enter="transition duration-100 ease-out"
						enterFrom="transform scale-95 opacity-0"
						enterTo="transform scale-100 opacity-100"
						leave="transition duration-75 ease-out"
						leaveFrom="transform scale-100 opacity-100"
						leaveTo="transform scale-95 opacity-0"
					>
						<Disclosure.Panel className="mt-4">
							<div className="">
								{children}
							</div>
						</Disclosure.Panel>
					</Transition>
				</>
			)}
		</Disclosure>
	)
}

export default FilterContainer