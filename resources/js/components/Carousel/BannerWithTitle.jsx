const BannerWithTitle = ({ title, subTitle = "explorar", image }) => {
	return (
		<div className="relative flex items-center justify-center h-48 lg:h-80 ">
			<div className="text-white text-center z-10">
				<span className="font-light text-xl italic">{subTitle}</span>
				<h1 className="font-bold text-3xl tracking-wide">{title}</h1>
			</div>
			<div className="absolute inset-0 filter brightness-75">
				<img className=" w-full h-full object-cover" src={image} alt="contact-us" />
			</div>
		</div>
	)
}

export default BannerWithTitle
