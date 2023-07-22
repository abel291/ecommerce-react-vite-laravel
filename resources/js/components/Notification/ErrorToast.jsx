import { XCircleIcon, XMarkIcon } from '@heroicons/react/24/solid'
import React from 'react'
import { toast } from 'react-hot-toast'
import ContainerToast from './ContainerToast'

const ErrorToast = ({ toast, onDismiss, errors = [] }) => {

	return (
		<ContainerToast toast={toast}>
			<div className='p-4 bg-red-50 w-full'>
				<div className='flex'>
					<div className='shrink-0'>
						<XCircleIcon className='text-red-400 h-5 w-5' />
					</div>
					<div className='ml-3 grow'>
						<h3 className='text-red-800 font-medium text-sm'>
							Hubo {errors.length} errores con su envío
						</h3>
						<div className='text-sm mt-2'>
							<ul role="list" className='text-red-700 pl-5 list-disc space-y-1'>
								{Object.values(errors).map((value) => (
									<li>{value}</li>
								))}
							</ul>
						</div>
					</div>
					<div className='text-red-800 text-sm justify-self-end font-medium'>
						<button onClick={onDismiss} className="">
							<XMarkIcon className='text-red-500 h-4 w-4' />
						</button>
					</div>
				</div>
			</div>
		</ContainerToast >

	)
}

export default ErrorToast