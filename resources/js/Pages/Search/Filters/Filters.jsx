import React, { useContext } from "react";
import FiltersSelected from "./FiltersSelected";
import { usePage } from "@inertiajs/react";

import FilterContainer from "./FilterContainer";

import FilterCheckbox from "./FilterCheckbox";
import { SearchContext } from "../Search";
import FilterPrice from "./FilterPrice";


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
];
const Filters = () => {

    const form = useContext(SearchContext);

    const { listDepartments, listCategories, listColors, listSizes, listBrands } = usePage().props;

    const changeFilterCheckbox = (filterName, optionsChecked) => {
        form.setData(filterName, optionsChecked);
    };

    const changeFilterAttributes = (attributeName, newAttributeValues) => {

        form.setData("attributes", {
            ...form.data.attributes,
            [attributeName]: newAttributeValues,
        });
    };

    return (
        <div className="divide-y divide-gray-200 ">

            <div className="pb-5">
                <FiltersSelected
                    data={form.data}
                    setData={form.setData}
                    changeFilterAttributes={changeFilterAttributes}
                    changeFilter={changeFilterCheckbox}
                />
            </div>

            <FilterContainer title="Departamentos">
                <FilterCheckbox
                    optionsList={listDepartments}
                    optionsChecked={form.data.departments || []}
                    changeFilterCheckbox={changeFilterCheckbox}
                    filterName="departments"
                />
            </FilterContainer>

            <FilterContainer title="Categorias">
                <FilterCheckbox
                    optionsList={listCategories}
                    optionsChecked={form.data.categories || []}
                    changeFilterCheckbox={changeFilterCheckbox}
                    filterName="categories"
                />
            </FilterContainer>

            <FilterContainer title="Colores">
                <FilterCheckbox
                    optionsList={listColors}
                    optionsChecked={form.data.colors || []}
                    changeFilterCheckbox={changeFilterCheckbox}
                    filterName="colors"
                />
            </FilterContainer>

            <FilterContainer title="Tallas">
                <FilterCheckbox
                    optionsList={listSizes}
                    optionsChecked={form.data.sizes || []}
                    changeFilterCheckbox={changeFilterCheckbox}
                    filterName="sizes"
                />
            </FilterContainer>


            {/* {listAttributes.map((attribute, key) => (
                <FilterContainer key={key} title={attribute.name} defaultOpen={true}>
                    <FilterCheckbox
                        optionsList={attribute.attribute_values}
                        optionsChecked={
                            (form.data.attributes && form.data.attributes[attribute.slug]) || []
                        }
                        changeFilterCheckbox={changeFilterAttributes}
                        filterName={attribute.slug}
                    />
                </FilterContainer>
            ))} */}

            <FilterContainer title="Precio">
                <FilterPrice data={form.data} setData={form.setData} />
            </FilterContainer>

            {/* <FilterContainer title="Ofertas">
                <FilterRadio
                    options={offers}
                    data={data}
                    setData={form.setData}
                    filterName="offer"
                />
            </FilterContainer>
            {(listBrands.length > 1) && (
                <FilterContainer title="Marcas">
                    <FilterCheckbox
                        optionsList={listBrands}
                        optionsChecked={data.brands || []}
                        changeFilterCheckbox={changeFilterCheckbox}
                        filterName="brands"
                    />
                </FilterContainer>
            )} */}
        </div>
    );
};

export default Filters;

export const FilterTitle = ({ children }) => {
    return <h3 className="font-medium mb-4 ">{children}</h3>;
};
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
