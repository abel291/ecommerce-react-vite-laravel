import { usePage } from '@inertiajs/react';
import toast, { Toaster } from 'react-hot-toast';
import { useEffect } from 'react';

import { XCircleIcon, XMarkIcon } from '@heroicons/react/24/solid';
import ErrorToast from './ErrorToast';
import SuccessToast from './SuccessToast';
const NotificationToast = () => {
    const { flash, errors } = usePage().props

    useEffect(() => {
        toast.remove()
        flash.success && toast.custom((t) => <SuccessToast title={flash.success} toast={t} onDismiss={() => toast.dismiss(t.id)} />);
        flash.error && toast.custom((t) => <ErrorToast errors={[flash.error]} toast={t} onDismiss={() => toast.dismiss(t.id)} />)

        const errorsArray = Object.values(errors);
        (errorsArray.length > 0)
            &&
            toast.custom((t) => <ErrorToast errors={errorsArray} toast={t} onDismiss={() => toast.dismiss(t.id)} />)

    }, [flash])

    return (
        <div>
            <Toaster
                position="top-right"
                reverseOrder={false}
                toastOptions={{
                    custom: {
                        duration: 4000,

                    }
                }}
            />
        </div>
    )
}

const errorAlert = (errors = []) => {

    return (toast.custom((t) =>
    (
        <div
            className={`${t.visible ? 'opacity-100 scale-100' : 'opacity-0 scale-75'
                } max-w-md transition-all transform w-full shadow-lg pointer-events-auto opacity-0 scale-100`}
        >
            <div className='p-4 bg-red-50 rounded-md w-full'>
                <div className='flex'>
                    <div className='shrink-0'>
                        <XCircleIcon className='text-red-400 h-5 w-5' />
                    </div>
                    <div className='ml-3 grow'>
                        <h3 className='text-red-800 font-medium text-sm'>
                            Hubo errores con su envío
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
                        <button onClick={() => toast.dismiss(t.id)} className="">
                            <XMarkIcon className='text-red-500 h-4 w-4' />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    )))
}

export default NotificationToast
