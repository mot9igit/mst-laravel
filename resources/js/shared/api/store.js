export default function (instance) {
    return {
        getStores() {
            const data = instance
                .get('/api/integration/store/')
            return data
        },
        getStore(storeId) {
            const data = instance
                .get(`/api/integration/store/${storeId}`)
            return data
        },
    }
}
