export default function (instance) {
    return {
        getStores(payload) {
            const data = instance
                .get('/api/integration/store/', {params: payload})
            return data
        },
        getStore(storeId) {
            const data = instance
                .get(`/api/integration/store/${storeId}`)
            return data
        },
    }
}
