import React from 'react'
import { useState } from "react"
import Button from "../../components/Button"
import Notifications from '../../components/Notifications'

const ContactForm = () => {
    const [loading, setLoading] = useState(false)
    const [notification, setNotification] = useState({
        type: "",
        title: "Datos enviados.",
        subTitle: "",
        scrollUp:false
    })
    const [contactData, setContactData] = useState({
        name: "asd",
        email: "user@user.com",
        subject: "123",
        message: "123"
    })
    const handleChange = (e) => {
        setContactData({ ...contactData, [e.target.name]: e.target.value })
    }
    const handleSubmit = (e) => {
        e.preventDefault()
        setLoading(true)
        setNotification({ ...notification, type: '' })
        setTimeout(() => {
            setLoading(false)
            setNotification({ ...notification, type: 'ok' })
        }, 1000);
    }
    return (
        <div><div className="mb-4">
            <Notifications {...notification}/>
        </div>
            <div>
                <h3 className="font-bold text-2xl mb-6 ">Ponerse en contacto</h3>
                <div>
                    <form className="space-y-5" onSubmit={handleSubmit}>
                        <div className="flex  space-x-2">
                            <div className="w-1/2 ">
                                <label className="text-sm font-medium" htmlFor="name">
                                    Nombre *
                                </label>
                                <input value={contactData.name}
                                    onChange={handleChange}
                                    required
                                    type="text"
                                    className="mt-2 px-5 py-3 w-full text-sm border border-gray-100"
                                    placeholder="Ingrese su nombre"
                                    name="name"
                                />
                            </div>
                            <div className="w-1/2">
                                <label className="text-sm font-medium" htmlFor="email">
                                    Email *
                                </label>
                                <input value={contactData.email}
                                    onChange={handleChange}
                                    required
                                    type="text"
                                    className="mt-2 px-5 py-3 w-full text-sm border border-gray-100"
                                    placeholder="Ingrese su email"
                                    name="email"
                                />
                            </div>
                        </div>
                        <div className="">
                            <label className="text-sm font-medium" htmlFor="subject">
                                Asunto *
                            </label>
                            <input value={contactData.subject}
                                onChange={handleChange}
                                required
                                type="text"
                                className="mt-2 px-5 py-3 w-full text-sm border border-gray-100"
                                placeholder="Ingrese el asunto"
                                name="subject"
                            />
                        </div>
                        <div className="">
                            <label className="text-sm font-medium block" htmlFor="message">
                                Mensaje *
                            </label>
                            <textarea value={contactData.message}
                                onChange={handleChange} className="w-full mt-2 block" name="message" id="" rows="3"></textarea>
                        </div>
                        <Button isLoading={loading} >Enviar Mensaje</Button>

                    </form>
                </div>
            </div></div>
    )
}

export default ContactForm