import { ClockIcon } from "@heroicons/react/24/outline";
import { CheckIcon, ReceiptRefundIcon, XMarkIcon } from "@heroicons/react/24/solid";


const OrderStatuBadges = ({ status }) => {
	return (
		<div className="text-xs font-semibold">
			{status == "success" && (
				<div className="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20 ">
					<span>Aprobado</span>
					<CheckIcon className="ml-1 h-4 w-4" />
				</div>
			)}
			{status == "refunded" && (
				<div className="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
					<span>Reembolsado</span>
					<ReceiptRefundIcon className="ml-1 h-4 w-4" />
				</div>
			)}
			{status == "canceled" && (
				<div className="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
					<span>Cancelado</span>
					<XMarkIcon className="ml-1 h-4 w-4" />
				</div>
			)}
			{status == "pending" && (
				<div className="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
					<span>Pendiente</span>
					<ClockIcon className="ml-1 h-4 w-4" />
				</div>
			)}
		</div>
	);
};

export default OrderStatuBadges;
