const TitlePage = ({title,subTitle}) => {
    return (
        <div className="">
            <h2 className="text-2xl  md:text-3xl font-semibold mb-2">{title}</h2>
            <span className="">{subTitle}</span>
        </div>
    )
}

export default TitlePage
