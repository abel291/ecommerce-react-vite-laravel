import Badge from '@/Components/Badge'
import { Radio, RadioGroup } from '@headlessui/react'
import React from 'react'

const SelectColor = ({ colors, selectedColor, setSelectedColor }) => {
    return (
        <div>
            <h3 className="text-sm font-medium text-gray-900">Color</h3>

            <fieldset aria-label="Choose a color" className="mt-4">
                <RadioGroup value={selectedColor} onChange={setSelectedColor} className="flex items-center space-x-3">
                    {colors.map((color) => (
                        <Radio
                            key={color.id}
                            value={color}
                            aria-label={color.name}
                            className='ring-gray-400 relative flex cursor-pointer items-center justify-center rounded-full p-[3px] focus:outline-none data-[checked]:ring data-[focus]:data-[checked]:ring data-[focus]:data-[checked]:ring-offset-1'>
                            <span
                                aria-hidden="true"
                                style={{ background: color.hex }}
                                className='h-8 w-8 rounded-full border border-black/10'
                            />
                        </Radio>
                    ))}
                </RadioGroup>
            </fieldset>
        </div>
    )
}

export default SelectColor
