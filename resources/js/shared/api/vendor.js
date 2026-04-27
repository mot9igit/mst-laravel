export default function (instance) {
    return {
        getVendors(payload) {
            const data = instance
                .get('/api/product/vendor/', {params: payload})
            return data
        },
        getVendor(storeId) {
            const data = instance
                .get(`/api/product/vendor/${storeId}`)
            return data
        },
    }
}
