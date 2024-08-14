import { useRef } from "react"

const ImagesProduct = ({ product }) => {
    const imgShowRef = useRef()
    const handleClickImg = (urlImg) => {
        imgShowRef.current.src = urlImg
    }

    const allImages = [{
        id: 'principal-image',
        alt: product.slug,
        img: product.img,
    }, ...product.images]
    return (
        <div className="">
            <div className="w-full ">
                <div className="flex justify-center h-[400px]">
                    <img ref={imgShowRef} className="object-contain " src={allImages[0].img} alt="" />
                </div>
            </div>
            <div className="w-full  mt-5 ">
                <div className="flex justify-center gap-2 flex-wrap">

                    {allImages.map((image) => (
                        <button
                            onClick={() => handleClickImg(image.img)}
                            key={image.id}
                            className="p-1 rounded-lg h-20 w-20  flex justify-center items-center "
                        >
                            <img src={image.img} alt={image.alt} className="max-h-full rounded object-contain" />
                        </button>
                    ))}
                </div>
            </div>

        </div>
    )
}

export default ImagesProduct
