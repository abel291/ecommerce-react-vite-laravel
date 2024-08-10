import { formatDate } from '@/Helpers/helpers'
import React from 'react'

function BuyerDetails({ order }) {

    return (
        <div className="grid lg:grid-cols-12 gap-3 ">
            <div className="lg:col-span-7">
                <div className="space-y-4">
                    <OrderDetailsList title="Facturado a" >
                        <div className="block ">{order.user.name}</div>
                    </OrderDetailsList>

                    <OrderDetailsList title="Detalles de envío" >
                        <div>{order.user.email}</div>
                        <div>{order.user.phone}</div>
                        <address className="not-italic font-normal">
                            {order.user.address}
                        </address>
                    </OrderDetailsList>
                    {order.user.note && (
                        <OrderDetailsList title="Nota Adicional" >
                            {order.user.note}
                        </OrderDetailsList>
                    )}

                </div>
            </div>
            {/* Col */}

            <div className="lg:col-span-5">
                <div className="space-y-4">
                    <OrderDetailsList title="Serial de factura" >
                        {order.code}
                    </OrderDetailsList>

                    {/* <OrderDetailsList title="Moneda" >
						USD - US Dollar
					</OrderDetailsList> */}

                    <OrderDetailsList title="Fecha de Compra" >
                        {formatDate(order.created_at)}
                        <span className='text-gray-500 block'>{order.createdAtRelative}</span>
                    </OrderDetailsList>

                    <OrderDetailsList title="Método de Pago" >
                        {order.payment.method}
                    </OrderDetailsList>
                </div>
            </div>
        </div>
    )
}

const OrderDetailsList = ({ title, children }) => {

    return (
        <dl>
            <dt className=" font-semibold text-gray-800">
                {title}:
            </dt>
            <dd className="text-gray-800 mt-1 text-sm">
                {children}
            </dd>
        </dl>
    )

}

export default BuyerDetails
