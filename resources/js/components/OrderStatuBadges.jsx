import { CheckIcon, ReceiptRefundIcon, XIcon } from "@heroicons/react/solid";
import React from "react";

const OrderStatuBadges = ({ status }) => {
    return (
        <div className="text-xs font-semibold">
            {status == "successful" && (
                <div className="inline-flex items-center rounded-lg  bg-green-500 px-2 leading-5 text-white  ">
                    <span>Aprobado</span>
                    <CheckIcon className="ml-1 h-4 w-4" />
                </div>
            )}
            {status == "refunded" && (
                <div className="inline-flex items-center rounded-lg  bg-red-500 px-2 leading-5 text-white  ">
                    <span>Reembolsado</span>
                    <ReceiptRefundIcon className="ml-1 h-4 w-4" />
                </div>
            )}
            {status == "canceled" && (
                <div className="inline-flex items-center rounded-lg  bg-gray-500 px-2 leading-5 text-white  ">
                    <span>Cancelado</span>
                    <XIcon className="ml-1 h-4 w-4" />
                </div>
            )}
        </div>
    );
};

export default OrderStatuBadges;
