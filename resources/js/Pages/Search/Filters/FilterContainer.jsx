import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/react'
import { MinusIcon, PlusIcon } from '@heroicons/react/24/outline'
import React from 'react'

const FilterContainer = ({ title, children, ...props }) => {
    return (
        <Disclosure {...props} as="div" className="border-b border-gray-200 py-5" defaultOpen={true}>
            {({ open = true }) => (
                <>
                    <h3 className="-my-2 flow-root ">
                        <DisclosureButton className="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500">
                            <span className="font-medium text-gray-900">{title}</span>
                            <span className="ml-6 flex items-center">
                                {open ? (
                                    <MinusIcon className="h-5 w-5" aria-hidden="true" />
                                ) : (
                                    <PlusIcon className="h-5 w-5" aria-hidden="true" />
                                )}
                            </span>
                        </DisclosureButton >
                    </h3>

                    <DisclosurePanel className="mt-4 origin-top transition duration-200 ease-out data-[closed]:-translate-y-6 data-[closed]:opacity-0 data-[opened]:translate-y-0">
                        <div className="">
                            {children}
                        </div>
                    </DisclosurePanel >

                </>
            )}
        </Disclosure>
    )
}

export default FilterContainer
