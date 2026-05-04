export default function (instance) {
    return {
        getCatalogs(storeId, payload) {
            const data = instance
                .get(`/api/integration/store/${storeId}/catalog`, {params: payload})
            return data
        },
        getCatalog(storeId, catalogId) {
            const data = instance
                .get(`/api/integration/store/${storeId}/catalog/${catalogId}`)
            return data
        },
    }
}
