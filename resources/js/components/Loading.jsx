import React, { Fragment } from "react";
import { Transition } from '@headlessui/react'
export default function Loading({ isLoading ,styleClass='fixed' }) {
  return (
    <Transition
          as={Fragment}
          show={isLoading}
          enter="transform transition-opacity duration-300 "
          enterFrom="opacity-0  scale-95"
          enterTo="opacity-100 scale-100"
          leave="transition-opacity transform duration-300"
          leaveFrom="opacity-100 scale-100"
          leaveTo="opacity-0 scale-95"          
        >
    <div className={"flex inset-0 blur items-center justify-center z-50 "+styleClass}
    >
      <div className="inline-flex items-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-orange-500 ">
        <svg
          className="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
        >
          <circle
            className="opacity-25"
            cx="12"
            cy="12"
            r="10"
            stroke="currentColor"
            strokeWidth="4"
          ></circle>
          <path
            className="opacity-75"
            fill="currentColor"
            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
          ></path>
        </svg>
        <span>Cargando....</span>
      </div>
    </div>
    </Transition>
  );
}
