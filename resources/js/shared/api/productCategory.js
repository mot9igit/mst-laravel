export default function (instance) {
    return {
        getProductCategories(payload) {
            const data = instance
                .get(`/api/product/category/`, { params: payload })
            return data
        },
        getProductCategory(categoryId) {
            const data = instance
                .get(`/api/product/category/${categoryId}`)
            return data
        }
    }
}
