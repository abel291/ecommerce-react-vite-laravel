import React from 'react'
import FiltersSelected from './FiltersSelected'
import { usePage } from '@inertiajs/react'
import FilterButton from './FilterButton'
import FilterPrice from './FilterPrice'
import FilterRadio from './FilterRadio'
import FilterContainer from './FilterContainer'
import FilterAttribute from './FilterAttribute'
import FilterCheckbox from './FilterCheckbox'

const offers = [
    {
        name: "Desde 10%",
        slug: "10",
    },
    {
        name: "Desde 20%",
        slug: "20",
    },
    {
        name: "Desde 30%",
        slug: "30",
    },
    {
        name: "Desde 40%",
        slug: "40",
    },
]
const Filters = ({ data, setData }) => {

    const { listDepartments, listCategories, listAttributes, listBrands } = usePage().props



    const changeFilterCheckbox = (filterName, value, selected) => {
        let optionsCheckbox = []
        switch (filterName) {
            case 'categories':
                optionsCheckbox = listCategories
                break;
            case 'departments':
                optionsCheckbox = listDepartments
                break;
            case 'brands':
                optionsCheckbox = listBrands
                break;
        }

        let optionsSelected = generateArraySlug(optionsCheckbox, value, selected)
        setData(filterName, optionsSelected)
    }

    const generateArraySlug = (optionsCheckbox, value, selected) => {
        return optionsCheckbox.filter((item) => {

            if (item.slug == value) {
                return selected
            }
            return item.selected

        }).map((item) => {
            return item.slug
        })
    }

    const changeAttribute = (attributeSlug, value, selected) => {

        const attribute = listAttributes.find(attribute => attribute.slug == attributeSlug)

        const attributeValues = generateArraySlug(attribute.attribute_values, value, selected)

        setData('attributes', { ...data.attributes, [attributeSlug]: attributeValues })
    }

    return (
        <div className="divide-y divide-gray-200 space-y-5">
            <div>
                <FiltersSelected
                    data={data}
                    setData={setData}
                    changeAttribute={changeAttribute}
                    changeFilter={changeFilterCheckbox}
                />
            </div>

            <FilterContainer title="Departamentos">
                <FilterCheckbox
                    optionsList={listDepartments}
                    changeFilter={changeFilterCheckbox}
                    filterName="departments"
                />
            </FilterContainer>

            <FilterContainer title="Categorias">
                <FilterCheckbox
                    optionsList={listCategories}
                    changeFilter={changeFilterCheckbox}
                    filterName="categories"
                />
            </FilterContainer>


            {listAttributes.map((attribute, key) => (
                <FilterContainer key={key} title={attribute.name}>
                    <FilterCheckbox
                        optionsList={attribute.attribute_values}
                        changeFilter={changeAttribute}
                        filterName={attribute.slug}
                    />
                </FilterContainer>
            ))}



            <FilterContainer title="Precio">
                <FilterPrice data={data} setData={setData} />
            </FilterContainer>

            <FilterContainer title="Ofertas">
                <FilterRadio
                    options={offers}
                    data={data}
                    setData={setData}
                    filterName="offer"

                />
            </FilterContainer>
            <FilterContainer title="Marcas">
                <FilterCheckbox
                    optionsList={listBrands}
                    changeFilter={changeFilterCheckbox}
                    filterName="brands"
                />
            </FilterContainer>

        </div >
    )
}

export default Filters

export const FilterTitle = ({ children }) => {
    return (<h3 className="font-medium mb-4 ">{children}</h3>);
}
// export const FilterContainer = ({ title = "", children }) => {
// 	return (
// 		<div className="py-5 max-h-96 mr-5">
// 			<FilterTitle>{title}</FilterTitle>
// 			<div>
// 				{children}
// 			</div>
// 		</div>
// 	)
// }
