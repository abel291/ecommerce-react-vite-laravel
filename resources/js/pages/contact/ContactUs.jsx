import BannerWithTitle from "../../components/BannerWithTitle"
import ContactAddress from "./ContactAddress"
import ContactForm from "./ContactForm"
const ContactUs = () => {

    return (
        <div>
            <BannerWithTitle title="Contáctenos" image="/img/contact-us/banner.jpg" />
            <div className="container ">

                <div className="flex flex-col lg:flex-row py-content">
                    <div className="w-full lg:w-5/12  my-8  lg:my-0 lg:mr-8">
                        <ContactAddress />
                    </div>
                    <div className="w-full lg:w-7/12  ">
                        <ContactForm />
                    </div>
                </div>
            </div>
        </div>
    )
}

export default ContactUs
