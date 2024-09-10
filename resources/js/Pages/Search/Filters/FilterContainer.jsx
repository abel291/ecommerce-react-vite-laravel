import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/react'
import { MinusIcon, PlusIcon } from '@heroicons/react/24/outline'
import React from 'react'

const FilterContainer = ({ title, children, defaultOpen = true, ...props }) => {
    return (
        <Disclosure {...props} as="div" className="border-b border-gray-200 py-5" defaultOpen={defaultOpen}>
            {({ open = true }) => (
                <>
                    <h3 className="">
                        <DisclosureButton className="flex w-full items-center justify-between ">
                            <span className="font-medium text-gray-900 text-sm">{title}</span>
                            <span className="ml-6 flex items-center">
                                {open ? (
                                    <MinusIcon className="h-5 w-5" aria-hidden="true" />
                                ) : (
                                    <PlusIcon className="h-5 w-5" aria-hidden="true" />
                                )}
                            </span>
                        </DisclosureButton>
                    </h3>

                    <DisclosurePanel
                    // className="origin-top transition duration-200 ease-out data-[closed]:-translate-y-6 data-[closed]:opacity-0"
                    >

                        <div className='max-h-[300px] [overflow-y:overlay] pt-2 pl-2 mt-4' >
                            {children}
                        </div>
                    </DisclosurePanel>
                </>
            )}
        </Disclosure>
    )
}

export default FilterContainer
{/* <Disclosure {...props} as="div" className="border-b border-gray-200 py-5" defaultOpen={defaultOpen}>
            {({ open = true }) => (
                <>
                    <h3 className="">
                        <DisclosureButton className="flex w-full items-center justify-between mb-4 ">
                            <span className="font-medium text-gray-900 text-sm">{title}</span>
                            <span className="ml-6 flex items-center">
                                {open ? (
                                    <MinusIcon className="h-5 w-5" aria-hidden="true" />
                                ) : (
                                    <PlusIcon className="h-5 w-5" aria-hidden="true" />
                                )}
                            </span>
                        </DisclosureButton>
                    </h3>

                    <DisclosurePanel transition
                        className="origin-top transition duration-200 ease-out data-[closed]:-translate-y-6 data-[closed]:opacity-0">

<div >
    {children}
</div>
                    </DisclosurePanel >
                </>
            )}
        </Disclosure > */}
