import { XCircleIcon, XMarkIcon } from '@heroicons/react/24/solid'
import React from 'react'
import { toast } from 'react-hot-toast'

const ContainerToast = ({ toast, children }) => {

	return (

		<div
			className={`${toast.visible ? 'animate-enter' : 'animate-leave'
				} max-w-md w-full bg-white shadow-lg overflow-hidden rounded-lg pointer-events-auto flex ring-1 ring-black ring-opacity-5`}
		>
			{children}
		</div>
	)
}

export default ContainerToast