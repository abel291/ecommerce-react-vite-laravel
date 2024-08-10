import { CheckCircleIcon, XCircleIcon, XMarkIcon, } from '@heroicons/react/24/solid'
import React from 'react'
import { toast } from 'react-hot-toast'
import ContainerToast from './ContainerToast'

const SuccessToast = ({ toast, onDismiss, title = "dd" }) => {

	return (
		<ContainerToast toast={toast}>
			<div className='p-4 bg-green-50 w-full'>
				<div className='flex'>
					<div className='shrink-0'>
						<CheckCircleIcon className='text-green-400 h-5 w-5' />
					</div>
					<div className='ml-3 grow'>
						<h3 className='text-green-800 font-medium text-sm'>
							{title}
						</h3>
					</div>
					<div className='text-green-800 text-sm justify-self-end font-medium'>
						<button onClick={onDismiss} className="">
							<XMarkIcon className='text-green-500 h-5 w-5' />
						</button>
					</div>
				</div>
			</div>
		</ContainerToast >

	)
}

export default SuccessToast